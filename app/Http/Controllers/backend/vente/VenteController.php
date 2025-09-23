<?php

namespace App\Http\Controllers\backend\vente;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vente;
use App\Models\Caisse;
use App\Models\Produit;
use App\Models\Categorie;

use Illuminate\Support\Str;
use App\Models\ModePaiement;
use Illuminate\Http\Request;
use App\Models\HistoriqueCaisse;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\RouteAction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\backend\user\AdminController;

class VenteController extends Controller
{





    public function index(Request $request)
    {
        try {

            $caisses = Caisse::all();

            $query = Vente::with('produits')
                ->orderBy('created_at', 'desc');


            // Vérifier si aucune période ou date spécifique n'a été fournie
            if (!$request->filled('periode') && !$request->filled('date_debut') && !$request->filled('date_fin')) {
                $query->whereMonth('date_vente', Carbon::now()->month)
                    ->whereYear('date_vente', Carbon::now()->year);
            }

            // sinon on applique le filtre des date et caisse
            $dateDebut = $request->input('date_debut');
            $dateFin = $request->input('date_fin');
            $caisse = $request->input('caisse');
            $periode = $request->input('periode');


            // Formatage des dates
            $dateDebut = $request->filled('date_debut') ? Carbon::parse($dateDebut)->format('Y-m-d') : null;
            $dateFin = $request->filled('date_fin') ? Carbon::parse($dateFin)->format('Y-m-d') : null;

            // Application des filtres de date
            if ($dateDebut && $dateFin) {
                $query->whereBetween('date_vente', [$dateDebut, $dateFin]);
            } elseif ($dateDebut) {
                $query->where('date_vente', '>=', $dateDebut);
            } elseif ($dateFin) {
                $query->where('date_vente', '<=', $dateFin);
            }

            // Application du filtre de caisse
            if ($request->filled('caisse')) {
                $query->where('caisse_id', $request->caisse);
            }


            // Application du filtre de periode
            // periode=> jour, semaine, mois, année
            if ($request->filled('periode')) {
                $periode = $request->periode; // Ajout de cette ligne pour récupérer la période

                if ($periode == 'jour') {
                    $query->whereDate('date_vente', Carbon::today());
                } elseif ($periode == 'semaine') {
                    $query->whereBetween('date_vente', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                } elseif ($periode == 'mois') {
                    $query->whereMonth('date_vente', Carbon::now()->month)
                        ->whereYear('date_vente', Carbon::now()->year); // Ajout pour éviter d'avoir des résultats de plusieurs années
                } elseif ($periode == 'annee') {
                    $query->whereYear('date_vente', Carbon::now()->year);
                }
            }

            //si l'utilisateur a le rôle 'caisse' ou 'supercaisse' on affiche les ventes de la caisse actuelle
            if ($request->user()->hasRole(['caisse', 'supercaisse'])) {
                $query->where('caisse_id', auth()->user()->caisse_id)
                    ->where('user_id', auth()->user()->id)
                    // ->where('statut_cloture', false)
                    ->whereDate('date_vente', auth()->user()->caisse->session_date_vente); // ✅ Compare seulement la date
            }


            $data_vente = $query->get();


            ## fin du filtre de recherche


            //Recuperer la session de la date vente manuelle et verifier si la caisse actuelle a effectuer des vente clotureé  a sa date de vente
            $sessionDate = null;
            $venteCaisseCloture = null;
            if ($request->user()->hasRole(['caisse', 'supercaisse'])) {

                //Recuperer la session de la date vente manuelle
                $sessionDate = Caisse::find(Auth::user()->caisse_id);
                $sessionDate = $sessionDate->session_date_vente;


                // verifier si la caisse actuelle a effectuer des vente clotureé  a sa date de vente
                $venteCaisseCloture = Vente::where('caisse_id', auth()->user()->caisse_id)
                    ->where('user_id', auth()->user()->id)
                    // ->where('statut_cloture', true)
                    ->whereDate('date_vente', auth()->user()->caisse->session_date_vente) // ✅ Compare seulement la date
                    ->count();
            }



            return view('backend.pages.vente.index', compact('data_vente', 'caisses', 'sessionDate', 'venteCaisseCloture'));
        } catch (\Exception $e) {
            Alert::error('Erreur', 'Une erreur est survenue lors du chargement des ventes : ' . $e->getMessage());
            return back();
        }
    }



    public function create()
    {
        try {


            $data_produit = Produit::active()->alphabetique()->get();

            $data_mode_paiement = ModePaiement::active()->get();

            return view('backend.pages.vente.create', compact('data_produit', 'data_mode_paiement'));
        } catch (\Exception $e) {
            // Gestion des erreurs
            return back()->with('error', 'Une erreur est survenue lors du chargement du formulaire de création : ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            // Récupération des données envoyées par AJAX
            $cart = $request->input('cart');
            $montant_total = $request->input('montant_total');
            $montant_avant_remise = $request->input('montant_avant_remise');
            $montant_remise = $request->input('discount_value');
            $type_remise = $request->input('discount_type');
            $valeur_remise = $request->input('discount_value');
            $mode_paiement = $request->input('mode_paiement');
            $montant_recu = $request->input('montant_recu');
            $montant_rendu = $montant_recu - $montant_total;

            // Génération du code de vente
            $nombreVentes = Vente::count();
            $numeroOrdre = $nombreVentes + 1;
            $dateHeure = now()->format('dmYHi');
            $codeVente = $numeroOrdre . $dateHeure;

            // Récupération de la date de session de la caisse
            $sessionDate = \App\Models\Caisse::find(Auth::user()->caisse_id)->session_date_vente;

            // Création de la vente
            $vente = Vente::create([
                'code' => $codeVente,
                'caisse_id' => auth()->user()->caisse_id,
                'user_id' => auth()->user()->id,
                'date_vente' => $sessionDate,
                'montant_total' => $montant_total,
                'montant_avant_remise' => $montant_avant_remise,
                'montant_remise' => $montant_remise,
                'type_remise' => $type_remise,
                'valeur_remise' => $valeur_remise,
                'mode_paiement_id' => $mode_paiement,
                'montant_recu' => $montant_recu,
                'montant_rendu' => $montant_rendu,
            ]);

            // Attacher les produits à la vente et mettre à jour le stock
            if (!empty($cart)) {
                foreach ($cart as $item) {
                    $vente->produits()->attach($item['id'], [
                        'quantite' => $item['quantity'],
                        'prix_unitaire' => $item['price'],
                        'total' => $item['price'] * $item['quantity'],
                    ]);
                    // Mise à jour du stock
                    $produit = Produit::find($item['id']);
                    if ($produit) {
                        $produit->stock -= $item['quantity'];
                        $produit->save();
                    }
                }
            }

            return response()->json([
                'message' => 'Vente enregistrée avec succès.',
                'status' => 'success',
                'idVente' => $vente->id,
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erreur lors de la création de la vente : ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $vente = Vente::findOrFail($id);
            return view('backend.pages.vente.show', compact('vente'));
        } catch (\Exception $e) {
            return redirect()->route('vente.index')->with('error', "Une erreur s'est produite. Veuillez réessayer.");
        }
    }


    /***Fonction pour fermer la caisse */
    public function fermerCaisse(Request $request)
    {
        try {
            $user = Auth::user();
            $caisse = $user->caisse;

            //deconnecter l'utilisateur et enregistrer l'historique caisse
            // Si l'utilisateur a une caisse active, la désactiver
            if ($user->caisse_id) {

                // niveau caisse
                $caisse = Caisse::find($user->caisse_id);
                $caisse->statut = 'desactive';
                $caisse->session_date_vente = null;
                $caisse->save();

                // mettre caisse_id a null du user connecté
                User::whereId($user->id)->update([
                    'caisse_id' => null,
                ]);

                //mise a jour dans historiquecaisse pour fermeture de caisse
                HistoriqueCaisse::where('user_id', $user->id)
                    ->where('caisse_id', $user->caisse_id)
                    ->whereNull('date_fermeture')
                    ->update([
                        'date_fermeture' => now(),
                    ]);


                Auth::logout();
                Alert::success('Succès', 'Caisse Fermée avec succès');
                return Redirect()->route('admin.login');
            }
        } catch (\Exception $e) {
            return redirect()->route('vente.index')->with('error', "Une erreur s'est produite. Veuillez réessayer.");
        }
    }



    //Rapport de vente de la caisse
    public function rapportVente(Request $request)
    {
        try {
            $user = Auth::user();
            $caisse = $user->caisse;

            if (!$caisse) {
                Alert::error('Erreur', 'Aucune caisse active pour cet utilisateur.');
                return back();
            }

            // Récupérer la date de session de vente
            $sessionDate = $caisse->session_date_vente;

            // Récupérer toutes les ventes de la caisse pour la session courante
            $ventes = Vente::where('caisse_id', $caisse->id)
                ->whereDate('date_vente', $sessionDate)
                ->with('produits', 'user', 'modePaiement')
                ->get();

            // Calculer le total des ventes
            $totalVentes = $ventes->sum('montant_total');
            $totalRemise = $ventes->sum('montant_remise');
            $totalRecu = $ventes->sum('montant_recu');
            $totalRendu = $ventes->sum('montant_rendu');

            // Regrouper par mode de paiement
            $paiements = [];
            foreach ($ventes as $vente) {
                $libelle = $vente->modePaiement ? $vente->modePaiement->libelle : 'Non défini';
                if (!isset($paiements[$libelle])) {
                    $paiements[$libelle] = 0;
                }
                $paiements[$libelle] += $vente->montant_total;
            }

            return view('backend.pages.vente.rapportVenteCaisse', compact(
                'ventes',
                'caisse',
                'sessionDate',
                'totalVentes',
                'totalRemise',
                'totalRecu',
                'totalRendu',
                'paiements'
            ));
        } catch (\Exception $e) {
            Alert::error('Erreur', 'Impossible de générer le rapport : ' . $e->getMessage());
            return back();
        }
    }

    public function delete($id)
    {
        // Récupérer la vente avec ses produits
        $vente = Vente::with('produits')->find($id);

        if (!$vente) {
            return response()->json(['message' => 'Vente non trouvée'], 404);
        }

        foreach ($vente->produits as $produit) {
            // Vérifier si le produit existe réellement
            $produitVente = Produit::find($produit->id);
            if (!$produitVente) {
                continue;
            }

            // Réajouter la quantité vendue au stock du produit
            $produitVente->stock += $produit->pivot->quantite;
            $produitVente->save();
        }

        // Supprimer la vente
        $vente->forceDelete();

        return response()->json(['status' => 200]);
    }
}
