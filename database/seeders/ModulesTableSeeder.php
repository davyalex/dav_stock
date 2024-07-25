<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModulesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('modules')->delete();
        
        \DB::table('modules')->insert(array (
            0 => 
            array (
                'id' => 1276531794,
                'name' => 'temoignage',
                'slug' => 'temoignage',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 17:43:33',
                'updated_at' => '2024-05-27 17:43:33',
            ),
            1 => 
            array (
                'id' => 2944626844,
                'name' => 'role',
                'slug' => 'role',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 17:49:16',
                'updated_at' => '2024-05-27 17:49:16',
            ),
            2 => 
            array (
                'id' => 3703263064,
                'name' => 'site basique',
                'slug' => 'site-basique',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 17:36:13',
                'updated_at' => '2024-05-27 17:36:13',
            ),
            3 => 
            array (
                'id' => 4636790854,
                'name' => 'administrateur',
                'slug' => 'administrateur',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 17:47:18',
                'updated_at' => '2024-05-27 17:47:18',
            ),
            4 => 
            array (
                'id' => 5006502324,
                'name' => 'menu',
                'slug' => 'menu',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 17:36:24',
                'updated_at' => '2024-05-27 17:36:24',
            ),
            5 => 
            array (
                'id' => 5782182984,
                'name' => 'mediatheque',
                'slug' => 'mediatheque',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 17:45:03',
                'updated_at' => '2024-05-27 17:45:03',
            ),
            6 => 
            array (
                'id' => 9204107514,
                'name' => 'service',
                'slug' => 'service',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 17:36:35',
                'updated_at' => '2024-05-27 17:36:35',
            ),
            7 => 
            array (
                'id' => 10007940981,
                'name' => 'blog-categorie',
                'slug' => 'blog-categorie',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 17:35:21',
                'updated_at' => '2024-05-27 17:35:21',
            ),
            8 => 
            array (
                'id' => 10198695591,
                'name' => 'blog-contenu',
                'slug' => 'blog-contenu',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 17:35:35',
                'updated_at' => '2024-05-27 17:35:35',
            ),
            9 => 
            array (
                'id' => 10257365491,
                'name' => 'mediatheque-contenu',
                'slug' => 'mediatheque-contenu',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 17:46:44',
                'updated_at' => '2024-05-27 17:46:44',
            ),
            10 => 
            array (
                'id' => 10851855721,
                'name' => 'module',
                'slug' => 'module',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 17:48:57',
                'updated_at' => '2024-05-27 17:48:57',
            ),
            11 => 
            array (
                'id' => 12410962941,
                'name' => 'permission',
                'slug' => 'permission',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 17:49:26',
                'updated_at' => '2024-05-27 17:49:26',
            ),
            12 => 
            array (
                'id' => 15824891881,
                'name' => 'configuration',
                'slug' => 'configuration',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 17:47:39',
                'updated_at' => '2024-05-27 17:47:39',
            ),
            13 => 
            array (
                'id' => 16511573291,
                'name' => 'slide',
                'slug' => 'slide',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 17:43:15',
                'updated_at' => '2024-05-27 17:43:15',
            ),
            14 => 
            array (
                'id' => 18483937381,
                'name' => 'information',
                'slug' => 'information',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 17:48:46',
                'updated_at' => '2024-05-27 17:48:46',
            ),
            15 => 
            array (
                'id' => 18895567371,
                'name' => 'mediatheque-categorie',
                'slug' => 'mediatheque-categorie',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 17:46:12',
                'updated_at' => '2024-05-27 17:46:12',
            ),
            16 => 
            array (
                'id' => 18900321491,
                'name' => 'blog',
                'slug' => 'blog',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 15:01:53',
                'updated_at' => '2024-05-27 15:01:53',
            ),
            17 => 
            array (
                'id' => 19776736511,
                'name' => 'equipe',
                'slug' => 'equipe',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 17:37:06',
                'updated_at' => '2024-05-27 17:37:06',
            ),
            18 => 
            array (
                'id' => 19849174941,
                'name' => 'reference',
                'slug' => 'reference',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 17:36:48',
                'updated_at' => '2024-05-27 17:36:48',
            ),
            19 => 
            array (
                'id' => 19974454031,
                'name' => 'page',
                'slug' => 'page',
                'deleted_at' => NULL,
                'created_at' => '2024-05-27 13:14:47',
                'updated_at' => '2024-05-27 13:14:47',
            ),
        ));
        
        
    }
}