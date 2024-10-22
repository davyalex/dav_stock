<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FournisseursTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('fournisseurs')->delete();
        
        \DB::table('fournisseurs')->insert(array (
            0 => 
            array (
                'id' => 7833908024,
                'nom' => 'Bon prix',
                'adresse' => 'abidjan ; cocody',
                'telephone' => '0779613593',
                'email' => 'alexkouamelan96@gmail.com',
                'deleted_at' => NULL,
                'created_at' => '2024-08-02 09:35:03',
                'updated_at' => '2024-08-02 09:35:03',
            ),
            1 => 
            array (
                'id' => 16829372931,
                'nom' => 'Vrack marché',
                'adresse' => NULL,
                'telephone' => NULL,
                'email' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-10-04 06:51:29',
                'updated_at' => '2024-10-04 06:51:29',
            ),
            2 => 
            array (
                'id' => 19696787511,
                'nom' => 'Dépôt Chez Mike',
                'adresse' => NULL,
                'telephone' => '01000000001',
                'email' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-10-07 05:55:33',
                'updated_at' => '2024-10-07 05:55:33',
            ),
            3 => 
            array (
                'id' => 20449646621,
                'nom' => 'livreuse Zié Tra-Lou',
                'adresse' => NULL,
                'telephone' => NULL,
                'email' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-10-07 05:57:17',
                'updated_at' => '2024-10-07 05:57:17',
            ),
            4 => 
            array (
                'id' => 21011472291,
                'nom' => 'Hamed Marcory Marché',
                'adresse' => NULL,
                'telephone' => '0100000000',
                'email' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-10-04 06:49:49',
                'updated_at' => '2024-10-04 06:49:49',
            ),
            5 => 
            array (
                'id' => 21379971731,
                'nom' => 'King cash',
                'adresse' => 'abidjan ; cocody',
                'telephone' => '0779613593',
                'email' => 'alexkouamelan96@gmail.com',
                'deleted_at' => NULL,
                'created_at' => '2024-08-02 09:34:51',
                'updated_at' => '2024-08-02 09:34:51',
            ),
        ));
        
        
    }
}