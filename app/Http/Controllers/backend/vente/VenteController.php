<?php

namespace App\Http\Controllers\backend\vente;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vente;
use App\Models\Caisse;
use App\Models\Produit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ClotureCaisse;
use App\Models\HistoriqueCaisse;
use Illuminate\Routing\RouteAction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\backend\user\AdminController;

class VenteController extends Controller
{

    public function index(Request $request)
    {
        try {

            // $data_vente = Vente::with('produits')
            //     ->where('caisse_id', auth()->user()->caisse_id)
            //     ->where('user_id', auth()->user()->id)
            //     ->whereDate('created_at', today())
            //     ->whereStatut('confirmée',)
            //     ->where('statut_cloture', false)
            //     ->orderBy('created_at', 'desc')
            //     ->get();
            $caisses = Caisse::all();


            $query = Vente::with('produits')
                ->whereStatut('confirmée')
                ->orderBy('created_at', 'desc');

            // Filtre par date
            if ($request->filled('date_debut') && $request->filled('date_fin')) {
                $query->whereBetween('created_at', [$request->date_debut, $request->date_fin]);
            } elseif ($request->filled('date_debut')) {
                $query->whereDate('created_at', '>=', $request->date_debut);
            } elseif ($request->filled('date_fin')) {
                $query->whereDate('created_at', '<=', $request->date_fin);
            }

            // Filtre par caisse
            if ($request->filled('caisse')) {
                $query->where('caisse_id', $request->caisse);
            }

            if ($request->user()->hasRole('caisse')) {
                $query->where('caisse_id', auth()->user()->caisse_id)
                    ->where('user_id', auth()->user()->id)
                    ->where('statut_cloture', false);
            }

            $data_vente = $query->get();
            // dd($data_vente->toArray());

            return view('backend.pages.vente.index', compact('data_vente', 'caisses'));
        } catch (\Exception $e) {
            Alert::error('Erreur', 'Une erreur est survenue lors du chargement des ventes : ' . $e->getMessage());
            return back();
        }
    }

    public function create()
    {
        try {
            $data_produit = Produit::active()->whereHas('categorie', function ($query) {
                $query->whereIn('famille', ['bar', 'menu']);
            })
                ->with(['categorie' ,'variantes'])
                ->get();
            // ->where(function ($query) {
            //     $query->whereHas('categorie', function ($subQuery) {
            //         $subQuery->where('famille', 'menu');
            //     })
            //         ->orWhere(function ($subQuery) {
            //             $subQuery->whereHas('categorie', function ($subSubQuery) {
            //                 $subSubQuery->where('famille', 'bar');
            //             })->whereHas('achats', function ($achatsQuery) {
            //                 $achatsQuery->where('statut', 'active');
            //             });
            //         });
            // })
            // ->with(['categorie', 'achats' => function ($query) {
            //     $query->where('statut', 'active')->orderBy('created_at', 'asc');
            // }])


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
            // $request->validate([
            //     // 'client_id' => 'required|exists:users,id',
            //     // 'date_vente' => 'required|date',
            //     'produit_id' => 'required|array',
            //     'produit_id.*' => 'exists:produits,id',
            //     'quantite' => 'required|array',
            //     'quantite.*' => 'numeric|min:1',
            //     'prix_unitaire' => 'required|array',
            //     'prix_unitaire.*' => 'numeric|min:0',
            //     'sous_total' => 'required|array',
            //     'sous_total.*' => 'numeric|min:0',
            // ]);


            //recuperation des informations depuis ajax
            $cart = $request->input('cart');
            $montantAvantRemise = $request->input('montantAvantRemise');
            $montantApresRemise = $request->input('montantApresRemise');
            $montantRemise = $request->input('montantRemise');
            $typeRemise = $request->input('typeRemise');
            $valeurRemise = $request->input('valeurRemise');
            $modePaiement = $request->input('modePaiement');
            $montantRecu = $request->input('montantRecu');
            $montantRendu = $request->input('montantRendu');
            $numeroDeTable = $request->input('numeroDeTable');
            $nombreDeCouverts = $request->input('nombreDeCouverts');


            // Création de la vente
            // Obtenir les deux premières lettres du nom de la caissière
            $initialesCaissiere = substr(auth()->user()->first_name, 0, 2);
            $initialesCaisse = substr(auth()->user()->caisse->libelle, 0, 2);

            // Obtenir le numéro d'ordre de la vente pour aujourd'hui
            $nombreVentes = Vente::count();
            $numeroOrdre = $nombreVentes + 1;

            // Obtenir la date et l'heure actuelles
            $dateHeure = now()->format('dmYHi');

            // Générer le code de vente
            $codeVente = strtoupper($initialesCaissiere) . '-' . strtoupper($initialesCaisse) . $numeroOrdre . $dateHeure;
            $vente = Vente::create([
                'code' => $codeVente,
                // 'client_id' => $request->client_id,
                'caisse_id' => auth()->user()->caisse_id, // la caisse qui fait la vente
                'user_id' => auth()->user()->id, // l'admin qui a fait la vente
                'date_vente' => Carbon::now(),
                'montant_total' => $montantApresRemise,
                'montant_avant_remise' => $montantAvantRemise,
                'montant_remise' => $montantRemise,
                'type_remise' => $typeRemise,
                'valeur_remise' => $valeurRemise,
                'mode_paiement' => $modePaiement,
                'montant_recu' => $montantRecu,
                'montant_rendu' => $montantRendu,
                'numero_table' => $numeroDeTable,
                'nombre_couverts' => $nombreDeCouverts,
                'statut' => 'confirmée',
                'type_vente' => 'normale'
            ]);

            // Préparation des données pour la table pivot

            foreach ($cart as $item) {
                // Attachement des produits à la vente
                $vente->produits()->attach($item['id'], [
                    'quantite' => $item['quantity'],
                    'prix_unitaire' => $item['price'],
                    'total' => $item['price'] * $item['quantity']
                ]);

                // Mise à jour du stock du produit
                $produit = Produit::find($item['id']);
                $quantiteVendue = $item['quantity'];

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
            $idVente = $vente->id;

            // retur response
            return response()->json([
                'message' => 'Vente enregistrée avec succès.',
                'status' => 'success',
                'idVente' => $idVente,

            ], 200);
        } catch (\Throwable $th) {
            return $th->getMessage();
            // Alert::error('Erreur', 'Une erreur est survenue lors de la création de la vente : ' . $th->getMessage());
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

            //deconnecter l'utilisateur et enregistrer l'historique caisse
            // Si l'utilisateur a une caisse active, la désactiver
            if ($user->caisse_id) {

                // niveau caisse
                $caisse = Caisse::find($user->caisse_id);
                $caisse->statut = 'desactive';
                $caisse->save();
                // mettre caisse_id a null
                User::whereId($user->id)->update([
                    'caisse_id' => null,
                ]);

                //mise a jour dans historiquecaisse pour fermeture de caisse
                HistoriqueCaisse::where('user_id', $user->id)
                    ->where('caisse_id', $user->caisse_id)
                    ->whereNull('date_fermeture')
                    ->update([
                        'date_fermeture' => now(),
                    ]);
            }


            Auth::logout();
            Alert::success('Succès', 'Caisse cloturée avec succès');
            return redirect()->route('admin.login');


        } catch (\Exception $e) {
            Alert::error('Erreur', 'Une erreur est survenue lors de la cloture de la caisse : ' . $e->getMessage());
            return back();
        }
    }
}
