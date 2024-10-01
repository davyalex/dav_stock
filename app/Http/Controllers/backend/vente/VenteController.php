<?php

namespace App\Http\Controllers\backend\vente;

use App\Models\User;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VenteController extends Controller
{
  
    public function create()
    {
        try {
            // Logique pour afficher le formulaire de création d'une nouvelle vente
            $produits = Produit::all(); // Assurez-vous d'importer le modèle Produit
            $clients = User::all(); // Assurez-vous d'importer le modèle Client
            return view('backend.pages.vente.create', compact('produits', 'clients'));
        } catch (\Exception $e) {
            // Gestion des erreurs
            return back()->with('error', 'Une erreur est survenue lors du chargement du formulaire de création : ' . $e->getMessage());
        }
    }
    
}
