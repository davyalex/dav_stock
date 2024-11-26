<?php

namespace App\Http\Controllers\site;

use App\Models\Plat;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PanierMenuController extends Controller
{
    //


    public function add(Request $request, $id)
    {
        $id = $request->input('id'); // produit id
        $complement = $request->input('complement_id'); // id du complement ajouter
        $price = $request->input('price');
        $quantity = $request->input('quantity', 1);

        $produit = Plat::findOrFail($id); // recuperer le produit
        $complement = Plat::findOrFail($complement); // recuperer le complement associé au produit

        $cartMenu = session()->get('cartMenu', []);

        $quantity = $request->input('quantity', 1);

        if (isset($cartMenu[$id])) {
            $cartMenu[$id]['quantity'] += $quantity;
        } else {
            $cartMenu[$id] = [
                "id" => $produit->id,
                "code" => $produit->code,
                "slug" => $produit->slug,
                "title" => $produit->nom,
                "quantity" =>  $quantity,
                "price" => $price,
                "image" => $produit->media[0]->getUrl(),
            ];
        }

        session()->put('cartMenu', $cartMenu);

        //recuperer la quantité et montant total des produit du panier
        $countProductCart = count((array) session('cartMenu')); //nombre de produit dans le panier
        $data = Session::get('cartMenu');
        $totalQuantity = 0;
        $totalPrice = 0;
        foreach ($data as $id => $value) {
            $totalQuantity += $value['quantity']; // Qté total
            $totalPrice += $value['price'] * $value['quantity']; // total panier
        }

        session()->put([
            'totalQuantity' => $totalQuantity,
            'totalPrice' => $totalPrice
        ]);



        return response()->json([
            'countProductCart' => $countProductCart,
            'cartMenu' => $cartMenu,
            'totalQte' => $totalQuantity,
            'totalPrice' => $totalPrice,
        ]);
    }
}
