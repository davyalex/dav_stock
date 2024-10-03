<?php

namespace App\Http\Controllers\backend\stock;

use Carbon\Carbon;
use App\Models\Unite;
use App\Models\Produit;
use App\Models\Inventaire;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
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
            $data_produit = Produit::whereHas('categorie', function ($q) {
                $q->whereIn('famille', ['restaurant', 'bar']);
            })->get();



            // dd($data_produit->toArray());
            return view('backend.pages.stock.inventaire.create', compact('data_produit'));
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
                    'ecart' => $request->ecart[$key],
                    'etat' => $request->etat[$key],
                    'observation' => $request->observation[$key],
                ]);

                // remplacer le stock  par le stock physique
                $produit->stock = $request->stock_physique[$key];
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
