<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProduitSeeder extends Seeder
{
    public function run(): void
    {
           // 🔴 Désactiver les clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Vider d'abord les tables enfants (qui dépendent de produits)
        DB::table('produit_sortie')->truncate();
        // DB::table('produit_entree')->truncate();

        // Ensuite vider les tables parentes
        DB::table('produits')->truncate();
        // DB::table('categories')->truncate();

        // 🟢 Réactiver les clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Récupérer les catégories existantes
        $categories = DB::table('categories')->pluck('id')->toArray();
        $now = Carbon::now();

        // Ajouter 20 produits
        for ($i = 1; $i <= 20; $i++) {
            DB::table('produits')->insert([
                'code' => 'PROD-' . strtoupper(Str::random(6)),
                'nom' => 'Produit ' . $i,
                'slug' => Str::slug('Produit ' . $i),
                'description' => 'Description du produit ' . $i,
                'prix' => rand(100, 500) / 10,
                'stock_initial' => rand(10, 50),
                'stock' => rand(5, 40),
                'stock_dernier_inventaire' => rand(5, 40),
                'stock_alerte' => rand(2, 10),
                'categorie_id' => $categories ? $categories[array_rand($categories)] : null,
                'type_id' => null,
                'statut' => (rand(0, 1) ? 'active' : 'desactive'),
                'user_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
