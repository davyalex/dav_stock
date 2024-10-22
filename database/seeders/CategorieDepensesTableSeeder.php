<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorieDepensesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categorie_depenses')->delete();
        
        \DB::table('categorie_depenses')->insert(array (
            0 => 
            array (
                'id' => 1218101912,
                'libelle' => 'Charges externes',
                'slug' => 'charges-externes',
                'statut' => 'active',
                'position' => '2',
                'deleted_at' => NULL,
                'created_at' => '2024-09-23 03:21:45',
                'updated_at' => '2024-09-23 03:21:45',
            ),
            1 => 
            array (
                'id' => 2525876191,
                'libelle' => 'Achats',
                'slug' => 'achats',
                'statut' => 'active',
                'position' => '1',
                'deleted_at' => NULL,
                'created_at' => '2024-09-23 03:21:21',
                'updated_at' => '2024-09-23 03:23:32',
            ),
            2 => 
            array (
                'id' => 3781290123,
                'libelle' => 'charges financières',
                'slug' => 'charges-financieres',
                'statut' => 'active',
                'position' => '5',
                'deleted_at' => NULL,
                'created_at' => '2024-09-23 03:23:19',
                'updated_at' => '2024-09-23 03:23:19',
            ),
            3 => 
            array (
                'id' => 6423828292,
                'libelle' => 'impôts et taxes',
                'slug' => 'impots-et-taxes',
                'statut' => 'active',
                'position' => '3',
                'deleted_at' => NULL,
                'created_at' => '2024-09-23 03:22:17',
                'updated_at' => '2024-09-23 03:22:17',
            ),
            4 => 
            array (
                'id' => 20381075921,
                'libelle' => 'Charges de personnel',
                'slug' => 'charges-de-personnel',
                'statut' => 'active',
                'position' => '4',
                'deleted_at' => NULL,
                'created_at' => '2024-09-23 03:22:45',
                'updated_at' => '2024-09-23 03:22:45',
            ),
        ));
        
        
    }
}