<?php

namespace App\Http\Controllers\backend\stock;

use App\Models\Unite;
use App\Models\Produit;
use App\Models\Inventaire;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InventaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        try {
            $data_produit = Produit::whereHas('categorie', function ($q) {
                $q->whereIn('famille', ['restaurant' , 'bar']);
            })->where('stock', '>', 0)
                ->get();


            $data_unite = Unite::all();

            // dd($data_produit->toArray());
            return view('backend.pages.stock.inventaire.create', compact('data_produit', 'data_unite'));
        } catch (\Throwable $e) {
            return  $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventaire $inventaire)
    {
        //
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
