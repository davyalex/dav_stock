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
                'id' => 1,
                'name' => 'developpeur',
                'guard_name' => 'web',
                'created_at' => '2024-10-05 16:56:20',
                'updated_at' => '2024-10-05 17:51:34',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'caisse',
                'guard_name' => 'web',
                'created_at' => '2024-10-05 21:12:29',
                'updated_at' => '2024-10-05 21:12:29',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'gestionnaire',
                'guard_name' => 'web',
                'created_at' => '2024-10-05 21:30:14',
                'updated_at' => '2024-10-05 21:30:14',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'manager',
                'guard_name' => 'web',
                'created_at' => '2024-10-05 21:34:03',
                'updated_at' => '2024-10-05 21:34:03',
            ),
        ));
        
        
    }
}