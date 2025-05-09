<?php


namespace App\FunctionsUtils;

use Carbon\Carbon;
use App\Models\Produit;
use App\Models\Inventaire;




function productsNotInInventaire()
{
    // ##START FONCTION POUR METTRE A JOUR LE STOCK DES PRODUITS QUI NE SONT PAS DANS L'INVENTAIRE DU MOIS


    // recuperer l'inventaire du mois 
    $inventaire_mois = Inventaire::whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)
        ->first();

    // recuperer les produits de l'inventaire du mois
    $produits_inventaire = Produit::whereHas('inventaires', function ($query) use ($inventaire_mois) {
        $query->where('inventaires.id', $inventaire_mois->id);
    })->get();


    //recuperer les produits où la categorie famille est restaurant et  bar qui ne sont pas dans l'inventaire du mois
    $produits_not_inventaire = Produit::whereDoesntHave('inventaires', function ($query) use ($inventaire_mois) {
        $query->where('inventaires.id', $inventaire_mois->id);
    })->whereHas('categorie', function ($query) {
        $query->whereIn('famille', ['restaurant', 'bar']);
    })->get();

    // mettre le stock des produits qui ne sont pas dans l'inventaire du mois à 0
    foreach ($produits_not_inventaire as $produit) {
        $produit->update([
            'stock' => 0,
            'stock_dernier_inventaire' => 0,
            'stock_initial' => 0,
        ]);
    }

    // dd($produits_not_inventaire->toArray());

    ##END


}





function productsNotInInventaire2()
{
    // if (!function_exists('productsNotInInventaire')) {
    //     function productsNotInInventaire()
    //     {
    //         // Récupérer l'inventaire du mois courant
    //         $inventaire_mois = Inventaire::whereYear('created_at', now()->year)
    //             ->whereMonth('created_at', now()->month)
    //             ->first();

    //         // Si aucun inventaire trouvé, ne rien faire
    //         if (!$inventaire_mois) {
    //             return;
    //         }

    //         // Récupérer les produits de type "restaurant" ou "bar" non présents dans l'inventaire du mois
    //         $produits = Produit::whereDoesntHave('inventaires', function ($query) use ($inventaire_mois) {
    //             $query->where('inventaires.id', $inventaire_mois->id);
    //         })
    //             ->whereHas('categorie', function ($query) {
    //                 $query->whereIn('famille', ['restaurant', 'bar']);
    //             })
    //             ->get();

    //         // Mettre à jour en lot (plus performant que update() dans la boucle)
    //         foreach ($produits as $produit) {
    //             $produit->update([
    //                 'stock' => 0,
    //                 'stock_dernier_inventaire' => 0,
    //                 'stock_initial' => 0,
    //             ]);
    //         }
    //     }
    // }
}
    // ##START FONCTION POUR METTRE A JOUR LE STOCK DES PRODUITS QUI NE SONT PAS DANS L'INVENTAIRE DU MOIS
