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




        // Mise a jour dans produit inventaire 

        // $data = DB::table('inventaire_produit')->get(); // Récupérer les données

        // foreach ($data as $value) {
        //     // Calculer le stock théorique
        //     $sth = ($value->stock_dernier_inventaire + $value->stock_initial) - $value->stock_vendu;

        //     // Calculer l'écart
        //     $ecart = $value->stock_physique - $sth;

        //     // Déterminer l'état du stock
        //     if ($sth == 0 && $value->stock_physique == 0) {
        //         $etat = 'Rupture';
        //     } elseif ($ecart < 0) {
        //         $etat = 'Perte';
        //     } elseif ($ecart > 0) {
        //         $etat = 'Surplus';
        //     } else {
        //         $etat = 'Conforme';
        //     }

        //     // Mise à jour du stock théorique et de l'état
        //     DB::table('inventaire_produit')
        //         ->where('id', $value->id)
        //         ->update([
        //             'stock_theorique' => $sth,
        //             'ecart' => $ecart,
        //             'etat' => $etat,
        //         ]);
        // }


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

        // verifier si un inventaire du mois precedent existe
        $inventaire_existe = Inventaire::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->exists();



        function productsNotInInventaire()
        {
            // ##START FONCTION POUR METTRE A JOUR LE STOCK DES PRODUITS QUI NE SONT PAS DANS L'INVENTAIRE DU MOIS


            // recuperer l'inventaire du mois 
            $inventaire_mois = Inventaire::whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->first();

            // recuperer les produits de l'inventaire du mois
            $produits_inventaire = Produit::whereHas('inventaires', function ($query) use ($inventaire_mois) {
                $query->where('inventaires.id', $inventaire_mois->id);
            })->get();


            //recuperer les produits où la categorie famille est restaurant et  bar qui ne sont pas dans l'inventaire du mois
            $produits_not_inventaire = Produit::whereDoesntHave('inventaires', function ($query) use ($inventaire_mois) {
                $query->where('inventaires.id', $inventaire_mois->id);
            })->whereHas('categorie', function ($query) {
                $query->whereIn('famille', ['restaurant', 'bar']);
            })->get();

            // mettre le stock des produits qui ne sont pas dans l'inventaire du mois à 0
            foreach ($produits_not_inventaire as $produit) {
                $produit->update([
                    'stock' => 0,
                    'stock_dernier_inventaire' => 0,
                    'stock_initial' => 0,
                ]);
            }

            // dd($produits_not_inventaire->toArray());

            ##END


        }












        // ##START FONCTION POUR METTRE A JOUR LE STOCK DES PRODUITS QUI NE SONT PAS DANS L'INVENTAIRE DU MOIS


        // appel de la fonction helpers qui met a jour le stock des produits qui ne sont pas dans l'inventaire du mois
        productsNotInInventaire();


        ##END

        view()->share([
            'setting' => $data_setting,
            'menu_link' => $menu_link,
            'categories' => $categories,
            'inventaire_existe' => $inventaire_existe
        ]);
    }
}
