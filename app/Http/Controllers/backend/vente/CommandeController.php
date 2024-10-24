<?php

namespace App\Http\Controllers\backend\vente;

use App\Models\Vente;
use App\Models\Commande;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class CommandeController extends Controller
{
    //
    public function index()
    {
        try {
            $commandes = Commande::with('client', 'produits')->orderBy('created_at', 'desc')->get();
            return view('backend.pages.vente.commande.index', compact('commandes'));
        } catch (\Exception $e) {
            Alert::error('Erreur', 'Une erreur est survenue lors de la récupération des commandes : ' . $e->getMessage());
            return back();
        }
    }

    public function show($id)
    {
        try {
            $commande = Commande::with('client', 'produits')->findOrFail($id);
            return view('backend.pages.vente.commande.show', compact('commande'));
        } catch (\Exception $e) {
            Alert::error('Erreur', 'Une erreur est survenue lors de la récupération des détails de la commande : ' . $e->getMessage());
            return back();
        }
    }


    public function changerStatut(Request $request)
    {
        try {
            $commande = Commande::findOrFail($request->input('commandeId'));
            $nouveauStatut = $request->input('statut');

            $commande->statut = $nouveauStatut;

            if ($commande->statut != $nouveauStatut) {
                $commande->user_id = auth()->id();
                $commande->caisse_id = auth()->user()->caisse_id;
            }

            if ($nouveauStatut == 'confirmée' || $nouveauStatut == 'livrée') {
                // Mise à jour de la table vente
                ##Generer le code vente
                // Obtenir les deux premières lettres du nom de la caissière
                $initialesCaissiere = substr(auth()->user()->first_name, 0, 2);
                // Obtenir le numéro d'ordre de la vente pour aujourd'hui
                $nombreVentes = Vente::count();
                $numeroOrdre = $nombreVentes + 1;
                // Obtenir la date et l'heure actuelles
                $dateHeure = now()->format('dmYHi');
                // Générer le code de vente
                $codeVente = strtoupper($initialesCaissiere) . '-' . $numeroOrdre . $dateHeure;
                $vente = new Vente();
                $vente->code = $codeVente;
                $vente->date_vente = now();
                $vente->montant_total = $commande->montant_total;
                $vente->user_id = auth()->id();
                $vente->caisse_id = auth()->user()->caisse_id;
                $vente->client_id = $commande->client_id;
                $vente->statut = 'confirmée';
                $vente->type_vente = 'commande';
                $vente->commande_id = $commande->id;

                $vente->save();

                // Associer les produits de la commande à la vente
                foreach ($commande->produits as $produit) {
                    $vente->produits()->attach($produit->id, [
                        'quantite' => $produit->pivot->quantite,
                        'prix_unitaire' => $produit->pivot->prix_unitaire,
                        'total' => $produit->pivot->total,
                    ]);


                    // Mise à jour du stock pour les produits de la catégorie "bar"
                    if ($produit->categorie->famille == 'bar') {
                        // Mise à jour du stock du produit
                        $produit->stock -= $produit->pivot->quantite;
                        $produit->save();

                        // Mise à jour de la quantité stockée dans l'achat le plus récent
                        $achat = $produit->achats()->latest()->first();
                        if ($achat) {
                            $achat->quantite_stocke -= $produit->pivot->quantite;
                            $achat->save();
                        }
                    }
                }
            }
            // Si le statut est annulé
            elseif ($nouveauStatut == 'annulée') {
                // Mettre à jour le statut de la vente associée
                $vente = Vente::where('client_id', $commande->client_id)
                    ->where('montant_total', $commande->montant_total)
                    ->latest()
                    ->first();

                if ($vente) {
                    $vente->statut = 'annulée';
                    $vente->save();

                    // Mettre à jour le stock des produits
                    foreach ($commande->produits as $produit) {
                        if ($produit->categorie->famille == 'bar') {
                            // Remettre en stock la quantité annulée
                            $produit->stock += $produit->pivot->quantite;
                            $produit->save();

                            // Mettre à jour la quantité stockée dans l'achat le plus récent
                            $achat = $produit->achats()->latest()->first();
                            if ($achat) {
                                $achat->quantite_stocke += $produit->pivot->quantite;
                                $achat->save();
                            }
                        }
                    }
                }
            }

            $commande->save();

            // Alert::success('Succès', 'Le statut de la commande a été mis à jour avec succès.');
            return response()->json(['success' => true, 'message' => 'Statut mis à jour avec succès']);
        } catch (\Exception $e) {
            Alert::error('Erreur', 'Une erreur est survenue lors de la mise à jour du statut : ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erreur lors de la mise à jour du statut'], 500);
        }
    }
}
