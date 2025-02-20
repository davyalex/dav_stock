<?php

namespace App\Http\Controllers\backend\stock;

use Carbon\Carbon;
use App\Models\Unite;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Inventaire;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InventaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $data_inventaire = Inventaire::with('produits')->orderBy('created_at', 'desc')->get();

            return view('backend.pages.stock.inventaire.index', compact('data_inventaire'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        try {
            // Récupérer la date du dernier inventaire
            $date_dernier_inventaire = Inventaire::select('created_at')
                ->orderBy('created_at', 'desc')
                ->first();
            $date_dernier_inventaire = $date_dernier_inventaire ? $date_dernier_inventaire->created_at : Carbon::now()->startOfDay();

            // Date du jour
            $date_jour = Carbon::now();

            // Récupérer les produits avec le nombre de ventes entre la date du dernier inventaire et la date du jour
            $data_produit = Produit::whereHas('categorie', function ($q) {
                $q->whereIn('famille', ['restaurant', 'bar']);
            })
                ->withSum(['ventes as quantite_vendue' => function ($query) use ($date_dernier_inventaire, $date_jour) {
                    // Filtrer les ventes entre la date du dernier inventaire et la date du jour
                    $query->whereBetween('ventes.created_at', [$date_dernier_inventaire, $date_jour]);
                }], 'produit_vente.quantite_bouteille') // Somme de la quantité vendue dans le pivot produit_vente


                ->withSum(['sorties as quantite_utilisee' => function ($query) use ($date_dernier_inventaire, $date_jour) {
                    // Filtrer les sorties entre la date du dernier inventaire et la date du jour
                    $query->whereBetween('sorties.created_at', [$date_dernier_inventaire, $date_jour]);
                }], 'produit_sortie.quantite_utilise') // Somme de la quantité utilisée dans le pivot produit_sortie

                // ->withCount(['sorties as total_quantite_utilisee' => function ($query) use ($date_dernier_inventaire, $date_jour) {
                //     // Somme des quantités utilisées dans le pivot `produit_sortie`
                //     $query->whereBetween('sorties.created_at', [$date_dernier_inventaire, $date_jour])
                //           ->select(DB::raw('SUM(produit_sortie.quantite_utilise)'));
                // }])
                ->with('categorie')
                ->get();


            // recuperer les familles de categories bar et restaurant
            $categorie_famille = Categorie::whereNull('parent_id')->with('children', fn($q) => $q->OrderBy('position', 'ASC'))->withCount('children')
                ->whereIn('type', ['bar', 'restaurant'])
                ->OrderBy('position', 'ASC')->get();




            // dd($data_produit->toArray());
            return view('backend.pages.stock.inventaire.create', compact('data_produit', 'categorie_famille'));
        } catch (\Throwable $e) {
            return  $e->getMessage();
        }
    }


    /**
     * Mettre à jour le stock des variantes d'un produit
     *
     * @param int $id L'ID du produit
     *
     * @return void
     */
    //
    public function miseAJourStock($id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return; // Arrête l'exécution si le produit n'existe pas
        }

        // Récupérer toutes les variantes associées au produit
        $variantes = DB::table('produit_variante')
            ->where('produit_id', $produit->id)
            ->get();

        foreach ($variantes as $variante) {
            // Récupérer la quantité disponible actuelle
            $quantite_disponible_actuelle = DB::table('produit_variante')
                ->where('produit_id', $produit->id)
                ->where('variante_id', $variante->variante_id)
                ->value('quantite_disponible');

            // Calculer la nouvelle quantité disponible
            $nouvelle_quantite = $quantite_disponible_actuelle + ($produit->stock * $variante->quantite);

            // Mettre à jour la quantité disponible
            DB::table('produit_variante')
                ->where('produit_id', $produit->id)
                ->where('variante_id', $variante->variante_id)
                ->update([
                    'quantite_disponible' => $nouvelle_quantite,
                ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $request->validate([
                'produit_id.*' => 'required',
                'stock_initial.*' => 'required|numeric',
                'stock_theorique.*' => 'required|numeric',
                'stock_physique.*' => 'required|numeric',
                'ecart.*' => 'required|numeric',
                'etat.*' => 'required',
                'observation.*' => 'nullable',
            ]);

            // enregistrer la sortie
            $inventaire = new Inventaire();
            $inventaire->code = 'IN-' . strtoupper(Str::random(8));
            $inventaire->date_inventaire = Carbon::now();
            $inventaire->user_id = Auth::id();
            $inventaire->save();

            // enregistrer les produits de la sortie
            foreach ($request->produit_id as $key => $produit_id) {
                // Trouver l'unité correspondante pour ce produit
                $produit = Produit::find($produit_id);

                // Attacher le produit à la sortie avec les informations associées
                $inventaire->produits()->attach($produit_id, [
                    'stock_dernier_inventaire' => $produit->stock_dernier_inventaire, // direct dans la table produit
                    'stock_initial' => $request->stock_initial[$key], // nouveau stock ajouté apres l'inventaire precedent
                    'stock_theorique' => $request->stock_theorique[$key],
                    'stock_physique' => $request->stock_physique[$key],
                    'stock_vendu' => $request->stock_vendu[$key],
                    'ecart' => $request->ecart[$key],
                    'etat' => $request->etat[$key],
                    'observation' => $request->observation[$key],
                ]);

                // remplacer le stock  par le stock physique
                $produit->stock = $request->stock_physique[$key];

                // stock du dernier inventaire
                $produit->stock_dernier_inventaire = $request->stock_physique[$key];

                // mettre le stock initial a 0
                $produit->stock_initial = 0;

                $produit->save();

                // Vérifier si la catégorie famille est 'bar'
                if ($produit->categorie->famille === 'bar') {
                    // Mettre à jour la quantité disponible des variantes du produit à 0
                    DB::table('produit_variante')
                        ->where('produit_id', $produit_id)
                        ->update(['quantite_disponible' => 0]);

                    // Appeler la méthode miseAJourStock
                    $this->miseAJourStock($produit_id);
                }
            }


            // retur response
            return response()->json([
                'message' => 'Inventaire enregistré avec succès.',
                'statut' => 'success',
            ], 200);
            # code...
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        try {
            //filtrer les produit en fonction de leur etat du stock

            $etatFilter = request('filter_etat');

            $inventaire = Inventaire::with('produits')->find($id);

            if ($etatFilter) {
                $inventaire = Inventaire::with(['produits' => function ($query) use ($etatFilter) {
                    $query->wherePivot('etat', $etatFilter);
                }])->find($id);
            }
            
         

            return view('backend.pages.stock.inventaire.show', compact('inventaire'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventaire $inventaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventaire $inventaire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventaire $inventaire)
    {
        //
    }


    // Fiche inventaire
    public function ficheInventaire(Request $request)
    {
        try {
            // recuperer tous les produit en les groupant par categorie bar et restaurant
            $type = $request->query('type'); // Récupère le paramètre 'type' de l'URL

            if ($type == 'bar') {
                $produits = Produit::whereHas('categorie', function ($q) {
                    $q->where('famille', 'bar');
                })->get();
            } elseif ($type == 'restaurant') {
                $produits = Produit::whereHas('categorie', function ($q) {
                    $q->where('famille', 'restaurant');
                })->get();
            } else {
                // Récupère les produits des familles 'bar' et 'restaurant' et les groupe par famille
                $produits = Produit::with('categorie')
                    ->whereHas('categorie', function ($q) {
                        $q->whereIn('famille', ['bar', 'restaurant']);
                    })
                    ->get();
                // ->groupBy('categorie.famille'); // Groupe les produits par famille
            }

            // dd($produits->toArray());

            return view('backend.pages.stock.inventaire.fiche', compact('produits'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
