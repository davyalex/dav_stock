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
                'id' => 4225322402,
                'libelle' => 'test',
                'abreviation' => 'FR',
                'deleted_at' => '2024-10-04 12:24:49',
                'created_at' => '2024-10-04 12:23:15',
                'updated_at' => '2024-10-04 12:24:49',
            ),
            2 => 
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