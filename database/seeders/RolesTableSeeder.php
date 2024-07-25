<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 4,
                'name' => 'developpeur',
                'guard_name' => 'web',
                'created_at' => '2024-05-27 11:10:33',
                'updated_at' => '2024-05-27 11:10:33',
            ),
        ));
        
        
    }
}