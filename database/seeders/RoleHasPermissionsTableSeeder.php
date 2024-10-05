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
                'permission_id' => 45,
                'role_id' => 1,
            ),
            1 => 
            array (
                'permission_id' => 47,
                'role_id' => 1,
            ),
            2 => 
            array (
                'permission_id' => 48,
                'role_id' => 1,
            ),
            3 => 
            array (
                'permission_id' => 53,
                'role_id' => 1,
            ),
            4 => 
            array (
                'permission_id' => 54,
                'role_id' => 1,
            ),
            5 => 
            array (
                'permission_id' => 55,
                'role_id' => 1,
            ),
            6 => 
            array (
                'permission_id' => 56,
                'role_id' => 1,
            ),
            7 => 
            array (
                'permission_id' => 45,
                'role_id' => 2,
            ),
            8 => 
            array (
                'permission_id' => 46,
                'role_id' => 2,
            ),
            9 => 
            array (
                'permission_id' => 47,
                'role_id' => 2,
            ),
            10 => 
            array (
                'permission_id' => 48,
                'role_id' => 2,
            ),
            11 => 
            array (
                'permission_id' => 49,
                'role_id' => 2,
            ),
            12 => 
            array (
                'permission_id' => 50,
                'role_id' => 2,
            ),
            13 => 
            array (
                'permission_id' => 51,
                'role_id' => 2,
            ),
            14 => 
            array (
                'permission_id' => 52,
                'role_id' => 2,
            ),
            15 => 
            array (
                'permission_id' => 49,
                'role_id' => 3,
            ),
            16 => 
            array (
                'permission_id' => 45,
                'role_id' => 4,
            ),
            17 => 
            array (
                'permission_id' => 46,
                'role_id' => 4,
            ),
            18 => 
            array (
                'permission_id' => 47,
                'role_id' => 4,
            ),
            19 => 
            array (
                'permission_id' => 48,
                'role_id' => 4,
            ),
            20 => 
            array (
                'permission_id' => 49,
                'role_id' => 4,
            ),
            21 => 
            array (
                'permission_id' => 50,
                'role_id' => 4,
            ),
            22 => 
            array (
                'permission_id' => 51,
                'role_id' => 4,
            ),
            23 => 
            array (
                'permission_id' => 52,
                'role_id' => 4,
            ),
        ));
        
        
    }
}