<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\TypeProduit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TypeProduitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $data = [
            [
                'libelle' => 'Bar',
                'url' => 'bar',
                'status' => 'active',
                'position' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'libelle' => 'Restaurant',
                'url' => 'restaurant',
                'status' => 'active',
                'position' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

        ];

        foreach ($data as  $value) {
            TypeProduit::firstOrCreate($value);
        }
    }
}
