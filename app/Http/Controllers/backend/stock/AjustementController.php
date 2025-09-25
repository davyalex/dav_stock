<?php

namespace App\Http\Controllers\backend\stock;

use Carbon\Carbon;
use App\Models\Produit;
use App\Models\Ajustement;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjustementController extends Controller
{
    public function index()
    {
        try {
            $data_ajustement = Ajustement::with('produits')->orderBy('created_at', 'desc')->get();
            return view('backend.pages.stock.ajustement.index', compact('data_ajustement'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        try {
            $ajustement = Ajustement::with('produits')->find($id);
            if (!$ajustement) {
                return redirect()->route('ajustement.index')->with('error', "L'ajustement demandé n'existe pas.");
            }
            return view('backend.pages.stock.ajustement.show', compact('ajustement'));
        } catch (\Exception $e) {
            return redirect()->route('ajustement.index')->with('error', "Une erreur s'est produite. Veuillez réessayer.");
        }
    }

    public function create(Request $request)
    {
        try {
            $data_produit = Produit::alphabetique()->active()->get();
            return view('backend.pages.stock.ajustement.create', compact('data_produit'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'date_ajustement' => 'required|date',
                'cart' => 'required|array|min:1',
                'cart.*.id' => 'required|exists:produits,id',
                'cart.*.quantity' => 'required|integer|min:1',
                'cart.*.type_ajustement' => 'required|in:ajouter,reduire',
            ]);

            $ajustement = new Ajustement();
            $ajustement->code = 'AJ-' . strtoupper(Str::random(8));
            $ajustement->date_ajustement = $request->date_ajustement;
            $ajustement->user_id = Auth::id();
            $ajustement->save();

            $cart = $request->input('cart');

            foreach ($cart as $item) {
                $produit = Produit::find($item['id']);
                $qty = $item['quantity'];
                $type = $item['type_ajustement'];

                // Historique de l'ajustement
                $ajustement->produits()->attach($produit->id, [
                    'stock_ajuste' => $qty,
                    'stock_disponible' => $produit->stock,
                    'type_ajustement' => $type,
                ]);

                // Mise à jour du stock
                if ($type === 'ajouter') {
                    $produit->stock += $qty;
                } elseif ($type === 'reduire') {
                    $produit->stock -= $qty;
                }
                $produit->save();
            }

            return response()->json([
                'message' => "Ajustement de stock enregistré avec succès.",
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
        try {
            $ajustement = Ajustement::with('produits')->find($id);
            if (!$ajustement) {
                return response()->json(['message' => "Ajustement non trouvé"], 404);
            }
            foreach ($ajustement->produits as $produit) {
                $produitAjustement = Produit::find($produit->id);
                if (!$produitAjustement) {
                    continue;
                }
                // Annuler l'ajustement
                if ($produit->pivot->type_ajustement === 'ajouter') {
                    $produitAjustement->stock -= $produit->pivot->stock_ajuste;
                } elseif ($produit->pivot->type_ajustement === 'reduire') {
                    $produitAjustement->stock += $produit->pivot->stock_ajuste;
                }

                $produitAjustement->save();
            }
            $ajustement->forceDelete();
            return response()->json(['status' => 200]);
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
