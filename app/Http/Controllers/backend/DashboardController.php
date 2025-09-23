<?php

namespace App\Http\Controllers\backend;

use Carbon\Carbon;
use App\Models\Vente;
use App\Models\Depense;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }




    //
    public function index(Request $request)
    {
        // Vérifier si l'utilisateur a le rôle 'caisse'
        if ($request->user()->hasRole(['caisse', 'supercaisse'])) {
            try {
                // Vérifier si l'utilisateur n'a pas sélectionné de caisse
                if (Auth::user()->caisse_id === null) {
                    // Rediriger vers la page de sélection de caisse
                    return redirect()->route('caisse.select')->with('error', 'Veuillez sélectionner une caisse avant d\'accéder à l\'application.');
                }
                // Rediriger vers la page de vente si une caisse est sélectionnée
                return redirect()->route('vente.index');
            } catch (\Throwable $th) {
                return $th->getMessage();}
        }

        ## statistique Liste des ventes


        //Liste des produit les plus vendus
        $produitsLesPlusVendus = Produit::withCount('ventes')
            ->withSum('ventes', 'produit_vente.prix_unitaire')
            ->orderBy('ventes_count', 'desc')
            ->having('ventes_count', '>', 0)
            ->take(10)
            ->get()
            ->map(function ($produit) {
                // Renommer l'attribut calculé dans la collection
                $produit->total_ventes = $produit->ventes_sum_produit_venteprix_unitaire;
                return $produit;
            });

        // statistique chiffre pour card


        // Montant total des ventes annee en cours
        $montantTotalVentes = Vente::whereYear('date_vente', Carbon::now()->year)
            ->sum('montant_total');

      
        /// Montant total des ventes mois en cours 
        $montantTotalVentesMois = Vente::whereMonth('date_vente', Carbon::now()->month)
            ->sum('montant_total');

     
        // Produits en alerte
        $produitsEnAlerte = Produit::where('stock', '=', 'stock_alerte')->get()->count();



        $revenus = DB::table('ventes')
            ->selectRaw("MONTHNAME(date_vente) as mois, MONTH(date_vente) as mois_num, SUM(montant_total) as total_revenu")
            ->groupBy('mois', 'mois_num')
            ->orderBy('mois_num')
            ->get();


        // Recuperer les mois et Traduire les mois en français avec Carbon
        $labels = $revenus->map(function ($revenu) {
            return Carbon::create()->month($revenu->mois_num)->locale('fr')->translatedFormat('F');
        });
        $data = $revenus->pluck('total_revenu'); // Revenus correspondants

        // dd($labels, $data);



        // dd($produitsLesPlusVendus->toArray());
        return view('backend.pages.index', compact(
            'produitsLesPlusVendus',
            'montantTotalVentes', // Montant total des ventes annee en cours
            'montantTotalVentesMois', // Montant total des ventes mois en cours
            'produitsEnAlerte',

            // 'chiffreAffaireParMois',
            'labels',
            'data'
        ));
    }
}
