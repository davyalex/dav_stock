<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LibelleDepensesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('libelle_depenses')->delete();
        
        \DB::table('libelle_depenses')->insert(array (
            0 => 
            array (
                'id' => 10267115331,
                'libelle' => 'marchandises',
                'slug' => 'marchandises',
                'description' => NULL,
                'categorie_depense_id' => 2525876191,
                'user_id' => 14515841191,
                'deleted_at' => NULL,
                'created_at' => '2024-09-27 14:37:04',
                'updated_at' => '2024-09-27 14:37:04',
            ),
        ));
        
        
    }
}