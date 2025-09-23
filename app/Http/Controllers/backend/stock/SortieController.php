<?php

namespace App\Http\Controllers\backend\stock;

use Carbon\Carbon;
use App\Models\Unite;
use App\Models\Sortie;
use App\Models\Produit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SortieController extends Controller
{
    //

    public function index()
    {
        try {
            $data_sortie = Sortie::with('produits')->orderBy('created_at', 'desc')->get();

            return view('backend.pages.stock.sortie.index', compact('data_sortie'));
        } catch (\Throwable $e) {
            return  $e->getMessage();
        }
    }


    public function show($id)
    {
        try {
            $sortie = Sortie::with('produits')->find($id);

            // Vérifier si la sortie existe
            if (!$sortie) {
                return redirect()->route('sortie.index')->with('error', "La sortie demandée n'existe pas.");
            }

            return view('backend.pages.stock.sortie.show', compact('sortie'));
        } catch (\Exception $e) {
            return redirect()->route('sortie.index')->with('error', "Une erreur s'est produite. Veuillez réessayer.");
        }
    }



    public function create(Request $request)
    {

        try {
            $data_produit = Produit::where('stock', '>', 0)->active()->alphabetique()
                ->get();


            // dd($data_produit->toArray());
            return view('backend.pages.stock.sortie.create', compact('data_produit'));
        } catch (\Throwable $e) {
            return  $e->getMessage();
        }
    }


    public function store(Request $request)
    {
        try {
            // Validation stricte
            $request->validate([
                'date_sortie' => 'required|date',
                'cart' => 'required|array|min:1',
                'cart.*.id' => 'required|exists:produits,id',
                'cart.*.quantity' => 'required|integer|min:1',
            ]);

            // Création de la sortie
            $sortie = new Sortie();
            $sortie->code = 'SO-' . strtoupper(Str::random(8));
            $sortie->date_sortie = $request->date_sortie;
            $sortie->user_id = Auth::id();
            $sortie->save();

            $cart = $request->input('cart');

            foreach ($cart as $item) {
                $produit = Produit::find($item['id']);

                // Sécurité : ne pas sortir plus que le stock disponible
                $qtySortie = min($item['quantity'], $produit->stock);

                // Attacher le produit à la sortie
                $sortie->produits()->attach($produit->id, [
                    'stock_sortie' => $qtySortie,
                    'stock_disponible' => $produit->stock,
                ]);

                // Mise à jour du stock
                $produit->stock -= $qtySortie;
                $produit->save();
            }

            return response()->json([
                'message' => 'Sortie de stock enregistrée avec succès.',
                'status' => 'success',
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ], 500);
        }
    }




      public function delete($id)
    {
        $sortie = Sortie::with('produits')->find($id);

        if (!$sortie) {
            return response()->json(['message' => 'Sortie non trouvée'], 404);
        }

        foreach ($sortie->produits as $produit) {
            $produitSortie = Produit::find($produit->id);
            if (!$produitSortie) {
                continue;
            }
            // récupérer la quantité sortie via la table pivot
            $produitSortie->stock += $produit->pivot->stock_sortie;
            $produitSortie->save();
        }

        $sortie->forceDelete();

        return response()->json(['status' => 200]);
    }
}
