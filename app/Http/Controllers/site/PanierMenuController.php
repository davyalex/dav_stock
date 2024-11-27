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


    // public function add(Request $request, $id)
    // {
    //     // Récupérer les données envoyées
    //     $platId = $request->input('id');
    //     $complementId = $request->input('complement_id');
    //     $garnitureId = $request->input('garniture_id');
    //     $quantity = $request->input('quantity');
    //     $price = $request->input('price');

    //     $plat = Plat::findOrFail($platId);
    //     $complement = Plat::findOrFail($complementId);
    //     $garniture = Plat::findOrFail($garnitureId);



    //     // Préparer les données du produit à ajouter au panier
    //     $platData = [
    //         'plat_id' => $platId, // id du plat
    //         'title_plat' => $plat->nom, // nom du plat
    //         'image_plat' => $plat->media->isNotEmpty() ? $plat->media[0]->getUrl() : null, // image du plat
    //         "code_plat" => $plat->code,
    //         "slug_plat" => $plat->slug,
    //         'description_plat' => $plat->description, // description du plat


    //         //complement
    //         'complement_id' => $complementId,
    //         'title_complement' => $complement->nom, // nom du plat
    //         "code_complement" => $complement->code,
    //         "slug_complement" => $complement->slug,

    //         //garniture
    //         'garniture_id' => $garnitureId,
    //         'title_garniture' => $garniture->nom, // nom du plat
    //         "code_garniture" => $garniture->code,
    //         "slug_garniture" => $garniture->slug,

    //         'quantity' => $quantity,
    //         'price' => $price,
    //     ];

    //     // Vérifier si la session 'cart' existe déjà, sinon la créer
    //     $cartMenu = session()->get('cartMenu', []);

    //     // Si le produit existe déjà dans le panier, mettez à jour la quantité
    //     if (isset($cartMenu[$platId])) {
    //         $cartMenu[$platId]['quantity'] += $quantity;
    //     } else {
    //         // Sinon, ajoutez le produit au panier
    //         $cartMenu[$platId] = $platData;
    //     }

    //     // Sauvegarder le panier dans la session
    //     session()->put('cartMenu', $cartMenu);

    //     // Retourner les nouvelles données du panier (quantité totale et prix total)
    //     $totalQuantity = array_sum(array_column($cartMenu, 'quantity'));
    //     $totalPrice = array_sum(array_map(function ($item) {
    //         return $item['price'] * $item['quantity'];
    //     }, $cartMenu));

    //     return response()->json([
    //         'totalQte' => $totalQuantity, // quantité de plat
    //         'totalPrice' => $totalPrice,  // montant total
    //         'cartMenu' => $cartMenu,
    //     ]);
    // }


    // public function add(Request $request, $id)
    // {
    //     // Valider les données entrées
    //     $validated = $request->validate([
    //         'complement_id' => 'nullable|exists:plats,id',
    //         'garniture_id' => 'nullable|exists:plats,id',
    //         'quantity' => 'required|integer|min:1',
    //         'price' => 'required|numeric|min:0',
    //     ]);

    //     try {
    //         // Récupérer le plat, complément et garniture avec une seule requête pour plus d'efficacité
    //         $plats = Plat::whereIn('id', [
    //             $id,
    //             $validated['complement_id'] ?? null,
    //             $validated['garniture_id'] ?? null,
    //         ])->get()->keyBy('id');

    //         $plat = $plats->get($id);
    //         $complement = $plats->get($validated['complement_id']);
    //         $garniture = $plats->get($validated['garniture_id']);

    //         if (!$plat) {
    //             return response()->json(['error' => 'Plat non trouvé.'], 404);
    //         }

    //         // Préparer les données du produit à ajouter au panier
    //         $platData = [
    //             'plat_id' => $plat->id,
    //             'title_plat' => $plat->nom,
    //             'image_plat' => $plat->media->isNotEmpty() ? $plat->media[0]->getUrl() : null,
    //             'code_plat' => $plat->code,
    //             'slug_plat' => $plat->slug,
    //             'description_plat' => $plat->description,

    //             'complement_id' => $complement ? $complement->id : null,
    //             'title_complement' => $complement ? $complement->nom : null,
    //             'code_complement' => $complement ? $complement->code : null,
    //             'slug_complement' => $complement ? $complement->slug : null,

    //             'garniture_id' => $garniture ? $garniture->id : null,
    //             'title_garniture' => $garniture ? $garniture->nom : null,
    //             'code_garniture' => $garniture ? $garniture->code : null,
    //             'slug_garniture' => $garniture ? $garniture->slug : null,

    //             'quantity' => $validated['quantity'],
    //             'price' => $validated['price'],
    //         ];

    //         // Vérifier si la session 'cartMenu' existe déjà, sinon la créer
    //         $cartMenu = session()->get('cartMenu', []);

    //         // Si le plat existe déjà dans le panier, mettre à jour la quantité
    //         if (isset($cartMenu[$plat->id])) {
    //             $cartMenu[$plat->id]['quantity'] += $validated['quantity'];
    //         } else {
    //             // Sinon, ajouter le plat au panier
    //             $cartMenu[$plat->id] = $platData;
    //         }

    //         // Sauvegarder le panier dans la session
    //         session()->put('cartMenu', $cartMenu);

    //         // Calculer la quantité totale et le prix total
    //         $totalQuantity = array_sum(array_column($cartMenu, 'quantity'));
    //         $totalPrice = array_sum(array_map(function ($item) {
    //             return $item['price'] * $item['quantity'];
    //         }, $cartMenu));

    //         return response()->json([
    //             'totalQte' => $totalQuantity,
    //             'totalPrice' => $totalPrice,
    //             'cartMenu' => $cartMenu,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Une erreur est survenue lors de l\'ajout au panier.'], 500);
    //     }
    // }


    // public function add(Request $request, $id)
    // {
    //     // Valider les données entrées
    //     $validated = $request->validate([
    //         'complement_id' => 'nullable|exists:plats,id',
    //         'garniture_id' => 'nullable|exists:plats,id',
    //         'quantity' => 'required|integer|min:1',
    //         'price' => 'required|numeric|min:0',
    //     ]);

    //     try {
    //         // Récupérer le plat, complément et garniture
    //         $plats = Plat::whereIn('id', [
    //             $id,
    //             $validated['complement_id'] ?? null,
    //             $validated['garniture_id'] ?? null,
    //         ])->get()->keyBy('id');

    //         $plat = $plats->get($id);
    //         $complement = $plats->get($validated['complement_id']);
    //         $garniture = $plats->get($validated['garniture_id']);

    //         if (!$plat) {
    //             return response()->json(['error' => 'Plat non trouvé.'], 404);
    //         }

    //         // Générer une clé unique pour différencier chaque combinaison
    //         $cartKey = implode('-', [
    //             $plat->id,
    //             $complement ? $complement->id : '0',
    //             $garniture ? $garniture->id : '0',
    //         ]) . '-' . uniqid(); // Ajout d'un ID unique pour chaque entrée

    //         // Préparer les données du produit à ajouter au panier
    //         $platData = [
    //             'plat_id' => $plat->id,
    //             'title_plat' => $plat->nom,
    //             'image_plat' => $plat->media->isNotEmpty() ? $plat->media[0]->getUrl() : null,
    //             'code_plat' => $plat->code,
    //             'slug_plat' => $plat->slug,
    //             'description_plat' => $plat->description,

    //             'complement_id' => $complement ? $complement->id : null,
    //             'title_complement' => $complement ? $complement->nom : null,
    //             'code_complement' => $complement ? $complement->code : null,
    //             'slug_complement' => $complement ? $complement->slug : null,

    //             'garniture_id' => $garniture ? $garniture->id : null,
    //             'title_garniture' => $garniture ? $garniture->nom : null,
    //             'code_garniture' => $garniture ? $garniture->code : null,
    //             'slug_garniture' => $garniture ? $garniture->slug : null,

    //             'quantity' => $validated['quantity'],
    //             'price' => $validated['price'],
    //         ];

    //         // Récupérer ou initialiser le panier
    //         $cartMenu = session()->get('cartMenu', []);

    //         // Ajouter cette nouvelle combinaison dans le panier avec sa clé unique
    //         $cartMenu[$cartKey] = $platData;

    //         // Sauvegarder le panier dans la session
    //         session()->put('cartMenu', $cartMenu);

    //         // Calculer la quantité totale et le prix total
    //         $totalQuantity = array_sum(array_column($cartMenu, 'quantity'));
    //         $totalPrice = array_sum(array_map(function ($item) {
    //             return $item['price'] * $item['quantity'];
    //         }, $cartMenu));

    //         return response()->json([
    //             'totalQte' => $totalQuantity,
    //             'totalPrice' => $totalPrice,
    //             'cartMenu' => $cartMenu,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Une erreur est survenue lors de l\'ajout au panier.'], 500);
    //     }
    // }


    public function add(Request $request, $id)
    {
        // Valider les données entrées
        $validated = $request->validate([
            'complement_id' => 'nullable|exists:plats,id',
            'garniture_id' => 'nullable|exists:plats,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        try {
            // Récupérer le plat, complément et garniture
            $plats = Plat::whereIn('id', [
                $id,
                $validated['complement_id'] ?? null,
                $validated['garniture_id'] ?? null,
            ])->get()->keyBy('id');

            $plat = $plats->get($id);
            $complement = $plats->get($validated['complement_id']);
            $garniture = $plats->get($validated['garniture_id']);

            if (!$plat) {
                return response()->json(['error' => 'Plat non trouvé.'], 404);
            }

            // Préparer les données du produit
            $platData = [
                'plat_id' => $plat->id,
                'complement_id' => $complement ? $complement->id : null,
                'garniture_id' => $garniture ? $garniture->id : null,
                'quantity' => $validated['quantity'],
                'price' => $validated['price'],
            ];

            // Récupérer ou initialiser le panier
            $cartMenu = session()->get('cartMenu', []);

            // Chercher une entrée existante avec les mêmes attributs
            $existingKey = null;
            foreach ($cartMenu as $key => $item) {
                if (
                    $item['plat_id'] == $platData['plat_id'] &&
                    $item['complement_id'] == $platData['complement_id'] &&
                    $item['garniture_id'] == $platData['garniture_id']
                ) {
                    $existingKey = $key;
                    break;
                }
            }

            if ($existingKey !== null) {
                // Si une entrée existe déjà, mettre à jour la quantité
                $cartMenu[$existingKey]['quantity'] += $validated['quantity'];
            } else {
                // Sinon, ajouter une nouvelle entrée
                $cartKey = (int)uniqid();
                $cartMenu[$cartKey] = $platData + [
                    'title_plat' => $plat->nom,
                    'image_plat' => $plat->media->isNotEmpty() ? $plat->media[0]->getUrl() : null,
                    'code_plat' => $plat->code,
                    'slug_plat' => $plat->slug,
                    'description_plat' => $plat->description,
                    'title_complement' => $complement ? $complement->nom : null,
                    'code_complement' => $complement ? $complement->code : null,
                    'slug_complement' => $complement ? $complement->slug : null,
                    'title_garniture' => $garniture ? $garniture->nom : null,
                    'code_garniture' => $garniture ? $garniture->code : null,
                    'slug_garniture' => $garniture ? $garniture->slug : null,
                ];
            }

            // Sauvegarder le panier dans la session
            session()->put('cartMenu', $cartMenu);

            // Calculer la quantité totale et le prix total
            $totalQuantity = array_sum(array_column($cartMenu, 'quantity'));
            $totalPrice = array_sum(array_map(function ($item) {
                return $item['price'] * $item['quantity'];
            }, $cartMenu));

            // session()->put([
            //     'totalQuantityMenu' => $totalQuantity,
            //     'totalPriceMenu' => $totalPrice,
            // ]);

            return response()->json([
                'totalQte' => $totalQuantity,
                'totalPrice' => $totalPrice,
                'cartMenu' => $cartMenu,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue lors de l\'ajout au panier.'], 500);
        }
    }


    // Modifier la quantité
    // public function updateQuantity(Request $request, $id)
    // {
    //     $cartMenu = session()->get('cartMenu', []);

    //     if (isset($cartMenu[$id])) {
    //         $cartMenu[$id]['quantity'] = $request->input('quantity');
    //         session()->put('cartMenu', $cartMenu);
    //     }

    //     return response()->json(['status' => 'success', 'cartMenu' => $cartMenu]);
    // }


    //modifier et mettre à jour le panier
    // public function update(Request $request)
    // {
    //     if ($request->id && $request->quantite) {
    //         $cartMenu = session()->get('cartMenu');
    //         $cartMenu[$request->id]["quantity"] = $request->quantityMenu;
    //         session()->put('cartMenu', $cartMenu);

    //         //calculer le prix du produit * quantité (produit mis a jour)
    //         $totalPriceQty = $cartMenu[$request->id]["price"] * $request->quantityMenu;


    //         // calculer quantite, total , sous total
    //         $totalQuantity = 0;
    //         $sousTotal = 0;
    //         $totalPrice = 0;

    //         foreach ($cartMenu as $value) {
    //             $totalQuantity += $value['quantity']; // Qté total
    //             $sousTotal += $value['quantity'] * $value['price']; // Sous total
    //             $totalPrice += $value['price'] * $value['quantity']; // total panier
    //         }

    //         session()->put([
    //             'totalQuantity' => $totalQuantity,
    //             'totalPrice' => $totalPrice
    //         ]);

    //         //
    //         return response()->json([
    //             'status' => 'success',
    //             'cartMenu' => session()->get('cartMenu'), // contenu du panier session
    //             'totalQte' => $totalQuantity, //total quantité
    //             'totalPrice' => $totalPrice, // total du panier
    //             "sousTotal" => number_format($sousTotal), // sous total du panier
    //             'totalPriceQty' => $totalPriceQty, // total du produit MAJ  * quantite
    //         ]);
    //     }
    // }


    public function update(Request $request)
    {
        $validated = $request->validate([
            'cart_key' => 'required|string',
            'quantityMenu' => 'required|integer|min:1',
        ]);

        try {
            // Récupérer le panier actuel
            $cartMenu = session()->get('cartMenu', []);

            // Vérifier si la clé existe dans le panier
            if (isset($cartMenu[$validated['cart_key']])) {
                // Mettre à jour la quantité
                $cartMenu[$validated['cart_key']]['quantity'] = $validated['quantityMenu'];

                // Sauvegarder les changements dans la session
                session()->put('cartMenu', $cartMenu);

                // Recalculer les totaux
                $totalQuantity = array_sum(array_column($cartMenu, 'quantity'));
                $totalPrice = array_sum(array_map(function ($item) {
                    return $item['price'] * $item['quantity'];
                }, $cartMenu));

                // session()->put([
                //     'totalQuantityMenu' => $totalQuantity,
                //     'totalPriceMenu' => $totalPrice,
                // ]);

                return response()->json([
                    'status' => 'success',
                    'totalQte' => $totalQuantity,
                    'totalPrice' => $totalPrice,
                    'totalPriceQty' => $cartMenu[$validated['cart_key']]['price'] * $validated['quantityMenu'],
                ]);
            } else {
                return response()->json(['error' => 'Plat non trouvé dans le panier.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue lors de la mise à jour du panier.'], 500);
        }
    }


    public function remove(Request $request)
    {
        $cartKey = $request->input('cart_key');

        // Vérifier si le panier existe dans la session
        if (session()->has('cartMenu')) {
            $cartMenu = session('cartMenu');

            // Vérifier si l'élément existe dans le panier
            if (isset($cartMenu[$cartKey])) {
                unset($cartMenu[$cartKey]); // Supprimer l'élément du panier
                session(['cartMenu' => $cartMenu]); // Mettre à jour la session

                // Calculer les nouvelles valeurs
                $totalQte = array_sum(array_column($cartMenu, 'quantity'));
                $totalPrice = array_reduce($cartMenu, function ($total, $item) {
                    return $total + ($item['price'] * $item['quantity']);
                }, 0);

                return response()->json([
                    'status' => 'success',
                    'totalQte' => $totalQte,
                    'totalPrice' => $totalPrice
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Produit introuvable dans le panier.'
        ]);
    }
}
