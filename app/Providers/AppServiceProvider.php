<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Categorie;
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


        $this->app->booted(function () {
            $permissions = \Spatie\Permission\Models\Permission::all();
        
            $developpeurRole = \Spatie\Permission\Models\Role::where('name', 'developpeur')->first();
            $superadminRole = \Spatie\Permission\Models\Role::where('name', 'superadmin')->first();
        
            if ($developpeurRole) {
                $existingPermissions = $developpeurRole->permissions->pluck('id');
                $permissionsToSync = $permissions->pluck('id')->diff($existingPermissions);
                $developpeurRole->syncPermissions($permissionsToSync);
            }
        
            if ($superadminRole) {
                $existingPermissions = $superadminRole->permissions->pluck('id');
                $permissionsToSync = $permissions->pluck('id')->diff($existingPermissions);
                $superadminRole->syncPermissions($permissionsToSync);
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
