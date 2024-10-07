<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MagasinsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('magasins')->delete();
        
        \DB::table('magasins')->insert(array (
            0 => 
            array (
                'id' => 3436479651,
                'libelle' => 'magasinA',
                'created_at' => '2024-10-06 21:07:27',
                'updated_at' => '2024-10-06 21:07:27',
            ),
        ));
        
        
    }
}