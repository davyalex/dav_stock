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
            12 => 
            array (
                'id' => 57,
                'name' => 'creer-stock',
                'guard_name' => 'web',
                'created_at' => '2024-10-17 13:21:13',
                'updated_at' => '2024-10-22 16:07:14',
                'module_id' => 2938914474,
            ),
            13 => 
            array (
                'id' => 58,
                'name' => 'voir-stock',
                'guard_name' => 'web',
                'created_at' => '2024-10-17 13:21:13',
                'updated_at' => '2024-10-22 16:07:14',
                'module_id' => 2938914474,
            ),
            14 => 
            array (
                'id' => 59,
                'name' => 'modifier-stock',
                'guard_name' => 'web',
                'created_at' => '2024-10-17 13:21:13',
                'updated_at' => '2024-10-22 16:07:14',
                'module_id' => 2938914474,
            ),
            15 => 
            array (
                'id' => 60,
                'name' => 'supprimer-stock',
                'guard_name' => 'web',
                'created_at' => '2024-10-17 13:21:13',
                'updated_at' => '2024-10-22 16:07:14',
                'module_id' => 2938914474,
            ),
            16 => 
            array (
                'id' => 61,
                'name' => 'creer-rapport',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 10:15:40',
                'updated_at' => '2024-10-21 10:15:40',
                'module_id' => 15360697021,
            ),
            17 => 
            array (
                'id' => 62,
                'name' => 'voir-rapport',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 10:15:40',
                'updated_at' => '2024-10-21 10:15:40',
                'module_id' => 15360697021,
            ),
            18 => 
            array (
                'id' => 63,
                'name' => 'modifier-rapport',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 10:15:40',
                'updated_at' => '2024-10-21 10:15:40',
                'module_id' => 15360697021,
            ),
            19 => 
            array (
                'id' => 64,
                'name' => 'supprimer-rapport',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 10:15:40',
                'updated_at' => '2024-10-21 10:15:40',
                'module_id' => 15360697021,
            ),
            20 => 
            array (
                'id' => 65,
                'name' => 'creer-depense',
                'guard_name' => 'web',
                'created_at' => '2024-10-22 15:46:15',
                'updated_at' => '2024-10-22 15:46:15',
                'module_id' => 18498597731,
            ),
            21 => 
            array (
                'id' => 66,
                'name' => 'voir-depense',
                'guard_name' => 'web',
                'created_at' => '2024-10-22 15:46:15',
                'updated_at' => '2024-10-22 15:46:15',
                'module_id' => 18498597731,
            ),
            22 => 
            array (
                'id' => 67,
                'name' => 'modifier-depense',
                'guard_name' => 'web',
                'created_at' => '2024-10-22 15:46:15',
                'updated_at' => '2024-10-22 15:46:15',
                'module_id' => 18498597731,
            ),
            23 => 
            array (
                'id' => 68,
                'name' => 'supprimer-depense',
                'guard_name' => 'web',
                'created_at' => '2024-10-22 15:46:15',
                'updated_at' => '2024-10-22 15:46:15',
                'module_id' => 18498597731,
            ),
            24 => 
            array (
                'id' => 69,
                'name' => 'creer-site',
                'guard_name' => 'web',
                'created_at' => '2024-10-22 15:59:54',
                'updated_at' => '2024-10-22 16:07:03',
                'module_id' => 4696292394,
            ),
            25 => 
            array (
                'id' => 70,
                'name' => 'voir-site',
                'guard_name' => 'web',
                'created_at' => '2024-10-22 15:59:54',
                'updated_at' => '2024-10-22 16:07:03',
                'module_id' => 4696292394,
            ),
            26 => 
            array (
                'id' => 71,
                'name' => 'modifier-site',
                'guard_name' => 'web',
                'created_at' => '2024-10-22 15:59:54',
                'updated_at' => '2024-10-22 16:07:03',
                'module_id' => 4696292394,
            ),
            27 => 
            array (
                'id' => 72,
                'name' => 'supprimer-site',
                'guard_name' => 'web',
                'created_at' => '2024-10-22 15:59:54',
                'updated_at' => '2024-10-22 16:07:03',
                'module_id' => 4696292394,
            ),
        ));
        
        
    }
}