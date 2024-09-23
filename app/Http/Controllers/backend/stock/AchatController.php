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
            $type_produit = Categorie::whereNull('parent_id')->whereIn('type', ['bar', 'restaurant'])->get();

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
            // dd($request->all());

            // récupérer les infos de produit en tableau
            foreach ($request->produit_id as $index => $produitId) {
                $produit = Produit::find($produitId);
                $categorie = Categorie::find($produit->categorie_id); // catégorie du produit

                // définir le statut du produit
                // $statut = $request->statut[$index] == 'on' ? 'active' : 'desactive';

                // récupérer le type de produit
                $type_produit = $categorie->famille;

                // validation en fonction du type de produit
                if ($type_produit == 'restaurant') {
                    $request->validate([
                        'numero_facture' => '',
                        'date_achat' => 'required',
                        'magasin_id' => '',
                        'statut' => '',
                        'produit_id.*' => 'required|exists:produits,id',
                        'fournisseur_id' => 'required',
                        'format_id.*' => 'required|min:1',
                        'quantite_format.*' => 'required|min:1',
                        'quantite_in_format.*' => 'required|min:1',
                        'quantite_stocke.*' => 'required|min:1',
                        'prix_unitaire_format.*' => 'required|min:1',
                        'prix_total_format.*' => 'required|min:1',
                        'prix_achat_unitaire.*' => 'required|min:1',
                        'prix_vente_unitaire.*' => '',
                        'unite_sortie.*' => 'required|min:1',
                    ]);
                } elseif ($type_produit == 'bar') {
                    $request->validate([
                        'numero_facture' => '',
                        'date_achat' => 'required',
                        'magasin_id' => '',
                        'statut' => '',
                        'produit_id.*' => 'required|exists:produits,id',
                        'fournisseur_id' => 'required',
                        'format_id.*' => 'required|min:1',
                        'quantite_format.*' => 'required|min:1',
                        'quantite_in_format.*' => 'required|min:1',
                        'quantite_stocke.*' => 'required|min:1',
                        'prix_unitaire_format.*' => 'required|min:1',
                        'prix_total_format.*' => 'required|min:1',
                        'prix_achat_unitaire.*' => 'required|min:1',
                        'prix_vente_unitaire.*' => 'required|min:1',
                        'unite_sortie.*' => 'required|min:1',
                    ]);
                }

                // création de l'achat
                Achat::create([
                    'code' => 'SA-' . strtoupper(Str::random(8)),
                    'type_produit_id' => $categorie->id,
                    'numero_facture' => $request->numero_facture,
                    'date_achat' => $request->date_achat,
                    'produit_id' => $request->produit_id[$index],
                    'fournisseur_id' => $request->fournisseur_id,
                    'format_id' => $request->format_id[$index],
                    'quantite_format' => $request->quantite_format[$index],
                    'quantite_in_format' => $request->quantite_in_format[$index],
                    'quantite_stocke' => $request->quantite_stocke[$index],
                    'prix_unitaire_format' => $request->prix_unitaire_format[$index],
                    'prix_total_format' => $request->prix_total_format[$index],
                    'prix_achat_unitaire' => $request->prix_achat_unitaire[$index],
                    'prix_vente_unitaire' => $request->prix_vente_unitaire[$index],
                    'unite_id' => $request->unite_sortie[$index],
                    'magasin_id' => $request->magasin_id,
                    'statut' => 'active',
                    'user_id' => Auth::id(),
                ]);

                // mise à jour du stock dans la table produit si le statut est 'active'
                $produit->stock += $request->quantite_stocke[$index];
                $produit->save();
                // if ($statut == 'active') {
                //     $produit->stock += $request->quantite_stocke[$index];
                //     $produit->save();
                // }
            }

            // succès après la boucle
            Alert::success('Opération réussie', 'Tous les produits ont été enregistrés avec succès.');
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
