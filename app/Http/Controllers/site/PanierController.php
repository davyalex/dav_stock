<?php

namespace App\Http\Controllers\site;

use Carbon\Carbon;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class PanierController extends Controller
{
    //  // Afficher le contenu du panier
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('site.pages.panier', compact('cart'));
        // return response()->json($cart);
    }

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
        $countProductCart = count((array) session('cart')); //nombre de produit dans le panier
        $data = Session::get('cart');
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
            'cart' => $cart,
            'totalQte' => $totalQuantity,
            'totalPrice' => $totalPrice,
        ]);
    }



    //modifier et mettre à jour le panier
    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);

            //calculer le prix du produit * quantité (produit mis a jour)
            $totalPriceQty = $cart[$request->id]["price"] * $request->quantity;


            // calculer quantite, total , sous total
            $totalQuantity = 0;
            $sousTotal = 0;
            $totalPrice = 0;

            foreach ($cart as $value) {
                $totalQuantity += $value['quantity']; // Qté total
                $sousTotal += $value['quantity'] * $value['price']; // Sous total
                $totalPrice += $value['price'] * $value['quantity']; // total panier
            }

            session()->put([
                'totalQuantity' => $totalQuantity,
                'totalPrice' => $totalPrice
            ]);

            //
            return response()->json([
                'status' => 'success',
                'cart' => session()->get('cart'), // contenu du panier session
                'totalQte' => $totalQuantity, //total quantité
                'totalPrice' => $totalPrice, // total du panier
                "sousTotal" => number_format($sousTotal), // sous total du panier
                'totalPriceQty' => $totalPriceQty, // total du produit MAJ  * quantite
            ]);
        }
    }



    // Supprimer un produit du panier
    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }

            #MAJ des infos du panier

            // calculer quantite, total , sous total
            $totalQuantity = 0;
            $sousTotal = 0;
            $totalPrice = 0;

            foreach ($cart as $value) {
                $totalQuantity += $value['quantity']; // Qté total
                $sousTotal += $value['quantity'] * $value['price']; // Sous total
                $totalPrice += $value['price'] * $value['quantity']; // total panier
            }
            $countProductCart = count((array) session('cart')); // nombre de produit du panier
        }
        return response()->json([
            'status' => 'success',
            'totalQte' => $totalQuantity, //total quantité
            'totalPrice' => $totalPrice, // total du panier
            // "sousTotal" => number_format($sousTotal), // sous total du panier
            'countProductCart' => $countProductCart, // nombre de produit du panier
        ]);
    }

    // Vider le panier
    public function clear()
    {
        session()->forget('cart');
        return response()->json(['status' => 'success', 'message' => 'Panier vidé']);
    }


    //la caisse infos panier
    public function checkout(Request $request)
    {
        if (session('cart')) {
            return view('site.pages.caisse');
        }else{
            return redirect()->route('accueil');
        }
       
    }



    // Enregistrer la commande
    public function saveOrder(Request $request)
    {
        try {
            $cart = session()->get('cart');

            if (session('cart') && Auth::check()) {

                ##recuperer les infos du panier
                $nombreProduit = session('totalQuantity'); //nombre total des produit du panier
                $montantTotal = session('totalPrice'); //montant total

                $commande = Commande::firstOrCreate([
                    'code' => 'CMD-' . strtoupper(Str::random(8)),
                    'client_id' => Auth::id(),
                    'montant_total' => $montantTotal,
                    'nombre_produit' => $nombreProduit,
                    'mode_livraison' => $request->optionLivraison,
                    'adresse_livraison' => $request->adresseLivraison,
                    'date_commande' => Carbon::now()->format('Y-m-d'),
                    'statut' => 'en attente',
                ]);


                // enregistrement des produits dans la table pivot
                foreach (session('cart') as $key => $value) {
                    $commande->produits()->attach($key, [
                        'quantite' => $value['quantity'],
                        'prix_unitaire' => $value['price'],
                        'total' => $value['price'] * $value['quantity'],
                    ]);
                }


                // suppression de la session panier
                Session::forget('cart');
                Session::forget('totalQuantity');
                Session::forget('totalPrice');

                return response()->json([
                    'message' => 'commande enregistrée avec success',
                    'status' => 'success',
                ], 200);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
