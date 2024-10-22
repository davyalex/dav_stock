<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FormatsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('formats')->delete();
        
        \DB::table('formats')->insert(array (
            0 => 
            array (
                'id' => 2736787144,
                'libelle' => 'Paquet',
                'abreviation' => 'Pqt',
                'deleted_at' => NULL,
                'created_at' => '2024-10-07 04:41:55',
                'updated_at' => '2024-10-07 04:41:55',
            ),
            1 => 
            array (
                'id' => 3133355452,
                'libelle' => 'Sachet',
                'abreviation' => 'SCHT',
                'deleted_at' => NULL,
                'created_at' => '2024-08-02 09:34:17',
                'updated_at' => '2024-08-02 09:34:17',
            ),
            2 => 
            array (
                'id' => 4750750684,
                'libelle' => 'Bidon',
                'abreviation' => 'Bdn',
                'deleted_at' => NULL,
                'created_at' => '2024-10-04 06:48:10',
                'updated_at' => '2024-10-04 06:48:10',
            ),
            3 => 
            array (
                'id' => 5824347821,
                'libelle' => 'carton',
                'abreviation' => 'CRT',
                'deleted_at' => NULL,
                'created_at' => '2024-08-02 09:33:54',
                'updated_at' => '2024-08-02 09:33:54',
            ),
            4 => 
            array (
                'id' => 16854635291,
                'libelle' => 'Bouteille',
                'abreviation' => 'Btle',
                'deleted_at' => NULL,
                'created_at' => '2024-10-07 04:40:56',
                'updated_at' => '2024-10-07 04:40:56',
            ),
            5 => 
            array (
                'id' => 19177121531,
                'libelle' => 'Casier',
                'abreviation' => 'Kzié',
                'deleted_at' => NULL,
                'created_at' => '2024-10-07 04:40:27',
                'updated_at' => '2024-10-07 04:40:27',
            ),
            6 => 
            array (
                'id' => 19852526431,
                'libelle' => 'Sac',
                'abreviation' => 'Sac',
                'deleted_at' => NULL,
                'created_at' => '2024-10-04 06:47:53',
                'updated_at' => '2024-10-04 06:47:53',
            ),
        ));
        
        
    }
}