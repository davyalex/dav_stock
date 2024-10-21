<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 6976409612,
                'name' => 'Restaurant',
                'slug' => 'restaurant',
                'url' => 'restaurant',
                'status' => 'active',
                'position' => '2',
                'parent_id' => NULL,
                'type' => 'restaurant',
                'famille' => 'restaurant',
                'deleted_at' => NULL,
                'created_at' => '2024-09-23 09:17:25',
                'updated_at' => '2024-09-23 09:17:25',
            ),
            1 => 
            array (
                'id' => 14323465711,
                'name' => 'Bar',
                'slug' => 'bar',
                'url' => 'bar',
                'status' => 'active',
                'position' => '1',
                'parent_id' => NULL,
                'type' => 'bar',
                'famille' => 'bar',
                'deleted_at' => NULL,
                'created_at' => '2024-09-23 09:17:25',
                'updated_at' => '2024-09-23 09:17:25',
            ),
            2 => 
            array (
                'id' => 20671449961,
                'name' => 'Cuisine interne',
                'slug' => 'cuisine-interne',
                'url' => 'cuisine-interne',
                'status' => 'active',
                'position' => '3',
                'parent_id' => NULL,
                'type' => 'menu',
                'famille' => 'menu',
                'deleted_at' => NULL,
                'created_at' => '2024-09-23 09:17:25',
                'updated_at' => '2024-09-23 09:17:25',
            ),
        ));
        
        
    }
}