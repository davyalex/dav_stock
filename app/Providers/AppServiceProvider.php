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

        //get setting data
        $data_setting = Setting::with('media')->first();

        //get categorie data
        $menu_link = Categorie::whereNull('parent_id')->with('children', fn($q) => $q->OrderBy('position', 'ASC'))->withCount('children')
            ->whereIn('type', ['plats', 'boissons'])
            ->OrderBy('position', 'ASC')->get();
        // dd($data_setting->toArray);
        view()->share([
            'setting'=>$data_setting,
            'menu_link'=>$menu_link
        ]);
    }
}
