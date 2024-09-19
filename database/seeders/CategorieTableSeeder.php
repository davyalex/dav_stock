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
                'name' => 'Bar',
                'slug' => 'bar',
                'url' => 'bar',
                'type' => 'bar',
                'famille' => 'bar',
                'status' => 'active',
                'position' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Restaurant',
                'slug' => 'restaurant',
                'url' => 'restaurant',
                'type' => 'restaurant',
                'famille' => 'restaurant',
                'status' => 'active',
                'position' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [
                'name' => 'Menu',
                'slug' => 'menu',
                'url' => 'menu',
                'type' => 'menu',
                'famille' => 'menu',
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
