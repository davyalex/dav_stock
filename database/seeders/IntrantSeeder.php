<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Intrant;
use Illuminate\Support\Str;

class IntrantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $intrants = [
            'Farine', 'Sucre', 'Beurre', 'Œufs', 'Levure', 'Lait', 'Chocolat', 'Crème', 'Fruits confits', 'Amandes',
            'Noisettes', 'Vanille', 'Sel', 'Pépites de chocolat', 'Poudre d’amande', 'Pistaches', 'Miel', 'Cacao', 'Eau', 'Colorant alimentaire'
        ];

        foreach ($intrants as $nom) {
            Intrant::create([
                'code' => 'INT-' . strtoupper(Str::random(6)),
                'nom' => $nom,
                'slug' => Str::slug($nom),
                'description' => "Intrant utilisé en pâtisserie : $nom",
                'prix' => rand(500, 5000), // prix entier, pas de virgule
                'stock' => rand(10, 200),
                'stock_alerte' => rand(5, 30),
                'statut' => 'active',
                'user_id' => null,
            ]);
        }
    }
}
