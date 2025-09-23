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

        // Set the locale for Carbon
        \Carbon\Carbon::setLocale('fr');
        //
        Schema::defaultStringLength(191);





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
        if (Schema::hasTable('settings')) {
            $data_setting = Setting::first();
        } else {
            $data_setting = [];
        }

       

        // get all categories parent with children
        if (Schema::hasTable('categories')) {
            $categories = Categorie::whereNull('parent_id')
                ->with('children', fn($q) => $q->OrderBy('position', 'ASC'))
                ->withCount('children')
                ->OrderBy('position', 'ASC')
                ->get();
        } else {
            $categories = [];
        }


       

        view()->share([
            'setting' => $data_setting,
            'categories' => $categories,
        ]);
    }
}
