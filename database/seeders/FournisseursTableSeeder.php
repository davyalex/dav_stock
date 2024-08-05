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
                'created_at' => '2024-08-02 15:05:03',
                'updated_at' => '2024-08-02 15:05:03',
            ),
            1 => 
            array (
                'id' => 21379971731,
                'nom' => 'King cash',
                'adresse' => 'abidjan ; cocody',
                'telephone' => '0779613593',
                'email' => 'alexkouamelan96@gmail.com',
                'deleted_at' => NULL,
                'created_at' => '2024-08-02 15:04:51',
                'updated_at' => '2024-08-02 15:04:51',
            ),
        ));
        
        
    }
}