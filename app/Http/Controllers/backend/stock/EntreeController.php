<?php

namespace App\Http\Controllers\backend\stock;

use Carbon\Carbon;
use App\Models\Entree;
use App\Models\Produit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Intrant;
use Illuminate\Support\Facades\Auth;

class EntreeController extends Controller
{
    public function index()
    {
        try {
            $data_entree = Entree::with('intrants')->orderBy('created_at', 'desc')->get();
            return view('backend.pages.stock.entree.index', compact('data_entree'));
        } catch (\Throwable $e) {
            return  $e->getMessage();
        }
    }



    public function create(Request $request)
    {
        try {
            $data_produit = Intrant::alphabetique()->active()->get();
            return view('backend.pages.stock.entree.create', compact('data_produit'));
        } catch (\Throwable $e) {
            return  $e->getMessage();
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'date_entree' => 'required|date',
                'cart' => 'required|array|min:1',
                'cart.*.id' => 'required|exists:intrants,id',
                'cart.*.quantity' => 'required|integer|min:1',
            ]);

            $entree = new Entree();
            $entree->code = 'EN-' . strtoupper(Str::random(8));
            $entree->date_entree = $request->date_entree;
            $entree->user_id = Auth::id();
            $entree->save();

            $cart = $request->input('cart');

            foreach ($cart as $item) {
                $produit = Intrant::find($item['id']);
                $qtyEntree = $item['quantity'];
                $entree->intrants()->attach($produit->id, [
                    'stock_entree' => $qtyEntree,
                    'stock_disponible' => $produit->stock,
                ]);
                $produit->stock += $qtyEntree;
                $produit->save();
            }

            return response()->json([
                'message' => "Entrée de stock enregistrée avec succès.",
                'status' => 'success',
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ], 500);
        }
    }


        public function show($id)
    {
        try {
            $entree = Entree::with('intrants')->find($id);
            if (!$entree) {
                return redirect()->route('entree.index')->with('error', "L'entrée demandée n'existe pas.");
            }
            return view('backend.pages.stock.entree.show', compact('entree'));
        } catch (\Exception $e) {
            return redirect()->route('entree.index')->with('error', "Une erreur s'est produite. Veuillez réessayer.");
        }
    }

    public function delete($id)
    {
        $entree = Entree::with('intrants')->find($id);
        if (!$entree) {
            return response()->json(['message' => "Entrée non trouvée"], 404);
        }
        foreach ($entree->intrants as $produit) {
            $produitEntree = Intrant::find($produit->id);
            if (!$produitEntree) {
                continue;
            }
            $produitEntree->stock -= $produit->pivot->stock_entree;
            $produitEntree->save();
        }
        $entree->forceDelete();
        return response()->json(['status' => 200]);
    }
}
