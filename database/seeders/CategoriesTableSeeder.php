<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Seed pour catégories pâtisserie avec 3 niveaux
     *
     * @return void
     */
    public function run(): void
    {
        // Désactiver les clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Vider d'abord les tables enfants
        DB::table('produits')->truncate();
        DB::table('categories')->truncate();

        // Réactiver les clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = Carbon::now();

        // Niveau 1 : Pâtisserie
        $patisserieId = DB::table('categories')->insertGetId([
            'name'       => 'Pâtisserie',
            'slug'       => 'patisserie',
            'status'     => 'active',
            'url'        => 'patisserie',
            'position'   => 1,
            'parent_id'  => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Niveau 2
        $viennoiseriesId = DB::table('categories')->insertGetId([
            'name'       => 'Viennoiseries',
            'slug'       => 'viennoiseries',
            'status'     => 'active',
            'url'        => 'viennoiseries',
            'position'   => 1,
            'parent_id'  => $patisserieId,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $gateauxId = DB::table('categories')->insertGetId([
            'name'       => 'Gâteaux',
            'slug'       => 'gateaux',
            'status'     => 'active',
            'url'        => 'gateaux',
            'position'   => 2,
            'parent_id'  => $patisserieId,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Niveau 3 sous Viennoiseries
        DB::table('categories')->insert([
            [
                'name'       => 'Croissants',
                'slug'       => 'croissants',
                'status'     => 'active',
                'url'        => 'croissants',
                'position'   => 1,
                'parent_id'  => $viennoiseriesId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Pain au chocolat',
                'slug'       => 'pain-au-chocolat',
                'status'     => 'active',
                'url'        => 'pain-au-chocolat',
                'position'   => 2,
                'parent_id'  => $viennoiseriesId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // Niveau 3 sous Gâteaux
        DB::table('categories')->insert([
            [
                'name'       => 'Opéra',
                'slug'       => 'opera',
                'status'     => 'active',
                'url'        => 'opera',
                'position'   => 1,
                'parent_id'  => $gateauxId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Mille-feuille',
                'slug'       => 'mille-feuille',
                'status'     => 'active',
                'url'        => 'mille-feuille',
                'position'   => 2,
                'parent_id'  => $gateauxId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}