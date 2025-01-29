<?php

namespace App\Http\Controllers\backend;

use App\Models\Vente;
use App\Models\Depense;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Http\Request;
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
        if ($request->user()->hasRole('caisse')) {
            // Vérifier si l'utilisateur n'a pas sélectionné de caisse
            if (Auth::user()->caisse_id === null) {
                // Rediriger vers la page de sélection de caisse
                return redirect()->route('caisse.select')->with('warning', 'Veuillez sélectionner une caisse avant d\'accéder à l\'application.');
            }
            // Rediriger vers la page de vente si une caisse est sélectionnée
            return redirect()->route('vente.index');
        }

        ## statistique Liste des ventes
        // Liste des commandes en attente
        $commandesEnAttente = Commande::where('statut', 'en attente')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();


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
        // Nombre de commandes
        $nombreCommandes = Commande::count();

        // Montant total des ventes
        $montantTotalVentes = Vente::sum('montant_total');

        // Montant total des dépenses
        $montantTotalDepenses = Depense::sum('montant');

        // Produits en alerte
        $produitsEnAlerte = Produit::where('stock', '=', 'stock_alerte')->get()->count();

        // dd($montantTotalVentes);


        // dd($produitsLesPlusVendus->toArray());
        return view('backend.pages.index', compact(
            'commandesEnAttente',
            'produitsLesPlusVendus',
            'nombreCommandes',
            'montantTotalVentes',
            'montantTotalDepenses',
            'produitsEnAlerte',
        ));
    }
}
