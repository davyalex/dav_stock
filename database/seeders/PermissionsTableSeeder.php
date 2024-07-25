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
                'id' => 37,
                'name' => 'ajouter-page',
                'guard_name' => 'web',
                'module_name' => 'page',
                'created_at' => '2024-05-27 13:14:47',
                'updated_at' => '2024-05-27 13:14:47',
            ),
            1 => 
            array (
                'id' => 38,
                'name' => 'voir-page',
                'guard_name' => 'web',
                'module_name' => 'page',
                'created_at' => '2024-05-27 13:14:47',
                'updated_at' => '2024-05-27 13:14:47',
            ),
            2 => 
            array (
                'id' => 39,
                'name' => 'modifier-page',
                'guard_name' => 'web',
                'module_name' => 'page',
                'created_at' => '2024-05-27 13:14:47',
                'updated_at' => '2024-05-27 13:14:47',
            ),
            3 => 
            array (
                'id' => 40,
                'name' => 'supprimer-page',
                'guard_name' => 'web',
                'module_name' => 'page',
                'created_at' => '2024-05-27 13:14:47',
                'updated_at' => '2024-05-27 13:14:47',
            ),
            4 => 
            array (
                'id' => 41,
                'name' => 'ajouter-blog',
                'guard_name' => 'web',
                'module_name' => 'blog',
                'created_at' => '2024-05-27 15:01:53',
                'updated_at' => '2024-05-27 15:01:53',
            ),
            5 => 
            array (
                'id' => 42,
                'name' => 'voir-blog',
                'guard_name' => 'web',
                'module_name' => 'blog',
                'created_at' => '2024-05-27 15:01:53',
                'updated_at' => '2024-05-27 15:01:53',
            ),
            6 => 
            array (
                'id' => 43,
                'name' => 'modifier-blog',
                'guard_name' => 'web',
                'module_name' => 'blog',
                'created_at' => '2024-05-27 15:01:53',
                'updated_at' => '2024-05-27 15:01:53',
            ),
            7 => 
            array (
                'id' => 44,
                'name' => 'supprimer-blog',
                'guard_name' => 'web',
                'module_name' => 'blog',
                'created_at' => '2024-05-27 15:01:53',
                'updated_at' => '2024-05-27 15:01:53',
            ),
            8 => 
            array (
                'id' => 45,
                'name' => 'ajouter-blog-categorie',
                'guard_name' => 'web',
                'module_name' => 'blog-categorie',
                'created_at' => '2024-05-27 17:35:21',
                'updated_at' => '2024-05-27 17:35:21',
            ),
            9 => 
            array (
                'id' => 46,
                'name' => 'voir-blog-categorie',
                'guard_name' => 'web',
                'module_name' => 'blog-categorie',
                'created_at' => '2024-05-27 17:35:21',
                'updated_at' => '2024-05-27 17:35:21',
            ),
            10 => 
            array (
                'id' => 47,
                'name' => 'modifier-blog-categorie',
                'guard_name' => 'web',
                'module_name' => 'blog-categorie',
                'created_at' => '2024-05-27 17:35:21',
                'updated_at' => '2024-05-27 17:35:21',
            ),
            11 => 
            array (
                'id' => 48,
                'name' => 'supprimer-blog-categorie',
                'guard_name' => 'web',
                'module_name' => 'blog-categorie',
                'created_at' => '2024-05-27 17:35:21',
                'updated_at' => '2024-05-27 17:35:21',
            ),
            12 => 
            array (
                'id' => 49,
                'name' => 'ajouter-blog-contenu',
                'guard_name' => 'web',
                'module_name' => 'blog-contenu',
                'created_at' => '2024-05-27 17:35:35',
                'updated_at' => '2024-05-27 17:35:35',
            ),
            13 => 
            array (
                'id' => 50,
                'name' => 'voir-blog-contenu',
                'guard_name' => 'web',
                'module_name' => 'blog-contenu',
                'created_at' => '2024-05-27 17:35:35',
                'updated_at' => '2024-05-27 17:35:35',
            ),
            14 => 
            array (
                'id' => 51,
                'name' => 'modifier-blog-contenu',
                'guard_name' => 'web',
                'module_name' => 'blog-contenu',
                'created_at' => '2024-05-27 17:35:35',
                'updated_at' => '2024-05-27 17:35:35',
            ),
            15 => 
            array (
                'id' => 52,
                'name' => 'supprimer-blog-contenu',
                'guard_name' => 'web',
                'module_name' => 'blog-contenu',
                'created_at' => '2024-05-27 17:35:35',
                'updated_at' => '2024-05-27 17:35:35',
            ),
            16 => 
            array (
                'id' => 53,
                'name' => 'ajouter-site basique',
                'guard_name' => 'web',
                'module_name' => 'site basique',
                'created_at' => '2024-05-27 17:36:13',
                'updated_at' => '2024-05-27 17:36:13',
            ),
            17 => 
            array (
                'id' => 54,
                'name' => 'voir-site basique',
                'guard_name' => 'web',
                'module_name' => 'site basique',
                'created_at' => '2024-05-27 17:36:13',
                'updated_at' => '2024-05-27 17:36:13',
            ),
            18 => 
            array (
                'id' => 55,
                'name' => 'modifier-site basique',
                'guard_name' => 'web',
                'module_name' => 'site basique',
                'created_at' => '2024-05-27 17:36:13',
                'updated_at' => '2024-05-27 17:36:13',
            ),
            19 => 
            array (
                'id' => 56,
                'name' => 'supprimer-site basique',
                'guard_name' => 'web',
                'module_name' => 'site basique',
                'created_at' => '2024-05-27 17:36:13',
                'updated_at' => '2024-05-27 17:36:13',
            ),
            20 => 
            array (
                'id' => 57,
                'name' => 'ajouter-menu',
                'guard_name' => 'web',
                'module_name' => 'menu',
                'created_at' => '2024-05-27 17:36:24',
                'updated_at' => '2024-05-27 17:36:24',
            ),
            21 => 
            array (
                'id' => 58,
                'name' => 'voir-menu',
                'guard_name' => 'web',
                'module_name' => 'menu',
                'created_at' => '2024-05-27 17:36:24',
                'updated_at' => '2024-05-27 17:36:24',
            ),
            22 => 
            array (
                'id' => 59,
                'name' => 'modifier-menu',
                'guard_name' => 'web',
                'module_name' => 'menu',
                'created_at' => '2024-05-27 17:36:24',
                'updated_at' => '2024-05-27 17:36:24',
            ),
            23 => 
            array (
                'id' => 60,
                'name' => 'supprimer-menu',
                'guard_name' => 'web',
                'module_name' => 'menu',
                'created_at' => '2024-05-27 17:36:24',
                'updated_at' => '2024-05-27 17:36:24',
            ),
            24 => 
            array (
                'id' => 61,
                'name' => 'ajouter-service',
                'guard_name' => 'web',
                'module_name' => 'service',
                'created_at' => '2024-05-27 17:36:35',
                'updated_at' => '2024-05-27 17:36:35',
            ),
            25 => 
            array (
                'id' => 62,
                'name' => 'voir-service',
                'guard_name' => 'web',
                'module_name' => 'service',
                'created_at' => '2024-05-27 17:36:35',
                'updated_at' => '2024-05-27 17:36:35',
            ),
            26 => 
            array (
                'id' => 63,
                'name' => 'modifier-service',
                'guard_name' => 'web',
                'module_name' => 'service',
                'created_at' => '2024-05-27 17:36:35',
                'updated_at' => '2024-05-27 17:36:35',
            ),
            27 => 
            array (
                'id' => 64,
                'name' => 'supprimer-service',
                'guard_name' => 'web',
                'module_name' => 'service',
                'created_at' => '2024-05-27 17:36:35',
                'updated_at' => '2024-05-27 17:36:35',
            ),
            28 => 
            array (
                'id' => 65,
                'name' => 'ajouter-reference',
                'guard_name' => 'web',
                'module_name' => 'reference',
                'created_at' => '2024-05-27 17:36:48',
                'updated_at' => '2024-05-27 17:36:48',
            ),
            29 => 
            array (
                'id' => 66,
                'name' => 'voir-reference',
                'guard_name' => 'web',
                'module_name' => 'reference',
                'created_at' => '2024-05-27 17:36:48',
                'updated_at' => '2024-05-27 17:36:48',
            ),
            30 => 
            array (
                'id' => 67,
                'name' => 'modifier-reference',
                'guard_name' => 'web',
                'module_name' => 'reference',
                'created_at' => '2024-05-27 17:36:48',
                'updated_at' => '2024-05-27 17:36:48',
            ),
            31 => 
            array (
                'id' => 68,
                'name' => 'supprimer-reference',
                'guard_name' => 'web',
                'module_name' => 'reference',
                'created_at' => '2024-05-27 17:36:48',
                'updated_at' => '2024-05-27 17:36:48',
            ),
            32 => 
            array (
                'id' => 69,
                'name' => 'ajouter-equipe',
                'guard_name' => 'web',
                'module_name' => 'equipe',
                'created_at' => '2024-05-27 17:37:06',
                'updated_at' => '2024-05-27 17:37:06',
            ),
            33 => 
            array (
                'id' => 70,
                'name' => 'voir-equipe',
                'guard_name' => 'web',
                'module_name' => 'equipe',
                'created_at' => '2024-05-27 17:37:06',
                'updated_at' => '2024-05-27 17:37:06',
            ),
            34 => 
            array (
                'id' => 71,
                'name' => 'modifier-equipe',
                'guard_name' => 'web',
                'module_name' => 'equipe',
                'created_at' => '2024-05-27 17:37:06',
                'updated_at' => '2024-05-27 17:37:06',
            ),
            35 => 
            array (
                'id' => 72,
                'name' => 'supprimer-equipe',
                'guard_name' => 'web',
                'module_name' => 'equipe',
                'created_at' => '2024-05-27 17:37:06',
                'updated_at' => '2024-05-27 17:37:06',
            ),
            36 => 
            array (
                'id' => 73,
                'name' => 'ajouter-slide',
                'guard_name' => 'web',
                'module_name' => 'slide',
                'created_at' => '2024-05-27 17:43:15',
                'updated_at' => '2024-05-27 17:43:15',
            ),
            37 => 
            array (
                'id' => 74,
                'name' => 'voir-slide',
                'guard_name' => 'web',
                'module_name' => 'slide',
                'created_at' => '2024-05-27 17:43:15',
                'updated_at' => '2024-05-27 17:43:15',
            ),
            38 => 
            array (
                'id' => 75,
                'name' => 'modifier-slide',
                'guard_name' => 'web',
                'module_name' => 'slide',
                'created_at' => '2024-05-27 17:43:15',
                'updated_at' => '2024-05-27 17:43:15',
            ),
            39 => 
            array (
                'id' => 76,
                'name' => 'supprimer-slide',
                'guard_name' => 'web',
                'module_name' => 'slide',
                'created_at' => '2024-05-27 17:43:15',
                'updated_at' => '2024-05-27 17:43:15',
            ),
            40 => 
            array (
                'id' => 77,
                'name' => 'ajouter-temoignage',
                'guard_name' => 'web',
                'module_name' => 'temoignage',
                'created_at' => '2024-05-27 17:43:33',
                'updated_at' => '2024-05-27 17:43:33',
            ),
            41 => 
            array (
                'id' => 78,
                'name' => 'voir-temoignage',
                'guard_name' => 'web',
                'module_name' => 'temoignage',
                'created_at' => '2024-05-27 17:43:33',
                'updated_at' => '2024-05-27 17:43:33',
            ),
            42 => 
            array (
                'id' => 79,
                'name' => 'modifier-temoignage',
                'guard_name' => 'web',
                'module_name' => 'temoignage',
                'created_at' => '2024-05-27 17:43:33',
                'updated_at' => '2024-05-27 17:43:33',
            ),
            43 => 
            array (
                'id' => 80,
                'name' => 'supprimer-temoignage',
                'guard_name' => 'web',
                'module_name' => 'temoignage',
                'created_at' => '2024-05-27 17:43:33',
                'updated_at' => '2024-05-27 17:43:33',
            ),
            44 => 
            array (
                'id' => 81,
                'name' => 'ajouter-mediatheque',
                'guard_name' => 'web',
                'module_name' => 'mediatheque',
                'created_at' => '2024-05-27 17:45:03',
                'updated_at' => '2024-05-27 17:45:03',
            ),
            45 => 
            array (
                'id' => 82,
                'name' => 'voir-mediatheque',
                'guard_name' => 'web',
                'module_name' => 'mediatheque',
                'created_at' => '2024-05-27 17:45:03',
                'updated_at' => '2024-05-27 17:45:03',
            ),
            46 => 
            array (
                'id' => 83,
                'name' => 'modifier-mediatheque',
                'guard_name' => 'web',
                'module_name' => 'mediatheque',
                'created_at' => '2024-05-27 17:45:03',
                'updated_at' => '2024-05-27 17:45:03',
            ),
            47 => 
            array (
                'id' => 84,
                'name' => 'supprimer-mediatheque',
                'guard_name' => 'web',
                'module_name' => 'mediatheque',
                'created_at' => '2024-05-27 17:45:03',
                'updated_at' => '2024-05-27 17:45:03',
            ),
            48 => 
            array (
                'id' => 85,
                'name' => 'ajouter-mediatheque-categorie',
                'guard_name' => 'web',
                'module_name' => 'mediatheque-categorie',
                'created_at' => '2024-05-27 17:46:12',
                'updated_at' => '2024-05-27 17:46:12',
            ),
            49 => 
            array (
                'id' => 86,
                'name' => 'voir-mediatheque-categorie',
                'guard_name' => 'web',
                'module_name' => 'mediatheque-categorie',
                'created_at' => '2024-05-27 17:46:12',
                'updated_at' => '2024-05-27 17:46:12',
            ),
            50 => 
            array (
                'id' => 87,
                'name' => 'modifier-mediatheque-categorie',
                'guard_name' => 'web',
                'module_name' => 'mediatheque-categorie',
                'created_at' => '2024-05-27 17:46:12',
                'updated_at' => '2024-05-27 17:46:12',
            ),
            51 => 
            array (
                'id' => 88,
                'name' => 'supprimer-mediatheque-categorie',
                'guard_name' => 'web',
                'module_name' => 'mediatheque-categorie',
                'created_at' => '2024-05-27 17:46:12',
                'updated_at' => '2024-05-27 17:46:12',
            ),
            52 => 
            array (
                'id' => 89,
                'name' => 'ajouter-mediatheque-contenu',
                'guard_name' => 'web',
                'module_name' => 'mediatheque-contenu',
                'created_at' => '2024-05-27 17:46:44',
                'updated_at' => '2024-05-27 17:46:44',
            ),
            53 => 
            array (
                'id' => 90,
                'name' => 'voir-mediatheque-contenu',
                'guard_name' => 'web',
                'module_name' => 'mediatheque-contenu',
                'created_at' => '2024-05-27 17:46:44',
                'updated_at' => '2024-05-27 17:46:44',
            ),
            54 => 
            array (
                'id' => 91,
                'name' => 'modifier-mediatheque-contenu',
                'guard_name' => 'web',
                'module_name' => 'mediatheque-contenu',
                'created_at' => '2024-05-27 17:46:44',
                'updated_at' => '2024-05-27 17:46:44',
            ),
            55 => 
            array (
                'id' => 92,
                'name' => 'supprimer-mediatheque-contenu',
                'guard_name' => 'web',
                'module_name' => 'mediatheque-contenu',
                'created_at' => '2024-05-27 17:46:44',
                'updated_at' => '2024-05-27 17:46:44',
            ),
            56 => 
            array (
                'id' => 93,
                'name' => 'ajouter-administrateur',
                'guard_name' => 'web',
                'module_name' => 'administrateur',
                'created_at' => '2024-05-27 17:47:18',
                'updated_at' => '2024-05-27 17:47:18',
            ),
            57 => 
            array (
                'id' => 94,
                'name' => 'voir-administrateur',
                'guard_name' => 'web',
                'module_name' => 'administrateur',
                'created_at' => '2024-05-27 17:47:18',
                'updated_at' => '2024-05-27 17:47:18',
            ),
            58 => 
            array (
                'id' => 95,
                'name' => 'modifier-administrateur',
                'guard_name' => 'web',
                'module_name' => 'administrateur',
                'created_at' => '2024-05-27 17:47:18',
                'updated_at' => '2024-05-27 17:47:18',
            ),
            59 => 
            array (
                'id' => 96,
                'name' => 'supprimer-administrateur',
                'guard_name' => 'web',
                'module_name' => 'administrateur',
                'created_at' => '2024-05-27 17:47:18',
                'updated_at' => '2024-05-27 17:47:18',
            ),
            60 => 
            array (
                'id' => 97,
                'name' => 'ajouter-configuration',
                'guard_name' => 'web',
                'module_name' => 'configuration',
                'created_at' => '2024-05-27 17:47:39',
                'updated_at' => '2024-05-27 17:47:39',
            ),
            61 => 
            array (
                'id' => 98,
                'name' => 'voir-configuration',
                'guard_name' => 'web',
                'module_name' => 'configuration',
                'created_at' => '2024-05-27 17:47:39',
                'updated_at' => '2024-05-27 17:47:39',
            ),
            62 => 
            array (
                'id' => 99,
                'name' => 'modifier-configuration',
                'guard_name' => 'web',
                'module_name' => 'configuration',
                'created_at' => '2024-05-27 17:47:39',
                'updated_at' => '2024-05-27 17:47:39',
            ),
            63 => 
            array (
                'id' => 100,
                'name' => 'supprimer-configuration',
                'guard_name' => 'web',
                'module_name' => 'configuration',
                'created_at' => '2024-05-27 17:47:39',
                'updated_at' => '2024-05-27 17:47:39',
            ),
            64 => 
            array (
                'id' => 101,
                'name' => 'ajouter-information',
                'guard_name' => 'web',
                'module_name' => 'information',
                'created_at' => '2024-05-27 17:48:46',
                'updated_at' => '2024-05-27 17:48:46',
            ),
            65 => 
            array (
                'id' => 102,
                'name' => 'voir-information',
                'guard_name' => 'web',
                'module_name' => 'information',
                'created_at' => '2024-05-27 17:48:46',
                'updated_at' => '2024-05-27 17:48:46',
            ),
            66 => 
            array (
                'id' => 103,
                'name' => 'modifier-information',
                'guard_name' => 'web',
                'module_name' => 'information',
                'created_at' => '2024-05-27 17:48:46',
                'updated_at' => '2024-05-27 17:48:46',
            ),
            67 => 
            array (
                'id' => 104,
                'name' => 'supprimer-information',
                'guard_name' => 'web',
                'module_name' => 'information',
                'created_at' => '2024-05-27 17:48:46',
                'updated_at' => '2024-05-27 17:48:46',
            ),
            68 => 
            array (
                'id' => 105,
                'name' => 'ajouter-module',
                'guard_name' => 'web',
                'module_name' => 'module',
                'created_at' => '2024-05-27 17:48:57',
                'updated_at' => '2024-05-27 17:48:57',
            ),
            69 => 
            array (
                'id' => 106,
                'name' => 'voir-module',
                'guard_name' => 'web',
                'module_name' => 'module',
                'created_at' => '2024-05-27 17:48:57',
                'updated_at' => '2024-05-27 17:48:57',
            ),
            70 => 
            array (
                'id' => 107,
                'name' => 'modifier-module',
                'guard_name' => 'web',
                'module_name' => 'module',
                'created_at' => '2024-05-27 17:48:57',
                'updated_at' => '2024-05-27 17:48:57',
            ),
            71 => 
            array (
                'id' => 108,
                'name' => 'supprimer-module',
                'guard_name' => 'web',
                'module_name' => 'module',
                'created_at' => '2024-05-27 17:48:57',
                'updated_at' => '2024-05-27 17:48:57',
            ),
            72 => 
            array (
                'id' => 109,
                'name' => 'ajouter-role',
                'guard_name' => 'web',
                'module_name' => 'role',
                'created_at' => '2024-05-27 17:49:16',
                'updated_at' => '2024-05-27 17:49:16',
            ),
            73 => 
            array (
                'id' => 110,
                'name' => 'voir-role',
                'guard_name' => 'web',
                'module_name' => 'role',
                'created_at' => '2024-05-27 17:49:16',
                'updated_at' => '2024-05-27 17:49:16',
            ),
            74 => 
            array (
                'id' => 111,
                'name' => 'modifier-role',
                'guard_name' => 'web',
                'module_name' => 'role',
                'created_at' => '2024-05-27 17:49:16',
                'updated_at' => '2024-05-27 17:49:16',
            ),
            75 => 
            array (
                'id' => 112,
                'name' => 'supprimer-role',
                'guard_name' => 'web',
                'module_name' => 'role',
                'created_at' => '2024-05-27 17:49:16',
                'updated_at' => '2024-05-27 17:49:16',
            ),
            76 => 
            array (
                'id' => 113,
                'name' => 'ajouter-permission',
                'guard_name' => 'web',
                'module_name' => 'permission',
                'created_at' => '2024-05-27 17:49:26',
                'updated_at' => '2024-05-27 17:49:26',
            ),
            77 => 
            array (
                'id' => 114,
                'name' => 'voir-permission',
                'guard_name' => 'web',
                'module_name' => 'permission',
                'created_at' => '2024-05-27 17:49:26',
                'updated_at' => '2024-05-27 17:49:26',
            ),
            78 => 
            array (
                'id' => 115,
                'name' => 'modifier-permission',
                'guard_name' => 'web',
                'module_name' => 'permission',
                'created_at' => '2024-05-27 17:49:26',
                'updated_at' => '2024-05-27 17:49:26',
            ),
            79 => 
            array (
                'id' => 116,
                'name' => 'supprimer-permission',
                'guard_name' => 'web',
                'module_name' => 'permission',
                'created_at' => '2024-05-27 17:49:26',
                'updated_at' => '2024-05-27 17:49:26',
            ),
        ));
        
        
    }
}