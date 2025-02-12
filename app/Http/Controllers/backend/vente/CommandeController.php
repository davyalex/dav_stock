<?php

namespace App\Http\Controllers\backend\vente;

use Carbon\Carbon;
use App\Models\Vente;
use App\Models\Commande;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class CommandeController extends Controller
{
    //
    public function index(Request $request)
    {
        try {

            // $statut = ['en attente', 'confirmée', 'livrée', 'annulée'];

            // $filter = request('filter');


            // $commandes = Commande::with('client', 'produits', 'plats')
            //     ->when($filter, function ($query) use ($filter) {
            //         return $query->where('statut', $filter);
            //     })
            //     ->orderBy('created_at', 'desc') // Trier par date de création (récent en premier)
            //     ->get();

            $dateDebut = $request->input('date_debut');
            $dateFin = $request->input('date_fin');
            $statut = $request->input('statut');
            $periode = $request->input('periode');

            $query = Commande::with('client', 'produits', 'plats');

            // Formatage des dates
            $dateDebut = $request->filled('date_debut') ? Carbon::parse($dateDebut)->format('Y-m-d') : null;
            $dateFin = $request->filled('date_fin') ? Carbon::parse($dateFin)->format('Y-m-d') : null;

            // Application des filtres de date
            if ($dateDebut && $dateFin) {
                $query->whereBetween('created_at', [$dateDebut, $dateFin]);
            } elseif ($dateDebut) {
                $query->where('created_at', '>=', $dateDebut);
            } elseif ($dateFin) {
                $query->where('created_at', '<=', $dateFin);
            }

            // Application du filtre de statut
            if ($request->filled('statut')) {
                $query->where('statut', $statut);
            }

            // Application du filtre de periode
            // periode=> jour, semaine, mois, année
            if ($request->filled('periode')) {
                if ($periode == 'jour') {
                    $query->whereDate('created_at', Carbon::today());
                } elseif ($periode == 'semaine') {
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                } elseif ($periode == 'mois') {
                    $query->whereMonth('created_at', Carbon::now()->month);
                } elseif ($periode == 'annee') {
                    $query->whereYear('created_at', Carbon::now()->year);
                }
            }

            $commandes = $query->orderBy('created_at', 'desc')->get();

            // dd( $filter);
            return view('backend.pages.vente.commande.index', compact('commandes', 'statut'));
        } catch (\Exception $e) {
            Alert::error('Erreur', 'Une erreur est survenue lors de la récupération des commandes : ' . $e->getMessage());
            return back();
        }
    }

    public function show($id)
    {
        try {
            $commande = Commande::with('client', 'produits', 'plats')->findOrFail($id);
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

            // dd($nouveauStatut);

            $commande->statut = $nouveauStatut;

            if ($commande->statut != $nouveauStatut) {
                $commande->user_id = auth()->id();
                $commande->caisse_id = auth()->user()->caisse_id;
            }


            if (in_array($nouveauStatut, ['livrée', 'confirmée'])) {
                // Mise à jour de la table vente


                // Vérifier si une vente existe déjà pour cette commande
                $vente = Vente::where('commande_id', $commande->id)->first();

                if ($vente) {
                    // Mise à jour de la vente existante
                    $vente->statut = 'confirmée';
                    $vente->save();
                    // enregistrer le statut de la commande
                    $commande->save();
                } else {

                    // on creer une nouvelle vente
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
                    $vente->mode_paiement = $commande->mode_paiement;
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


                    // Associer les plats à la commande
                    foreach ($commande->plats as $plat) {
                        $vente->plats()->attach($plat->id, [
                            'quantite' => $plat->pivot->quantite,
                            'prix_unitaire' => $plat->pivot->prix_unitaire,
                            'total' => $plat->pivot->total,
                            'garniture' => $plat->pivot->garniture ?? [],
                            'complement' => $plat->pivot->complement ?? [],
                        ]);
                    }


                    // enregistrer le statut de la commande
                    $commande->save();
                }



                return response()->json([
                    'success' => true,
                    'message' => 'Statut mis à jour avec succès',
                    'statut' => 'confirmée',
                    'idVente' => $vente->id
                ]);
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
