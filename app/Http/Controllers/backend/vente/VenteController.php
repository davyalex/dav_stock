<?php

namespace App\Http\Controllers\backend\vente;

use Carbon\Carbon;
use App\Models\Menu;
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
use Illuminate\Support\Facades\Session;
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
                ->with(['categorie', 'variantes'])
                ->get();

            // dd(Session::get('session_date'));

            $data_client = User::whereHas('roles', function ($query) {
                $query->where('name', 'client');
            })->get();




            ####################### // script pour la gestion de menu ##################
            // recuperer le menu du jour en session
            $cartMenu = Session::get('cartMenu');


            // Récupérer le menu du jour avec les produits, compléments et garnitures
            $menu = Menu::where('date_menu', Carbon::today()->toDateString())
                ->with([
                    'plats' => function ($query) {
                        $query->with([
                            'categorieMenu',  // Relation vers la catégorie de produit
                            'complements' => function ($query) {
                                $query->wherePivot('menu_id', function ($subQuery) {
                                    $subQuery->select('id')
                                        ->from('menus')
                                        ->where('date_menu', Carbon::today()->toDateString());
                                });
                            },
                            'garnitures' => function ($query) {
                                $query->wherePivot('menu_id', function ($subQuery) {
                                    $subQuery->select('id')
                                        ->from('menus')
                                        ->where('date_menu', Carbon::today()->toDateString());
                                });
                            }
                        ]);
                    },
                ])->first();

            // Vérifier s'il y a un menu
            if (!$menu) {
                return view('backend.pages.vente.create', ['menu' => null, 'categories' => [] , 'cartMenu' => $cartMenu , 'data_produit' => $data_produit, 'data_client' => $data_client] , );
            }

            // Grouper les produits par nom de catégorie et trier par position de catégorie
            $categories = $menu->plats
                ->groupBy(function ($plat) {
                    return $plat->categorieMenu->nom; // Grouper par le nom de la catégorie
                })
                ->sortBy(function ($group, $key) {
                    // Trier les groupes par la position des catégories
                    $categorie = $group->first()->categorieMenu;
                    return $categorie ? $categorie->position : 0; // Si une catégorie n'a pas de position, utiliser 0
                });



            // dd($menu->toArray);


            return view('backend.pages.vente.create', compact('data_produit', 'data_client', 'categories', 'menu', 'cartMenu'));
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

            //session de la date manuelle
            $sessionDate = Session::get('session_date', now()->toDateString());

            $vente = Vente::create([
                'code' => $codeVente,
                // 'client_id' => $request->client_id,
                'caisse_id' => auth()->user()->caisse_id, // la caisse qui fait la vente
                'user_id' => auth()->user()->id, // l'admin qui a fait la vente
                'date_vente' =>  Carbon::parse($sessionDate),
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
                    'total' => $item['price'] * $item['quantity'],
                    'unite_vente_id' => $item['selectedVariante'] ?? null,
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


    public function billeterieCaisse(Request $request)
    {
        try {

            $modes = [
                0 => 'Espèce',
                1 => 'Mobile money',
            ];

            $type_mobile_money = [
                0 => 'Wave',
                1 => 'Moov money',
                2 => 'Orange Money',
                3 => 'MTN money',
            ];

            $type_monnaies = [
                0 => 'Billets',
                1 => 'Pièces',
            ];

            $billets = [
                0 => 500,
                1 => 1000,
                2 => 2000,
                3 => 5000,
                4 => 10000,
            ];


            $pieces = [
                0 => 5,
                1 => 10,
                2 => 20,
                3 => 50,
                4 => 100,
                5 => 200,
                6 => 500,
            ];


            if ($request->user()->hasRole('caisse')) {
                $totalVente = Vente::where('caisse_id', auth()->user()->caisse_id)
                    ->where('user_id', auth()->user()->id)
                    ->where('statut_cloture', false)->sum('montant_total');
            }

            // dd($type_monnaies , $billets, $pieces, $totalVente);

            return view('backend.pages.vente.billeterie.create', compact('modes', 'type_monnaies', 'billets', 'pieces', 'totalVente', 'type_mobile_money'));
        } catch (\Throwable $th) {

            return $th->getMessage();
        }
    }



    public function sessionDate(Request $request)
    {

        try {
            $request->validate([
                'session_date' => 'required|date',
            ]);

            // Stocker la date dans la session 
            Session::put('session_date', $request->session_date);

            alert()->success('Succès', 'Date de session vente modifiée avec succès');
            return back();
        } catch (\Throwable $th) {
            Alert::error('Erreur', 'Une erreur est survenue lors de la création de la session : ' . $th->getMessage());
            return back();
        }
    }




    ############################################VENTE AU NIVEAU MENU##############################################
    public function createVenteMenu()
    {
        try {
            // recuperer le menu du jour en session
            $cartMenu = Session::get('cartMenu');


            // Récupérer le menu du jour avec les produits, compléments et garnitures
            $menu = Menu::where('date_menu', Carbon::today()->toDateString())
                ->with([
                    'plats' => function ($query) {
                        $query->with([
                            'categorieMenu',  // Relation vers la catégorie de produit
                            'complements' => function ($query) {
                                $query->wherePivot('menu_id', function ($subQuery) {
                                    $subQuery->select('id')
                                        ->from('menus')
                                        ->where('date_menu', Carbon::today()->toDateString());
                                });
                            },
                            'garnitures' => function ($query) {
                                $query->wherePivot('menu_id', function ($subQuery) {
                                    $subQuery->select('id')
                                        ->from('menus')
                                        ->where('date_menu', Carbon::today()->toDateString());
                                });
                            }
                        ]);
                    },
                ])->first();

            // Vérifier s'il y a un menu
            if (!$menu) {
                return view('backend.pages.vente.menu.create', ['menu' => null, 'categories' => []]);
            }

            // Grouper les produits par nom de catégorie et trier par position de catégorie
            $categories = $menu->plats
                ->groupBy(function ($plat) {
                    return $plat->categorieMenu->nom; // Grouper par le nom de la catégorie
                })
                ->sortBy(function ($group, $key) {
                    // Trier les groupes par la position des catégories
                    $categorie = $group->first()->categorieMenu;
                    return $categorie ? $categorie->position : 0; // Si une catégorie n'a pas de position, utiliser 0
                });



            // dd($menu->toArray);

            return view('backend.pages.vente.menu.create', compact('categories', 'menu', 'cartMenu'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    /**
     * Stocke une vente au niveau menu
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeVenteMenu(Request $request)
    {
        try {
            //recuperation des informations depuis ajax
            $cart = $request->input('cart');
            // $montantAvantRemise = $request->input('montantAvantRemise');
            // $montantApresRemise = $request->input('montantApresRemise');
            // $montantRemise = $request->input('montantRemise');
            // $typeRemise = $request->input('typeRemise');
            // $valeurRemise = $request->input('valeurRemise');
            $modePaiement = $request->input('modePaiement');
            $montantRecu = $request->input('montantRecu');
            $montantRendu = $request->input('montantRendu');
            $montantAPayer = $request->input('montantAPayer');

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

            //session de la date manuelle
            $sessionDate = Session::get('session_date', now()->toDateString());

            $vente = Vente::create([
                'code' => $codeVente,
                // 'client_id' => $request->client_id,
                'caisse_id' => auth()->user()->caisse_id, // la caisse qui fait la vente
                'user_id' => auth()->user()->id, // l'admin qui a fait la vente
                'montant_total' => $montantAPayer,
                'date_vente' =>  Carbon::parse($sessionDate),
                'mode_paiement' => $modePaiement,
                'montant_recu' => $montantRecu,
                'montant_rendu' => $montantRendu,
                'statut' => 'confirmée',
                'type_vente' => 'Menu du jour'
            ]);

            // inserer les produits dans la vente
            foreach ($cart as $item) {
                $plat = $item['plat'];
                $vente->plats()->attach($plat['id'], [
                    'quantite' => $plat['quantity'],
                    'prix_unitaire' => $plat['price'],
                    'total' => $plat['price'] * $plat['quantity'],
                    'garniture' => json_encode($item['garnitures'] ?? []),
                    'complement' => json_encode($item['complements'] ?? []),
                ]);
            }

            $idVente = $vente->id;

            return response()->json([
                'message' => 'Vente enregistrée avec succès.',
                'status' => 'success',
                'idVente' => $idVente,
            ], 200);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
