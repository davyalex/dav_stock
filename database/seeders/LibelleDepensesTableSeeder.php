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
                'id' => 1585402845,
                'libelle' => 'Facture SODECI',
                'slug' => 'facture-sodeci',
                'description' => NULL,
                'categorie_depense_id' => 1218101912,
                'user_id' => 3755024613,
                'deleted_at' => NULL,
                'created_at' => '2024-10-14 04:15:25',
                'updated_at' => '2024-10-14 04:15:25',
            ),
            1 => 
            array (
                'id' => 2508610715,
                'libelle' => 'Impôt - DGI',
                'slug' => 'impot-dgi',
                'description' => NULL,
                'categorie_depense_id' => 6423828292,
                'user_id' => 3755024613,
                'deleted_at' => NULL,
                'created_at' => '2024-10-14 04:21:54',
                'updated_at' => '2024-10-14 04:21:54',
            ),
            2 => 
            array (
                'id' => 4612593255,
                'libelle' => 'maintenace',
                'slug' => 'maintenace',
                'description' => NULL,
                'categorie_depense_id' => 3781290123,
                'user_id' => 3755024613,
                'deleted_at' => NULL,
                'created_at' => '2024-10-14 04:20:24',
                'updated_at' => '2024-10-14 04:20:24',
            ),
            3 => 
            array (
                'id' => 4828669592,
                'libelle' => 'Avance sur salaire',
                'slug' => 'avance-sur-salaire',
                'description' => NULL,
                'categorie_depense_id' => 20381075921,
                'user_id' => 3755024613,
                'deleted_at' => NULL,
                'created_at' => '2024-10-14 04:14:22',
                'updated_at' => '2024-10-14 04:14:22',
            ),
            4 => 
            array (
                'id' => 5705453612,
                'libelle' => 'Salaire',
                'slug' => 'salaire',
                'description' => NULL,
                'categorie_depense_id' => 20381075921,
                'user_id' => 3755024613,
                'deleted_at' => NULL,
                'created_at' => '2024-10-14 04:13:50',
                'updated_at' => '2024-10-14 04:13:50',
            ),
            5 => 
            array (
                'id' => 9468756491,
                'libelle' => 'marchandises',
                'slug' => 'marchandises',
                'description' => NULL,
                'categorie_depense_id' => 2525876191,
                'user_id' => 3755024613,
                'deleted_at' => NULL,
                'created_at' => '2024-10-07 05:31:18',
                'updated_at' => '2024-10-07 05:31:18',
            ),
            6 => 
            array (
                'id' => 13814236511,
                'libelle' => 'Dépenses annexes Madame',
                'slug' => 'depenses-annexes-madame',
                'description' => NULL,
                'categorie_depense_id' => 3781290123,
                'user_id' => 3755024613,
                'deleted_at' => NULL,
                'created_at' => '2024-10-14 04:23:25',
                'updated_at' => '2024-10-14 04:23:25',
            ),
            7 => 
            array (
                'id' => 15256552171,
                'libelle' => 'Transport',
                'slug' => 'transport',
                'description' => NULL,
                'categorie_depense_id' => 3781290123,
                'user_id' => 3755024613,
                'deleted_at' => NULL,
                'created_at' => '2024-10-14 04:20:42',
                'updated_at' => '2024-10-14 04:20:42',
            ),
            8 => 
            array (
                'id' => 15349102181,
                'libelle' => 'Réparation',
                'slug' => 'reparation',
                'description' => NULL,
                'categorie_depense_id' => 3781290123,
                'user_id' => 3755024613,
                'deleted_at' => NULL,
                'created_at' => '2024-10-14 04:16:37',
                'updated_at' => '2024-10-14 04:16:37',
            ),
            9 => 
            array (
                'id' => 15581365441,
                'libelle' => 'Facture CIE',
                'slug' => 'facture-cie',
                'description' => NULL,
                'categorie_depense_id' => 1218101912,
                'user_id' => 3755024613,
                'deleted_at' => NULL,
                'created_at' => '2024-10-14 04:15:02',
                'updated_at' => '2024-10-14 04:15:02',
            ),
            10 => 
            array (
                'id' => 17111595651,
                'libelle' => 'Mairie',
                'slug' => 'mairie',
                'description' => NULL,
                'categorie_depense_id' => 6423828292,
                'user_id' => 3755024613,
                'deleted_at' => NULL,
                'created_at' => '2024-10-14 04:22:09',
                'updated_at' => '2024-10-14 04:22:09',
            ),
        ));
        
        
    }
}