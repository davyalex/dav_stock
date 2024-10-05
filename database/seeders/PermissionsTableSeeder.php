<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 45,
                'name' => 'creer-tableau de bord',
                'guard_name' => 'web',
                'created_at' => '2024-10-05 19:16:43',
                'updated_at' => '2024-10-05 19:16:43',
                'module_id' => 5798635241,
            ),
            1 => 
            array (
                'id' => 46,
                'name' => 'voir-tableau de bord',
                'guard_name' => 'web',
                'created_at' => '2024-10-05 19:16:43',
                'updated_at' => '2024-10-05 19:16:43',
                'module_id' => 5798635241,
            ),
            2 => 
            array (
                'id' => 47,
                'name' => 'modifier-tableau de bord',
                'guard_name' => 'web',
                'created_at' => '2024-10-05 19:16:43',
                'updated_at' => '2024-10-05 19:16:43',
                'module_id' => 5798635241,
            ),
            3 => 
            array (
                'id' => 48,
                'name' => 'supprimer-tableau de bord',
                'guard_name' => 'web',
                'created_at' => '2024-10-05 19:16:43',
                'updated_at' => '2024-10-05 19:16:43',
                'module_id' => 5798635241,
            ),
            4 => 
            array (
                'id' => 49,
                'name' => 'creer-configuration',
                'guard_name' => 'web',
                'created_at' => '2024-10-05 19:26:13',
                'updated_at' => '2024-10-05 20:08:47',
                'module_id' => 6527313002,
            ),
            5 => 
            array (
                'id' => 50,
                'name' => 'voir-configuration',
                'guard_name' => 'web',
                'created_at' => '2024-10-05 19:26:13',
                'updated_at' => '2024-10-05 20:08:47',
                'module_id' => 6527313002,
            ),
            6 => 
            array (
                'id' => 51,
                'name' => 'modifier-configuration',
                'guard_name' => 'web',
                'created_at' => '2024-10-05 19:26:13',
                'updated_at' => '2024-10-05 20:08:47',
                'module_id' => 6527313002,
            ),
            7 => 
            array (
                'id' => 52,
                'name' => 'supprimer-configuration',
                'guard_name' => 'web',
                'created_at' => '2024-10-05 19:26:13',
                'updated_at' => '2024-10-05 20:08:47',
                'module_id' => 6527313002,
            ),
            8 => 
            array (
                'id' => 53,
                'name' => 'creer-vente',
                'guard_name' => 'web',
                'created_at' => '2024-10-05 21:58:45',
                'updated_at' => '2024-10-05 21:58:45',
                'module_id' => 8757645503,
            ),
            9 => 
            array (
                'id' => 54,
                'name' => 'voir-vente',
                'guard_name' => 'web',
                'created_at' => '2024-10-05 21:58:45',
                'updated_at' => '2024-10-05 21:58:45',
                'module_id' => 8757645503,
            ),
            10 => 
            array (
                'id' => 55,
                'name' => 'modifier-vente',
                'guard_name' => 'web',
                'created_at' => '2024-10-05 21:58:45',
                'updated_at' => '2024-10-05 21:58:45',
                'module_id' => 8757645503,
            ),
            11 => 
            array (
                'id' => 56,
                'name' => 'supprimer-vente',
                'guard_name' => 'web',
                'created_at' => '2024-10-05 21:58:45',
                'updated_at' => '2024-10-05 21:58:45',
                'module_id' => 8757645503,
            ),
        ));
        
        
    }
}