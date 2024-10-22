<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UnitesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('unites')->delete();
        
        \DB::table('unites')->insert(array (
            0 => 
            array (
                'id' => 2602803692,
                'libelle' => 'litre',
                'abreviation' => 'L',
                'deleted_at' => NULL,
                'created_at' => '2024-08-02 09:33:42',
                'updated_at' => '2024-08-02 09:33:42',
            ),
            1 => 
            array (
                'id' => 5921641171,
                'libelle' => 'kilogramme',
                'abreviation' => 'KG',
                'deleted_at' => NULL,
                'created_at' => '2024-08-02 09:33:32',
                'updated_at' => '2024-08-02 09:33:32',
            ),
            2 => 
            array (
                'id' => 7313359492,
                'libelle' => 'Pack',
                'abreviation' => 'Pck',
                'deleted_at' => NULL,
                'created_at' => '2024-10-04 06:43:06',
                'updated_at' => '2024-10-04 06:43:06',
            ),
            3 => 
            array (
                'id' => 12723287061,
                'libelle' => 'Paquet',
                'abreviation' => 'Pqt',
                'deleted_at' => NULL,
                'created_at' => '2024-10-04 06:47:28',
                'updated_at' => '2024-10-04 06:47:28',
            ),
            4 => 
            array (
                'id' => 13043697161,
                'libelle' => 'Tournée',
                'abreviation' => 'Tné',
                'deleted_at' => NULL,
                'created_at' => '2024-10-07 05:58:08',
                'updated_at' => '2024-10-07 05:58:08',
            ),
            5 => 
            array (
                'id' => 13729563901,
                'libelle' => 'Bouteille',
                'abreviation' => 'Btle',
                'deleted_at' => NULL,
                'created_at' => '2024-10-07 05:58:33',
                'updated_at' => '2024-10-07 05:58:33',
            ),
        ));
        
        
    }
}