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
                'id' => 3133355452,
                'libelle' => 'Sachet',
                'abreviation' => 'SCHT',
                'deleted_at' => NULL,
                'created_at' => '2024-08-02 15:04:17',
                'updated_at' => '2024-08-02 15:04:17',
            ),
            1 => 
            array (
                'id' => 5824347821,
                'libelle' => 'carton',
                'abreviation' => 'CRT',
                'deleted_at' => NULL,
                'created_at' => '2024-08-02 15:03:54',
                'updated_at' => '2024-08-02 15:03:54',
            ),
        ));
        
        
    }
}