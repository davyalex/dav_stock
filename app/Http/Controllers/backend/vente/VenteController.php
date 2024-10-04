<?php

namespace App\Http\Controllers\backend\vente;

use App\Models\User;
use App\Models\Vente;
use App\Models\Produit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ClotureCaisse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class VenteController extends Controller
{

    public function index()
    {
        try {
            $data_vente = Vente::with('produits')
                ->where('caisse_id', auth()->user()->caisse_id)
                ->where('user_id', auth()->user()->id)
                ->whereDate('created_at', today())
                ->whereStatut('confirmée',)
                ->where('statut_cloture', false)
                ->orderBy('created_at', 'desc')
                ->get();
            return view('backend.pages.vente.index', compact('data_vente'));
        } catch (\Exception $e) {
            Alert::error('Erreur', 'Une erreur est survenue lors du chargement des ventes : ' . $e->getMessage());
            return back();
        }
    }

    public function create()
    {
        try {
            $data_produit = Produit::whereHas('categorie', function ($query) {
                $query->whereIn('famille', ['bar', 'menu']);
            })
                ->where(function ($query) {
                    $query->whereHas('categorie', function ($subQuery) {
                        $subQuery->where('famille', 'menu');
                    })
                        ->orWhere(function ($subQuery) {
                            $subQuery->whereHas('categorie', function ($subSubQuery) {
                                $subSubQuery->where('famille', 'bar');
                            })->whereHas('achats', function ($achatsQuery) {
                                $achatsQuery->where('statut', 'active');
                            });
                        });
                })
                ->with(['categorie', 'achats' => function ($query) {
                    $query->where('statut', 'active')->orderBy('created_at', 'asc');
                }])
                ->get();

            // dd($data_produit->toArray());

            $data_client = User::whereHas('roles', function ($query) {
                $query->where('name', 'client');
            })->get();

            return view('backend.pages.vente.create', compact('data_produit', 'data_client'));
        } catch (\Exception $e) {
            // Gestion des erreurs
            return back()->with('error', 'Une erreur est survenue lors du chargement du formulaire de création : ' . $e->getMessage());
        }
    }


    public function store(Request $request)
    {
        try {
            // Validation des données
            $request->validate([
                // 'client_id' => 'required|exists:users,id',
                'date_vente' => 'required|date',
                'produit_id' => 'required|array',
                'produit_id.*' => 'exists:produits,id',
                'quantite' => 'required|array',
                'quantite.*' => 'numeric|min:1',
                'prix_unitaire' => 'required|array',
                'prix_unitaire.*' => 'numeric|min:0',
                'sous_total' => 'required|array',
                'sous_total.*' => 'numeric|min:0',
            ]);

            // Création de la vente
            $vente = Vente::create([
                'code' => 'V-' . strtoupper(Str::random(8)),
                // 'client_id' => $request->client_id,
                'caisse_id' => auth()->user()->caisse_id, // la caisse qui fait la vente
                'user_id' => auth()->user()->id, // l'admin qui a fait la vente
                'date_vente' => $request->date_vente,
                'montant_total' => $request->montant_total,
                'statut' =>'confirmée',
            ]);

            // Préparation des données pour la table pivot

            foreach ($request->produit_id as $index => $produitId) {
                // Attachement des produits à la vente
                $vente->produits()->attach(
                    $produitId,
                    [
                        'quantite' => $request->quantite[$index],
                        'prix_unitaire' => $request->prix_unitaire[$index],
                        'total' => $request->sous_total[$index],
                    ]
                );
                // Mise à jour du stock du produit
                $produit = Produit::find($produitId);
                $quantiteVendue = $request->quantite[$index];

                if ($produit->categorie->famille == 'bar') {
                    // Mise à jour du stock du produit
                    $produit->stock -= $quantiteVendue;
                    $produit->save();

                    // Mise à jour de la quantité stockée dans l'achat
                    $achat = $produit->achats()->latest()->first();
                    if ($achat) {
                        $achat->quantite_stocke -= $quantiteVendue;
                        $achat->save();
                    }
                }
            }


            // retur response
            return response()->json([
                'message' => 'Vente enregistrée avec succès.',
                'statut' => 'success',
            ], 200);
        } catch (\Throwable $th) {
            Alert::error('Erreur', 'Une erreur est survenue lors de la création de la vente : ' . $th->getMessage());
            return back();
        }
    }

    public function show($id)
    {
        try {
            $vente = Vente::find($id);
            return view('backend.pages.vente.show', compact('vente'));
        } catch (\Exception $e) {
            Alert::error('Erreur', 'Une erreur est survenue lors du chargement de la vente : ' . $e->getMessage());
            return back();
        }
    }


    public function clotureCaisse()
    {
        try {
            $user = Auth::user();
            $caisse = $user->caisse;

            // Calculer le montant total des ventes pour cette caisse
            $totalVentes = Vente::where('caisse_id', $caisse->id)->sum('montant_total');

            // Clôturer la caisse
            ClotureCaisse::create([
                'caisse_id' => $caisse->id,
                'user_id' => $user->id,
                'montant_total' => $totalVentes,
                'date_cloture' => now()
            ]);

            //desactive la caisse
            $caisse->statut = 'desactive';
            $caisse->save();

        
            //mettre statut_cloture a true
            Vente::where('caisse_id', $caisse->id)->update([
                'statut_cloture' => true,
            ]);

            Alert::success('Succès', 'Caisse cloturée avec succès');
            return back();
        } catch (\Exception $e) {
            Alert::error('Erreur', 'Une erreur est survenue lors de la cloture de la caisse : ' . $e->getMessage());
            return back();
        }
    }
}
