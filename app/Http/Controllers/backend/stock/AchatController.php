<?php

namespace App\Http\Controllers\backend\stock;

use App\Models\Achat;
use App\Models\Stock;
use App\Models\Unite;
use App\Models\Format;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AchatController extends Controller
{
    //

    public function index()
    {
        try {
            $data_achat = Achat::get();
            // dd($data_achat->toArray());
            return view('backend.pages.stock.achat.index', compact('data_achat'));
        } catch (\Throwable $e) {
            return  $e->getMessage();
        }
    }

    public function create(Request $request)
    {

        try {
            $data_categorie = Categorie::whereNull('parent_id')->with('children', fn($q) => $q->OrderBy('position', 'ASC'))->withCount('children')->OrderBy('position', 'ASC')->get();
            $data_produit = Produit::with(['categorie.ancestors', 'media'])->get();
            $type_produit = Categorie::whereNull('parent_id')->whereIn('type', ['boissons', 'ingredients'])->get();

            $data_format = Format::all();
            $data_unite = Unite::all();
            $data_fournisseur = Fournisseur::all();

            // dd($data_produit->toArray());
            return view('backend.pages.stock.achat.create', compact('type_produit', 'data_categorie', 'data_produit', 'data_format', 'data_unite', 'data_fournisseur'));
        } catch (\Throwable $e) {
            return  $e->getMessage();
        }

        // dd($data_categorie->toArray());

    }

    public function store(Request $request)
    {
        try {
            dd($request->toArray());

            //statut stock libelle active ? desactive
            $statut = '';
            if ($request['statut'] == 'on') {
                $statut = 'active';
            } else {
                $statut = 'desactive';
            }

            //recuperer le type produit : bar ?restaurant            
            $type_produit = $request['type_produit'];
            $type_produit = Categorie::whereId($type_produit)->first();
            if ($type_produit->type == 'ingredients') {
                $request->validate([
                    // 'produit_id' => 'required',
                    // 'quantite_format' => 'required',
                    // 'format_id' => 'required',
                    // 'unite_id' => 'required',
                    // 'quantite_stockable' => 'required',
                    // 'fournisseur_id' => '',
                    // 'prix_achat_unitaire' => 'required',
                    // 'prix_achat_total' => 'required',
                    // 'statut' => '',

                    'numero_facture' => 'required|string|max:255',
                    'fournisseur_id' => 'required|exists:fournisseurs,id',
                    'produit_id.*' => 'required|exists:produits,id',
                    'quantite_acquise.*' => 'required|numeric|min:1',
                    'format_id.*' => 'required|exists:formats,id',
                    'quantite_format.*' => 'required|numeric|min:1',
                    'prix_unitaire_format.*' => 'required|numeric|min:0',
                ]);
            } elseif ($type_produit->type == 'boissons') {

                $request->validate([
                    'produit_id' => 'required',
                    'quantite_format' => 'required',
                    'format_id' => 'required',
                    'unite_id' => 'required',
                    // 'quantite_unite_unitaire' => 'required', // valeur par unite
                    // 'quantite_unite_total' => 'required', // --qte stockable
                    'quantite_stockable' => 'required',
                    'fournisseur_id' => '',
                    'prix_achat_unitaire' => 'required',
                    'prix_achat_total' => 'required',

                    //champs supplementaire
                    'prix_vente_unitaire' => 'required',
                    'prix_vente_total' => '',

                    'statut' => ''
                ]);
            }


            Achat::create([
                'code' => 'SA-' . strtoupper(Str::random(8)),
                'type_produit_id' => $type_produit->id,
                'produit_id' => $request['produit_id'],
                'format_id' => $request['format_id'],
                'unite_id' => $request['unite_id'],
                'fournisseur_id' => $request['fournisseur_id'],
                'quantite_format' => $request['quantite_format'],
                'quantite_stockable' => $request['quantite_stockable'],
                // 'quantite_unite_unitaire' => $request['quantite_unite_unitaire'],
                // 'quantite_unite_total' => $request['quantite_unite_total'],
                'prix_achat_unitaire' => $request['prix_achat_unitaire'],
                'prix_achat_total' => $request['prix_achat_total'],
                'prix_vente_unitaire' => $request['prix_vente_unitaire'],
                'prix_vente_total' => $request['prix_vente_unitaire'] * $request['quantite_stockable'],
                'statut' => $statut,
                'user_id' => Auth::id(),
            ]);


            //mise a jour du stock dans la table produit si le statut est active
            if ($statut == 'active') {
                $produit = Produit::find($request['produit_id']);
                $produit->stock += $request['quantite_stockable'];
                $produit->save();
            }


            Alert::success('Opération réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            $data_achat = Achat::find($id);

            $data_format = Format::all();
            $data_unite = Unite::all();
            $data_fournisseur = Fournisseur::all();
            return view('backend.pages.stock.achat.edit', compact('data_achat', 'data_format', 'data_unite', 'data_fournisseur'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data_achat = Achat::find($id);

            //statut stock libelle active ? desactive
            $statut = '';
            if ($request['statut'] == 'on') {
                $statut = 'active';
            } else {
                $statut = 'desactive';
            }

            $data_achat->update([
                'fournisseur_id' => $request['fournisseur_id'],
                'format_id' => $request['format_id'],
                'unite_id' => $request['unite_id'],
                'statut' => $statut,
            ]);

            //mise a jour du stock dans la table produit si le statut est active
            if ($statut == 'active') {
                $produit = Produit::find($data_achat['produit_id']);
                $produit->stock += $data_achat['quantite_stockable'];
                $produit->save();
            }
            //mise a jour du stock dans la table produit si le statut est desactive
            elseif ($statut == 'desactive') {
                $produit = Produit::find($data_achat['produit_id']);
                $produit->stock -= $data_achat['quantite_stockable'];
                $produit->save();
            }


            Alert::success('Opération réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
