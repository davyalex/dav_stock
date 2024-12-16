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

    //         // Préparer les données du produit
    //         $platData = [
    //             'plat_id' => $plat->id,
    //             'complement_id' => $complement ? $complement->id : null,
    //             'garniture_id' => $garniture ? $garniture->id : null,
    //             'quantity' => $validated['quantity'],
    //             'price' => $validated['price'],
    //         ];

    //         // Récupérer ou initialiser le panier
    //         $cartMenu = session()->get('cartMenu', []);

    //         // Chercher une entrée existante avec les mêmes attributs
    //         $existingKey = null;
    //         foreach ($cartMenu as $key => $item) {
    //             if (
    //                 $item['plat_id'] == $platData['plat_id'] &&
    //                 $item['complement_id'] == $platData['complement_id'] &&
    //                 $item['garniture_id'] == $platData['garniture_id']
    //             ) {
    //                 $existingKey = $key;
    //                 break;
    //             }
    //         }

    //         if ($existingKey !== null) {
    //             // Si une entrée existe déjà, mettre à jour la quantité
    //             $cartMenu[$existingKey]['quantity'] += $validated['quantity'];
    //         } else {
    //             // Sinon, ajouter une nouvelle entrée
    //             $cartKey = (int)uniqid();
    //             $cartMenu[$cartKey] = $platData + [
    //                 'title_plat' => $plat->nom,
    //                 'image_plat' => $plat->media->isNotEmpty() ? $plat->media[0]->getUrl() : null,
    //                 'code_plat' => $plat->code,
    //                 'slug_plat' => $plat->slug,
    //                 'description_plat' => $plat->description,
    //                 'title_complement' => $complement ? $complement->nom : null,
    //                 'code_complement' => $complement ? $complement->code : null,
    //                 'slug_complement' => $complement ? $complement->slug : null,
    //                 'title_garniture' => $garniture ? $garniture->nom : null,
    //                 'code_garniture' => $garniture ? $garniture->code : null,
    //                 'slug_garniture' => $garniture ? $garniture->slug : null,
    //             ];
    //         }

    //         // Sauvegarder le panier dans la session
    //         session()->put('cartMenu', $cartMenu);



    //         // Calculer la quantité totale et le prix total
    //         $totalQuantity = array_sum(array_column($cartMenu, 'quantity'));
    //         $totalPrice = array_sum(array_map(function ($item) {
    //             return $item['price'] * $item['quantity'];
    //         }, $cartMenu));
    //         // Sauvegarder le panier et les totaux dans la session
    //         session()->put('totalQuantityMenu', $totalQuantity);
    //         session()->put('totalPriceMenu', $totalPrice);

    //         return response()->json([
    //             'totalQte' => $totalQuantity,
    //             'totalPrice' => $totalPrice,
    //             'cartMenu' => $cartMenu,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Une erreur est survenue lors de l\'ajout au panier.'], 500);
    //     }
    // }

    #### All -ADD 11/12/2024  ---- 16h54
    // public function add(Request $request)
    // {
    //     // Valider les données reçues
    //     $validated = $request->validate([
    //         'items' => 'required|array',
    //         'items.*.id' => 'required|exists:plats,id',
    //         'items.*.quantity' => 'required|integer|min:1',
    //         'items.*.complement_id' => 'nullable|exists:plats,id',
    //         'items.*.garniture_id' => 'nullable|exists:plats,id',
    //         'items.*.price' => 'required|numeric|min:0',
    //     ]);

    //     try {
    //         $cartMenu = session()->get('cartMenu', []);

    //         foreach ($validated['items'] as $item) {
    //             // Récupérer les plats principaux, compléments et garnitures
    //             $plats = Plat::whereIn('id', [
    //                 $item['id'],
    //                 $item['complement_id'] ?? null,
    //                 $item['garniture_id'] ?? null,
    //             ])->get()->keyBy('id');

    //             $plat = $plats->get($item['id']);
    //             $complement = $plats->get($item['complement_id']);
    //             $garniture = $plats->get($item['garniture_id']);

    //             if (!$plat) {
    //                 return response()->json(['error' => 'Plat non trouvé.'], 404);
    //             }

    //             $platData = [
    //                 'plat_id' => $plat->id,
    //                 'complement_id' => $complement ? $complement->id : null,
    //                 'garniture_id' => $garniture ? $garniture->id : null,
    //                 'quantity' => $item['quantity'],
    //                 'price' => $item['price'] +
    //                     ($complement ? $complement->price : 0) +
    //                     ($garniture ? $garniture->price : 0),
    //             ];

    //             // Vérifier si l'entrée existe déjà dans le panier
    //             $existingKey = null;
    //             foreach ($cartMenu as $key => $cartItem) {
    //                 if (
    //                     $cartItem['plat_id'] == $platData['plat_id'] &&
    //                     $cartItem['complement_id'] == $platData['complement_id'] &&
    //                     $cartItem['garniture_id'] == $platData['garniture_id']
    //                 ) {
    //                     $existingKey = $key;
    //                     break;
    //                 }
    //             }

    //             if ($existingKey !== null) {
    //                 // Mettre à jour la quantité si l'entrée existe déjà
    //                 $cartMenu[$existingKey]['quantity'] += $platData['quantity'];
    //             } else {
    //                 // Ajouter une nouvelle entrée au panier
    //                 $cartMenu[] = $platData + [
    //                     'title_plat' => $plat->nom,
    //                     'image_plat' => $plat->media->isNotEmpty() ? $plat->media[0]->getUrl() : null,
    //                     'title_complement' => $complement ? $complement->nom : null,
    //                     'title_garniture' => $garniture ? $garniture->nom : null,
    //                     'categorie_menu' => $plat->categorieMenu->nom,
    //                 ];
    //             }
    //         }

    //         // Calcul des totaux
    //         $totalQuantity = array_sum(array_column($cartMenu, 'quantity'));
    //         $totalPrice = array_sum(array_map(function ($item) {
    //             return $item['price'] * $item['quantity'];
    //         }, $cartMenu));

    //         // Sauvegarder dans la session
    //         session()->put('cartMenu', $cartMenu);
    //         session()->put('totalQuantityMenu', $totalQuantity);
    //         session()->put('totalPriceMenu', $totalPrice);

    //         return response()->json([
    //             'totalQte' => $totalQuantity,
    //             'totalPrice' => $totalPrice,
    //             'cartMenu' => $cartMenu,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Une erreur est survenue lors de l\'ajout au panier.'], 500);
    //     }
    // }
    #############END ##########


    // public function add(Request $request)
    // {
    //     // Valider les données reçues
    //     $validated = $request->validate([
    //         'items' => 'required|array',
    //         'items.*.id' => 'required|exists:plats,id',
    //         'items.*.quantity' => 'required|integer|min:1',
    //         'items.*.complements' => 'nullable|array',
    //         'items.*.complements.*.id' => 'required|exists:plats,id',
    //         'items.*.complements.*.quantity' => 'required|integer|min:1',
    //         'items.*.garnitures' => 'nullable|array',
    //         'items.*.garnitures.*.id' => 'required|exists:plats,id',
    //         'items.*.garnitures.*.quantity' => 'required|integer|min:1',
    //         'items.*.price' => 'required|numeric|min:0',
    //     ]);

    //     try {
    //         // Récupérer le panier existant ou initialiser un nouveau
    //         $cartMenu = session()->get('cartMenu', []);

    //         foreach ($validated['items'] as $item) {
    //             $platsIds = [$item['id']];

    //             // Récupérer les ID des compléments et garnitures
    //             $complements = $item['complements'] ?? [];
    //             $garnitures = $item['garnitures'] ?? [];

    //             foreach ($complements as $complement) {
    //                 $platsIds[] = $complement['id'];
    //             }
    //             foreach ($garnitures as $garniture) {
    //                 $platsIds[] = $garniture['id'];
    //             }

    //             // Récupérer les plats, compléments et garnitures depuis la base de données
    //             $plats = Plat::whereIn('id', $platsIds)->get()->keyBy('id');
    //             $plat = $plats->get($item['id']);
    //             if (!$plat) {
    //                 return response()->json(['error' => 'Plat non trouvé.'], 404);
    //             }

    //             // Calculer le prix total pour le plat, les compléments et garnitures
    //             $complementDetails = [];
    //             $garnitureDetails = [];
    //             $priceTotal = $item['price'] * $item['quantity'];

    //             foreach ($complements as $complement) {
    //                 $complementPlat = $plats->get($complement['id']);
    //                 if ($complementPlat) {
    //                     $complementDetails[] = [
    //                         'id' => $complementPlat->id,
    //                         'nom' => $complementPlat->nom,
    //                         'quantity' => $complement['quantity'],
    //                         'price' => $complementPlat->price,
    //                     ];
    //                     $priceTotal += $complementPlat->price * $complement['quantity'];
    //                 }
    //             }

    //             foreach ($garnitures as $garniture) {
    //                 $garniturePlat = $plats->get($garniture['id']);
    //                 if ($garniturePlat) {
    //                     $garnitureDetails[] = [
    //                         'id' => $garniturePlat->id,
    //                         'nom' => $garniturePlat->nom,
    //                         'quantity' => $garniture['quantity'],
    //                         'price' => $garniturePlat->price,
    //                     ];
    //                     $priceTotal += $garniturePlat->price * $garniture['quantity'];
    //                 }
    //             }

    //             // Préparer les données pour le panier
    //             $platData = [
    //                 'plat_id' => $plat->id,
    //                 'quantity' => $item['quantity'],
    //                 'price' => $priceTotal,
    //                 'title_plat' => $plat->nom,
    //                 'image_plat' => $plat->media->isNotEmpty() ? $plat->media[0]->getUrl() : null,
    //                 'categorie_menu' => $plat->categorieMenu->nom,
    //                 'complements' => $complementDetails,
    //                 'garnitures' => $garnitureDetails,
    //             ];

    //             // Vérifier si une entrée similaire existe déjà dans le panier
    //             $existingKey = null;
    //             foreach ($cartMenu as $key => $cartItem) {
    //                 if (
    //                     $cartItem['plat_id'] == $platData['plat_id'] &&
    //                     json_encode($cartItem['complements']) === json_encode($platData['complements']) &&
    //                     json_encode($cartItem['garnitures']) === json_encode($platData['garnitures'])
    //                 ) {
    //                     $existingKey = $key;
    //                     break;
    //                 }
    //             }

    //             if ($existingKey !== null) {
    //                 // Mettre à jour la quantité si une entrée similaire existe
    //                 $cartMenu[$existingKey]['quantity'] += $platData['quantity'];
    //                 $cartMenu[$existingKey]['price'] += $platData['price'];
    //             } else {
    //                 // Ajouter une nouvelle entrée
    //                 $cartMenu[] = $platData;
    //             }
    //         }

    //         // Calcul des totaux
    //         $totalQuantity = array_sum(array_column($cartMenu, 'quantity'));
    //         $totalPrice = array_sum(array_map(function ($item) {
    //             return $item['price'];
    //         }, $cartMenu));

    //         // Sauvegarder dans la session
    //         session()->put('cartMenu', $cartMenu);
    //         session()->put('totalQuantityMenu', $totalQuantity);
    //         session()->put('totalPriceMenu', $totalPrice);

    //         return response()->json([
    //             'totalQte' => $totalQuantity,
    //             'totalPrice' => $totalPrice,
    //             'cartMenu' => $cartMenu,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Une erreur est survenue lors de l\'ajout au panier.'], 500);
    //     }
    // }



    // public function add(Request $request)
    // {
    //     // Valider les données reçues
    //     $validated = $request->validate([
    //         'items' => 'required|array',
    //         'items.*.id' => 'required|exists:plats,id',
    //         'items.*.quantity' => 'required|integer|min:1',
    //         'items.*.complement_id' => 'nullable|exists:plats,id',
    //         'items.*.garniture_id' => 'nullable|exists:plats,id',
    //         'items.*.price' => 'required|numeric|min:0',
    //     ], [
    //         'items.required' => 'Vous devez ajouter au moins un plat.',
    //         'items.*.id.required' => 'Le champ id est obligatoire pour chaque plat.',
    //         'items.*.quantity.required' => 'Le champ quantity est obligatoire pour chaque plat.',
    //         'items.*.price.required' => 'Le champ price est obligatoire pour chaque plat.',
    //     ]);

    //     try {
    //         // Récupérer ou initialiser le panier
    //         $cartMenu = session()->get('cartMenu', []);

    //         foreach ($validated['items'] as $item) {
    //             // Récupérer les plats principaux, compléments et garnitures
    //             $plats = Plat::whereIn('id', [
    //                 $item['id'],
    //                 $item['complement_id'] ?? null,
    //                 $item['garniture_id'] ?? null,
    //             ])->get()->keyBy('id');

    //             $plat = $plats->get($item['id']);
    //             $complement = $plats->get($item['complement_id']);
    //             $garniture = $plats->get($item['garniture_id']);

    //             // Vérifier que le plat principal existe
    //             if (!$plat) {
    //                 return response()->json(['error' => 'Le plat sélectionné n\'existe pas.'], 404);
    //             }

    //             // Calculer le prix total pour cet item
    //             $platData = [
    //                 'plat_id' => $plat->id,
    //                 'complement_id' => $complement ? $complement->id : null,
    //                 'garniture_id' => $garniture ? $garniture->id : null,
    //                 'quantity' => $item['quantity'],
    //                 'price' => $item['price'] +
    //                     ($complement ? $complement->price : 0) +
    //                     ($garniture ? $garniture->price : 0),
    //             ];

    //             // Vérifier si l'entrée existe déjà dans le panier
    //             $existingKey = null;
    //             foreach ($cartMenu as $key => $cartItem) {
    //                 if (
    //                     $cartItem['plat_id'] == $platData['plat_id'] &&
    //                     $cartItem['complement_id'] == $platData['complement_id'] &&
    //                     $cartItem['garniture_id'] == $platData['garniture_id']
    //                 ) {
    //                     $existingKey = $key;
    //                     break;
    //                 }
    //             }

    //             if ($existingKey !== null) {
    //                 // Mettre à jour la quantité si l'entrée existe déjà
    //                 $cartMenu[$existingKey]['quantity'] += $platData['quantity'];
    //             } else {
    //                 // Ajouter une nouvelle entrée au panier
    //                 $cartMenu[] = $platData + [
    //                     'title_plat' => $plat->nom,
    //                     'image_plat' => $plat->media->isNotEmpty() ? $plat->media[0]->getUrl() : null,
    //                     'title_complement' => $complement ? $complement->nom : null,
    //                     'title_garniture' => $garniture ? $garniture->nom : null,
    //                     'categorie_menu' => $plat->categorieMenu->nom,
    //                 ];
    //             }
    //         }

    //         // Calcul des totaux
    //         $totalQuantity = array_sum(array_column($cartMenu, 'quantity'));
    //         $totalPrice = array_sum(array_map(function ($item) {
    //             return $item['price'] * $item['quantity'];
    //         }, $cartMenu));

    //         // Sauvegarder dans la session
    //         session()->put('cartMenu', $cartMenu);
    //         session()->put('totalQuantityMenu', $totalQuantity);
    //         session()->put('totalPriceMenu', $totalPrice);

    //         return response()->json([
    //             'totalQte' => $totalQuantity,
    //             'totalPrice' => $totalPrice,
    //             'cartMenu' => $cartMenu,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => 'Une erreur est survenue lors de l\'ajout au panier.',
    //             'message'=> $e->getMessage()

    //             ]
    //             , 500);
    //     }
    // }


    public function add(Request $request)
    {
        if (session()->has('cartMenu')) {
            session()->forget('cartMenu');
        }

        try {


            // Valider les données reçues
            $validated = $request->validate([
                'items' => 'required|array',
                'items.*.plat.id' => 'required|exists:plats,id',
                'items.*.plat.quantity' => 'required|integer|min:1',
                'items.*.plat.price' => 'required|numeric|min:0',
                'items.*.complements' => 'nullable|array',
                'items.*.complements.*.id' => 'nullable|exists:plats,id',
                'items.*.complements.*.quantity' => 'nullable|integer|min:1',
                'items.*.garnitures' => 'nullable|array',
                'items.*.garnitures.*.id' => 'nullable|exists:plats,id',
                'items.*.garnitures.*.quantity' => 'nullable|integer|min:1',
            ], [
                'items.required' => 'Vous devez ajouter au moins un plat.',
                'items.*.plat.id.required' => 'Le champ id est obligatoire pour chaque plat.',
                'items.*.plat.quantity.required' => 'Le champ quantity est obligatoire pour chaque plat.',
                'items.*.plat.price.required' => 'Le champ price est obligatoire pour chaque plat.',
                'items.*.complements.*.quantity.required' => 'La quantité superieur 0 est obligatoire pour chaque complément.',
                'items.*.garnitures.*.quantity.required' => 'La quantité  superieur 0 est obligatoire pour chaque garniture.',
            ]);

            // Récupérer ou initialiser le panier
            $cartMenu = session()->get('cartMenu', []);

            foreach ($validated['items'] as $item) {
                $platData = $item['plat'];
                $platId = $platData['id'];

                // Récupérer les plats principaux, compléments et garnitures
                $plats = Plat::whereIn('id', array_merge(
                    [$platId],
                    array_column($item['complements'] ?? [], 'id'),
                    array_column($item['garnitures'] ?? [], 'id')
                ))->get()->keyBy('id');

                $plat = $plats->get($platId);

                if (!$plat) {
                    return response()->json(['error' => "Le plat sélectionné n'existe pas."], 404);
                }

                $complements = collect($item['complements'] ?? [])->map(function ($complementData) use ($plats) {
                    $complement = $plats->get($complementData['id']);
                    if ($complement) {
                        return [
                            'id' => $complement->id,
                            'quantity' => $complementData['quantity'] ?? 1,
                            'price' => $complement->price,
                            'nom' => $complement->nom,
                        ];
                    }
                    return null;
                })->filter()->values()->toArray();

                $garnitures = collect($item['garnitures'] ?? [])->map(function ($garnitureData) use ($plats) {
                    $garniture = $plats->get($garnitureData['id']);
                    if ($garniture) {
                        return [
                            'id' => $garniture->id,
                            'quantity' => $garnitureData['quantity'] ?? 1,
                            'price' => $garniture->price,
                            'nom' => $garniture->nom,
                        ];
                    }
                    return null;
                })->filter()->values()->toArray();

                // Calculer le prix total
                $totalItemPrice = $platData['price'] * $platData['quantity'] +
                    array_sum(array_map(function ($comp) {
                        return $comp['price'] * $comp['quantity'];
                    }, $complements)) +
                    array_sum(array_map(function ($garn) {
                        return $garn['price'] * $garn['quantity'];
                    }, $garnitures));

                // Ajouter au panier ou mettre à jour l'entrée existante
                $existingKey = null;
                foreach ($cartMenu as $key => $cartItem) {
                    if (
                        $cartItem['plat_id'] == $plat->id &&
                        json_encode($cartItem['complements']) === json_encode($complements) &&
                        json_encode($cartItem['garnitures']) === json_encode($garnitures)
                    ) {
                        $existingKey = $key;
                        break;
                    }
                }

                if ($existingKey !== null) {
                    $cartMenu[$existingKey]['quantity'] += $platData['quantity'];
                    $cartMenu[$existingKey]['price'] += $totalItemPrice;
                } else {
                    $cartMenu[] = [
                        'plat_id' => $plat->id,
                        'plat_name' => $plat->nom,
                        'categorie_menu' => $plat->categorieMenu->nom,
                        'quantity' => $platData['quantity'],
                        'price' => $totalItemPrice,
                        'complements' => $complements,
                        'garnitures' => $garnitures,
                        'image_plat' => $plat->media->isNotEmpty() ? $plat->media[0]->getUrl() : null,
                    ];
                }
            }

            // Calcul des totaux
            $totalQuantity = array_sum(array_column($cartMenu, 'quantity'));
            $totalPrice = array_sum(array_map(function ($item) {
                return $item['price'];
            }, $cartMenu));

            // Sauvegarder dans la session
            session()->put('cartMenu', $cartMenu);
            session()->put('totalQuantityMenu', $totalQuantity);
            session()->put('totalPriceMenu', $totalPrice);

            return response()->json([
                'totalQte' => $totalQuantity,
                'totalPrice' => $totalPrice,
                'cartMenu' => $cartMenu,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => "Une erreur est survenue lors de l'ajout au panier.",
                'message' => $e->getMessage()
            ], 500);
        }
    }





    //recuperer les infos du panier Menu
    public function getCartDataMenu()
    {
        return response()->json([
            'totalQte' => session('totalQuantityMenu', 0),
            'totalPrice' => session('totalPriceMenu', 0),
            'cartMenu' => session('cartMenu', []),

            // total calculé cartMenu & cart
            'qteNet' => session('totalQuantity', 0) + session('totalQuantityMenu', 0),
            'priceNet' => session('totalPrice', 0) + session('totalPriceMenu', 0)
        ]);
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
        // Validation des données de la requête
        $validated = $request->validate([
            'cart_key' => 'required|string',
            'quantityMenu' => 'required|integer|min:1',
        ]);

        try {
            // Récupérer le panier actuel depuis la session
            $cartMenu = session()->get('cartMenu', []);

            // Vérifier si la clé existe dans le panier
            if (!isset($cartMenu[$validated['cart_key']])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Plat non trouvé dans le panier.',
                ], 404);
            }

            // Mettre à jour la quantité du plat
            $cartMenu[$validated['cart_key']]['quantity'] = $validated['quantityMenu'];

            // Sauvegarder les changements dans la session
            session()->put('cartMenu', $cartMenu);

            // Recalculer les totaux
            $totalQuantity = array_sum(array_column($cartMenu, 'quantity'));
            $totalPrice = array_sum(array_map(function ($item) {
                return $item['price'] * $item['quantity'];
            }, $cartMenu));

            // Enregistrer les totaux dans la session
            session()->put([
                'totalQuantityMenu' => $totalQuantity,
                'totalPriceMenu' => $totalPrice,
            ]);

            // Calcul du prix total pour l'élément mis à jour
            $totalPriceQty = $cartMenu[$validated['cart_key']]['price'] * $validated['quantityMenu'];

            return response()->json([
                'status' => 'success',
                'totalQte' => $totalQuantity,
                'totalPrice' => $totalPrice, // Formaté avec deux décimales
                'totalPriceQty' => $totalPriceQty, // Formaté avec deux décimales
                'cartMenu' => $cartMenu, // Retourne le panier mis à jour

                // total calculé cartMenu & cart
                'qteNet' => session('totalQuantity', 0) + session('totalQuantityMenu', 0),
                'priceNet' => session('totalPrice', 0) + session('totalPriceMenu', 0)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de la mise à jour du panier.',
                'details' => $e->getMessage(), // Message d'erreur pour faciliter le débogage
            ], 500);
        }
    }



    public function remove(Request $request)
    {
        // Validation des données de la requête
        $validated = $request->validate([
            'cart_key' => 'required|string',
        ]);

        try {
            // Vérifier si le panier existe dans la session
            $cartMenu = session()->get('cartMenu', []);

            // Vérifier si l'élément existe dans le panier
            if (!isset($cartMenu[$validated['cart_key']])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Produit introuvable dans le panier.',
                ], 404);
            }

            // Supprimer l'élément du panier
            unset($cartMenu[$validated['cart_key']]);

            // Mettre à jour le panier dans la session
            session()->put('cartMenu', $cartMenu);

            // Calculer les nouvelles valeurs du panier
            $totalQuantity = array_sum(array_column($cartMenu, 'quantity'));
            $totalPrice = array_reduce($cartMenu, function ($total, $item) {
                return $total + ($item['price'] * $item['quantity']);
            }, 0);

            // Mettre à jour les totaux dans la session
            session()->put([
                'totalQuantityMenu' => $totalQuantity,
                'totalPriceMenu' => $totalPrice,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Produit supprimé avec succès.',
                'totalQte' => $totalQuantity,
                'totalPrice' => $totalPrice, // Formaté avec deux décimales
                'cartMenu' => $cartMenu, // Retourne le panier mis à jour


                // total calculé cartMenu & cart
                'qteNet' => session('totalQuantity', 0) + session('totalQuantityMenu', 0),
                'priceNet' => session('totalPrice', 0) + session('totalPriceMenu', 0)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de la suppression du produit.',
                'details' => $e->getMessage(), // Détails de l'erreur pour faciliter le débogage
            ], 500);
        }
    }
}
