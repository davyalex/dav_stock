<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CaissesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('caisses')->delete();
        
        \DB::table('caisses')->insert(array (
            0 => 
            array (
                'id' => 8075888141,
                'code' => 'C-6P2B1',
                'libelle' => 'caisseA',
                'description' => NULL,
                'statut' => 'desactive',
                'created_at' => '2024-10-17 13:22:05',
                'updated_at' => '2024-10-22 15:45:20',
            ),
            1 => 
            array (
                'id' => 20686457201,
                'code' => 'C-KOV8F',
                'libelle' => 'caisseB',
                'description' => NULL,
                'statut' => 'desactive',
                'created_at' => '2024-10-17 13:22:13',
                'updated_at' => '2024-10-17 13:22:13',
            ),
        ));
        
        
    }
}