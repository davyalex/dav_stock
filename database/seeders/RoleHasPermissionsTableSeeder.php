<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('role_has_permissions')->delete();
        
        \DB::table('role_has_permissions')->insert(array (
            0 => 
            array (
                'permission_id' => 37,
                'role_id' => 4,
            ),
            1 => 
            array (
                'permission_id' => 38,
                'role_id' => 4,
            ),
            2 => 
            array (
                'permission_id' => 39,
                'role_id' => 4,
            ),
            3 => 
            array (
                'permission_id' => 40,
                'role_id' => 4,
            ),
            4 => 
            array (
                'permission_id' => 42,
                'role_id' => 4,
            ),
        ));
        
        
    }
}