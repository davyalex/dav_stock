<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Categorie;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorieTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Boissons',
                'slug' => 'boissons',
                'url' => 'bar',
                'type' => 'boissons',
                'status' => 'active',
                'position' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ingredients',
                'slug' => 'ingredients',
                'url' => 'restaurant',
                'type' => 'ingredients',
                'status' => 'active',
                'position' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [
                'name' => 'Plats',
                'slug' => 'plats',
                'url' => 'restaurant',
                'type' => 'plats',
                'status' => 'active',
                'position' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

        ];

        foreach ($data as  $value) {
            Categorie::firstOrCreate($value);
        }
    }
}
