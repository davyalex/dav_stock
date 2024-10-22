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
                'id' => 2938914474,
                'name' => 'stock',
                'slug' => 'gestion-de-stock',
                'deleted_at' => NULL,
                'created_at' => '2024-10-17 13:21:13',
                'updated_at' => '2024-10-22 16:07:14',
            ),
            1 => 
            array (
                'id' => 4696292394,
                'name' => 'site',
                'slug' => 'site',
                'deleted_at' => NULL,
                'created_at' => '2024-10-22 15:59:54',
                'updated_at' => '2024-10-22 16:07:03',
            ),
            2 => 
            array (
                'id' => 5798635241,
                'name' => 'tableau de bord',
                'slug' => 'tableau-de-bord',
                'deleted_at' => NULL,
                'created_at' => '2024-10-05 19:16:43',
                'updated_at' => '2024-10-05 19:36:11',
            ),
            3 => 
            array (
                'id' => 6527313002,
                'name' => 'configuration',
                'slug' => 'dash',
                'deleted_at' => NULL,
                'created_at' => '2024-10-05 19:26:13',
                'updated_at' => '2024-10-05 20:08:47',
            ),
            4 => 
            array (
                'id' => 8757645503,
                'name' => 'vente',
                'slug' => 'vente',
                'deleted_at' => NULL,
                'created_at' => '2024-10-05 21:58:45',
                'updated_at' => '2024-10-05 21:58:45',
            ),
            5 => 
            array (
                'id' => 15360697021,
                'name' => 'rapport',
                'slug' => 'rapport',
                'deleted_at' => NULL,
                'created_at' => '2024-10-21 10:15:40',
                'updated_at' => '2024-10-21 10:15:40',
            ),
            6 => 
            array (
                'id' => 18498597731,
                'name' => 'depense',
                'slug' => 'depense',
                'deleted_at' => NULL,
                'created_at' => '2024-10-22 15:46:15',
                'updated_at' => '2024-10-22 15:46:15',
            ),
        ));
        
        
    }
}