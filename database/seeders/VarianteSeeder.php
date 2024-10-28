<?php

namespace Database\Seeders;

use App\Models\Variante;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VarianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  public function run()
    {
        // Ajout de variantes avec des prix par défaut si souhaité
        Variante::create(['libelle' => 'Tournée', 'slug' => 'tournée']);
        Variante::create(['libelle' => 'Ballon', 'slug' => 'ballon']);
        Variante::create(['libelle' => 'Verre', 'slug' => 'verre']);
        Variante::create(['libelle' => 'Bouteille', 'slug' => 'bouteille']);
    }
    }
}
