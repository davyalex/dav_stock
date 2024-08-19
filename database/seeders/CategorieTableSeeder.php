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
                'name' => 'bar',
                'slug' => 'bar',
                'url' => 'bar',
                'type' => 'categorie-stock',
                'status' => 'active',
                'position' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'restaurant',
                'slug' => 'restaurant',
                'url' => 'restaurant',
                'type' => 'categorie-stock',
                'status' => 'active',
                'position' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

        ];

        foreach ($data as  $value) {
            Categorie::firstOrCreate($value);
        }
    }
}
