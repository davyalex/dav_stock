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
                'id' => 9574819791,
                'libelle' => 'marchandises',
                'slug' => 'marchandises',
                'description' => NULL,
                'categorie_depense_id' => 2525876191,
                'user_id' => 15591038721,
                'deleted_at' => NULL,
                'created_at' => '2024-10-06 22:47:47',
                'updated_at' => '2024-10-06 22:47:47',
            ),
        ));
        
        
    }
}