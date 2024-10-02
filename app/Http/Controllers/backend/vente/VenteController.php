<?php

namespace App\Http\Controllers\backend\vente;

use App\Models\User;
use App\Models\Vente;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class VenteController extends Controller
{

    public function create()
    {
        try {

            $data_produit = Produit::whereHas('categorie', function ($query) {
                $query->whereIn('famille', ['bar', 'menu']);
            })
                ->where(function ($query) {
                    $query->whereHas('categorie', function ($subQuery) {
                        $subQuery->where('famille', 'menu');
                    })
                        ->orWhere(function ($subQuery) {
                            $subQuery->whereHas('categorie', function ($subSubQuery) {
                                $subSubQuery->where('famille', 'bar');
                            })->whereHas('achats', function ($achatsQuery) {
                                $achatsQuery->where('statut', 'active');
                            });
                        });
                })
                ->with(['categorie', 'achats' => function ($query) {
                    $query->where('statut', 'active')->orderBy('created_at', 'asc');
                }])
                ->get();

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
            $request->validate([
                'client_id' => 'required|exists:users,id',
                'date_vente' => 'required|date',
                'produit_id' => 'required|array',
                'produit_id.*' => 'exists:produits,id',
                'quantite' => 'required|array',
                'quantite.*' => 'numeric|min:1',
                'prix_unitaire' => 'required|array',
                'prix_unitaire.*' => 'numeric|min:0',
                'sous_total' => 'required|array',
                'sous_total.*' => 'numeric|min:0',
            ]);

            // Création de la vente
            $vente = Vente::create([
                'client_id' => $request->client_id,
                'date_vente' => $request->date_vente,
                'montant_total' => $request->montant_total,
            ]);

            // Préparation des données pour la table pivot
            $produits = [];
            foreach ($request->produit_id as $index => $produitId) {
                $produits[$produitId] = [
                    'quantite' => $request->quantite[$index],
                    'prix_unitaire' => $request->prix_unitaire[$index],
                    'sous_total' => $request->sous_total[$index],
                ];
            }

            // Attachement des produits à la vente
            $vente->produits()->attach($produits);

            Alert::success('Succès', 'La vente a été enregistrée avec succès.');
            return back();
        } catch (\Throwable $th) {
            Alert::error('Erreur', 'Une erreur est survenue lors de la création de la vente : ' . $th->getMessage());
            return back();
        }
    }
}
