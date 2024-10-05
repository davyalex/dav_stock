<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModulesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('modules')->delete();
        
        \DB::table('modules')->insert(array (
            0 => 
            array (
                'id' => 5798635241,
                'name' => 'tableau de bord',
                'slug' => 'tableau-de-bord',
                'deleted_at' => NULL,
                'created_at' => '2024-10-05 19:16:43',
                'updated_at' => '2024-10-05 19:36:11',
            ),
            1 => 
            array (
                'id' => 6527313002,
                'name' => 'configuration',
                'slug' => 'dash',
                'deleted_at' => NULL,
                'created_at' => '2024-10-05 19:26:13',
                'updated_at' => '2024-10-05 20:08:47',
            ),
            2 => 
            array (
                'id' => 8757645503,
                'name' => 'vente',
                'slug' => 'vente',
                'deleted_at' => NULL,
                'created_at' => '2024-10-05 21:58:45',
                'updated_at' => '2024-10-05 21:58:45',
            ),
        ));
        
        
    }
}