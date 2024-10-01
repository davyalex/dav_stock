<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProduitsTableSeeder extends Seeder
{
    /**
     * Exécuter les seeds de la base de données.
     *
     * Cette méthode génère 5 produits différents pour peupler la table 'produits'.
     */
    public function run(): void
    {
        \DB::table('produits')->delete();
        
        \DB::table('produits')->insert([
            [
                'id' => 1,
                'code' => 'PROD001',
                'nom' => 'Burger Classique',
                'slug' => 'burger-classique',
                'prix' => 8.99,
                'stock_initial' => 100,
                'stock' => 100,
                'stock_alerte' => 20,
                'description' => 'Un délicieux burger classique avec du bœuf, du fromage, de la laitue et de la tomate.',
                'statut' => 'active',
                'categorie_id' => \App\Models\Categorie::where('name', 'Restaurant')->first()->id,
                'type_id' => \App\Models\Categorie::where('name', 'Restaurant')->first()->id,
                'user_id' => \App\Models\User::inRandomOrder()->first()->id,
                // 'magasin_id' => \App\Models\Magasin::first()->id,
                'quantite_unite' => 1,
                'unite_id' => \App\Models\Unite::first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ... Autres produits
        ]);
    }
   
}
