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
                'created_at' => '2024-08-02 15:03:42',
                'updated_at' => '2024-08-02 15:03:42',
            ),
            1 => 
            array (
                'id' => 5921641171,
                'libelle' => 'kilogramme',
                'abreviation' => 'KG',
                'deleted_at' => NULL,
                'created_at' => '2024-08-02 15:03:32',
                'updated_at' => '2024-08-02 15:03:32',
            ),
        ));
        
        
    }
}