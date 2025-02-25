<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Vente;
use App\Models\Produit;
use App\Models\Setting;
use App\Models\Categorie;
use App\Models\Inventaire;
use App\Models\ProduitVente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        //
        Schema::defaultStringLength(191);

        //fonction qui récupère tous les produits de catégorie famille menu et met le stock à 100
        $this->app->booted(function () {
            \App\Models\Produit::whereHas('categorie', function ($query) {
                $query->where('famille', 'menu');
            })->chunk(100, function ($produits) {
                foreach ($produits as $produit) {
                    $produit->update(['stock' => 100]);
                }
            });
        });

        // Fonction pour vérifier la quantité stockée des achats
        // $this->app->singleton('verifierQuantiteStockee', function ($app) {
        //     return function () {
        //         \App\Models\Achat::chunk(100, function ($achats) {
        //             foreach ($achats as $achat) {
        //                 if ($achat->quantite_stocke == 0) {
        //                     $achat->update(['statut' => 'desactive']);
        //                 }elseif($achat->quantite_stocke > 0){
        //                     $achat->update(['statut' => 'active']);
        //                 }
        //             }
        //         });
        //     };
        // });

        // Exécuter la vérification au démarrage de l'application
        // $this->app->make('verifierQuantiteStockee')();

        // Attribuer toutes les permissions au rôle développeur et superadmin apr defaut
        // $this->app->booted(function () {
        //     $permissions = \Spatie\Permission\Models\Permission::all();

        //     $developpeurRole = \Spatie\Permission\Models\Role::where('name', 'developpeur')->first();
        //     $superadminRole = \Spatie\Permission\Models\Role::where('name', 'superadmin')->first();

        //     if ($developpeurRole) {
        //         $developpeurRole->syncPermissions($permissions);
        //     }

        //     if ($superadminRole) {
        //         $superadminRole->syncPermissions($permissions);
        //     }
        // });


        // function miseAJourStockVente()
        // {

        //     // produit vente
        //     $data = DB::table('produit_vente')->get();

        //     foreach ($data as $index => $value) {
        //         // quantite qui fait la  bouteille dans produit_variante
        //         $quantite = DB::table('produit_variante')->where('produit_id', $value->produit_id)->where('variante_id', $value->variante_id)->value('quantite');
        //         // determiner la quantite bouteille vendu dans produit vente en fonction de quantite et variante
        //         DB::table('produit_vente')->where('produit_id', $value->produit_id)->where('variante_id', $value->variante_id)->update([
        //             'quantite_bouteille' => $value->quantite / $quantite,
        //         ]);
        //     }
        // }


        function miseAJourStockVente()
        {
            // Récupération des ventes dont la catégorie famille est "bar"
            $data = DB::table('produit_vente')
                ->join('produits', 'produit_vente.produit_id', '=', 'produits.id')
                ->join('categories', 'produits.categorie_id', '=', 'categories.id')
                ->where('categories.famille', 'bar') // Filtrer uniquement les produits de la famille "bar"
                ->select('produit_vente.id', 'produit_vente.produit_id', 'produit_vente.variante_id', 'produit_vente.quantite') // Sélectionner les champs nécessaires
                ->get();

            foreach ($data as $value) {
                // Vérifier si produit_id, variante_id et quantite existent pour éviter une erreur
                if (!isset($value->produit_id, $value->variante_id, $value->quantite)) {
                    continue; // Ignore cette ligne et passe à la suivante
                }

                // Récupération de la quantité de la variante
                $quantite = DB::table('produit_variante')
                    ->where('produit_id', $value->produit_id)
                    ->where('variante_id', $value->variante_id)
                    ->value('quantite');

                // Vérification pour éviter une division par zéro
                if (is_null($quantite) || $quantite == 0) {
                    continue;
                }

                // Mise à jour de la quantité de bouteilles vendues dans la table produit_vente uniquement pour les produits de la catégorie "bar"
                DB::table('produit_vente')
                    ->join('produits', 'produit_vente.produit_id', '=', 'produits.id')
                    ->join('categories', 'produits.categorie_id', '=', 'categories.id')
                    ->where('categories.famille', 'bar') // Se limiter aux produits de la famille "bar"
                    ->where('produit_vente.id', $value->id) // Condition sur l'ID du produit_vente
                    ->update([
                        'quantite_bouteille' => round($value->quantite / $quantite, 2),
                    ]);
            }
        }

        // // Exécuter la fonction miseAJourStockVente au démarrage de l'application
        miseAJourStockVente();


        // Mise a jour dans produit inventaire 

        $data = DB::table('inventaire_produit')->get(); // Récupérer les données

        foreach ($data as $value) {
            // Calculer le stock théorique
            $sth = ($value->stock_dernier_inventaire + $value->stock_initial) - $value->stock_vendu;

            // Calculer l'écart
            $ecart = $value->stock_physique - $sth;

            // Déterminer l'état du stock
            if ($sth == 0 && $value->stock_physique == 0) {
                $etat = 'Rupture';
            } elseif ($ecart < 0) {
                $etat = 'Perte';
            } elseif ($ecart > 0) {
                $etat = 'Surplus';
            } else {
                $etat = 'Conforme';
            }

            // Mise à jour du stock théorique et de l'état
            DB::table('inventaire_produit')
                ->where('id', $value->id)
                ->update([
                    'stock_theorique' => $sth,
                    'ecart' => $ecart,
                    'etat' => $etat,
                ]);
        }


        ######################################################## 

        // ##Mise à jour de la quantite vendu dans la table inventaire_produit
 

        // $data = DB::table('inventaire_produit')->get(); // Récupérer les données

        // foreach ($data as $value) {
        //     // Récupérer l'inventaire actuel
        //     $inventaireActuel = Inventaire::with('produits')->find($value->inventaire_id);

        //     if (!$inventaireActuel) {
        //         continue; // Si l'inventaire actuel n'existe pas, on passe au suivant
        //     }

        //     // Récupérer l'inventaire précédent (le plus récent ayant un ID inférieur)
        //     $inventairePrecedent = Inventaire::where('id', '<', $value->inventaire_id)
        //         ->orderBy('id', 'desc')
        //         ->first();

        //     // Déterminer la plage de dates
        //     $dateDebut = $inventairePrecedent ? $inventairePrecedent->date_inventaire : null;
        //     $dateFin = $inventaireActuel->date_inventaire;

        //     // Récupérer les produits avec la quantité vendue et utilisée
        //     $data_produit = Produit::whereHas('categorie', function ($q) {
        //         $q->whereIn('famille', ['restaurant', 'bar']);
        //     })
        //         ->withSum(['ventes as quantite_vendue' => function ($query) use ($dateDebut, $dateFin) {
        //             if ($dateDebut) {
        //                 $query->whereBetween('ventes.date_vente', [$dateDebut, $dateFin]);
        //             } else {
        //                 $query->where('ventes.date_vente', '<', $dateFin);
        //             }
        //         }], 'produit_vente.quantite_bouteille')

        //         ->withSum(['sorties as quantite_utilisee' => function ($query) use ($dateDebut, $dateFin) {
        //             if ($dateDebut) {
        //                 $query->whereBetween('sorties.date_sortie', [$dateDebut, $dateFin]);
        //             } else {
        //                 $query->where('sorties.date_sortie', '<', $dateFin);
        //             }
        //         }], 'produit_sortie.quantite_utilise')

        //         ->with('categorie')
        //         ->where('id', $value->produit_id)
        //         ->get();

        //     // Vérifier s'il y a des produits avant de faire la mise à jour
        //     if ($data_produit->isNotEmpty()) {
        //         foreach ($data_produit as $produit) {
        //             DB::table('inventaire_produit')
        //                 ->where('produit_id', $produit->id)
        //                 ->where('inventaire_id', $value->inventaire_id)
        //                 ->update([
        //                     'stock_vendu' => ($produit->quantite_vendue ?? 0) + ($produit->quantite_utilisee ?? 0), // Assure que les valeurs null sont remplacées par 0
        //                 ]);
        //         }
                
        //     }
        // }





        $this->app->booted(function () {
            $permissions = \Spatie\Permission\Models\Permission::pluck('id')->toArray();

            $developpeurRole = \Spatie\Permission\Models\Role::where('name', 'developpeur')->first();
            $superadminRole = \Spatie\Permission\Models\Role::where('name', 'superadmin')->first();

            if ($developpeurRole) {
                $developpeurRole->permissions()->sync($permissions);
            }

            if ($superadminRole) {
                $superadminRole->permissions()->sync($permissions);
            }
        });



        //get setting data
        $data_setting = Setting::with('media')->first();

        //get categorie data
        $menu_link = Categorie::whereNull('parent_id')->with('children', fn($q) => $q->OrderBy('position', 'ASC'))->withCount('children')
            ->whereIn('type', ['menu', 'bar'])
            ->OrderBy('position', 'DESC')->get();
        // dd($data_setting);

        // get all categories parent with children
        $categories = Categorie::whereNull('parent_id')
            ->with('children')
            ->whereIn('type', ['menu', 'bar'])
            ->orderBy('position', 'DESC')
            ->get();
        view()->share([
            'setting' => $data_setting,
            'menu_link' => $menu_link,
            'categories' => $categories
        ]);
    }
}
