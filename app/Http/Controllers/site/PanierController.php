<?php

namespace App\Http\Controllers\site;

use App\Models\Produit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class PanierController extends Controller
{
    //  // Afficher le contenu du panier
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('site.pages.panier' , compact('cart'));
        // return response()->json($cart);
    }

    // Ajouter un produit au panier
    // public function add(Request $request)
    // {
    //     $cart = session()->get('cart', []);

    //     $id = $request->input('id');
    //     $name = $request->input('name');
    //     $price = $request->input('price');
    //     $quantity = $request->input('quantity', 1);

    //     // Ajouter ou mettre à jour l'élément du panier
    //     if (isset($cart[$id])) {
    //         $cart[$id]['quantity'] += $quantity;
    //     } else {
    //         $cart[$id] = [
    //             'name' => $name,
    //             'price' => $price,
    //             'quantity' => $quantity
    //         ];
    //     }

    //     session()->put('cart', $cart);

    //     return response()->json(['status' => 'success', 'message' => 'Produit ajouté au panier', 'cart' => $cart]);
    // }


    //Ajouter des produit au panier
    public function add(Request $request, $id)
    {
        $id = $request->input('id');
        $price = $request->input('price');
        $quantity = $request->input('quantity', 1);

        $produit = Produit::findOrFail($id);

        $cart = session()->get('cart', []);

        $quantity = $request->input('quantity', 1);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                "id" => $produit->id,
                "code" => $produit->code,
                "slug" => $produit->slug,
                "title" => $produit->nom,
                "quantity" =>  $quantity,
                "price" => $price,
                "image" => $produit->media[0]->getUrl(),
            ];
        }

        session()->put('cart', $cart);

        //recuperer la quantité et montant total des produit du panier
        $countCart = count((array) session('cart'));
        $data = Session::get('cart');
        $totalQuantity = 0;
        $totalPrice = 0;
        foreach ($data as $id => $value) {
            $totalQuantity += $value['quantity'];
            $totalPrice += $value['price'] * $value['quantity'];
        }

        session()->put([
            'totalQuantity'=> $totalQuantity ,
            'totalPrice' => $totalPrice
        ]);



        return response()->json([
            'countCart' => $countCart,
            'cart' => $cart,
            'totalQte' => $totalQuantity,
            'totalPrice' => $totalPrice,
        ]);
    }


    // Supprimer un produit du panier
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        $id = $request->input('id');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return response()->json(['status' => 'success', 'message' => 'Produit retiré du panier', 'cart' => $cart]);
    }

    // Vider le panier
    public function clear()
    {
        session()->forget('cart');
        return response()->json(['status' => 'success', 'message' => 'Panier vidé']);
    }
}
