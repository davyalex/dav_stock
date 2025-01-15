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
            $data_inventaire = Inventaire::with('produits')->get();

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
                }], 'produit_vente.quantite') // Somme de la quantité vendue dans le pivot produit_vente


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
            return view('backend.pages.stock.inventaire.create', compact('data_produit' , 'categorie_famille'));
        } catch (\Throwable $e) {
            return  $e->getMessage();
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
                    'stock_initial' => $request->stock_initial[$key],
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
            $inventaire = Inventaire::with('produits')->find($id);
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
}
