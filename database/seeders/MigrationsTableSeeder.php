<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MigrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('migrations')->delete();
        
        \DB::table('migrations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'migration' => '2014_10_11_000000_create_caisses_table',
                'batch' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'migration' => '2014_10_12_000000_create_users_table',
                'batch' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'migration' => '2014_10_12_100000_create_password_resets_table',
                'batch' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'migration' => '2019_08_19_000000_create_failed_jobs_table',
                'batch' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'migration' => '2019_12_14_000001_create_personal_access_tokens_table',
                'batch' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'migration' => '2024_04_25_141211_create_settings_table',
                'batch' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'migration' => '2024_04_26_092648_create_media_table',
                'batch' => 1,
            ),
            7 => 
            array (
                'id' => 9,
                'migration' => '2024_04_30_100807_create_optimizes_table',
                'batch' => 1,
            ),
            8 => 
            array (
                'id' => 10,
                'migration' => '2024_04_30_114124_create_maintenances_table',
                'batch' => 1,
            ),
            9 => 
            array (
                'id' => 11,
                'migration' => '2024_05_08_093858_create_slides_table',
                'batch' => 1,
            ),
            10 => 
            array (
                'id' => 12,
                'migration' => '2024_05_24_135411_create_modules_table',
                'batch' => 1,
            ),
            11 => 
            array (
                'id' => 13,
                'migration' => '2024_07_24_153833_create_categories_table',
                'batch' => 1,
            ),
            12 => 
            array (
                'id' => 14,
                'migration' => '2024_07_25_115950_create_fournisseurs_table',
                'batch' => 1,
            ),
            13 => 
            array (
                'id' => 15,
                'migration' => '2024_07_25_115951_create_factures_table',
                'batch' => 1,
            ),
            14 => 
            array (
                'id' => 16,
                'migration' => '2024_07_26_123733_create_unites_table',
                'batch' => 1,
            ),
            15 => 
            array (
                'id' => 17,
                'migration' => '2024_07_26_165800_create_magasins_table',
                'batch' => 1,
            ),
            16 => 
            array (
                'id' => 18,
                'migration' => '2024_07_26_165900_create_formats_table',
                'batch' => 1,
            ),
            17 => 
            array (
                'id' => 19,
                'migration' => '2024_07_29_101322_create_produits_table',
                'batch' => 1,
            ),
            18 => 
            array (
                'id' => 20,
                'migration' => '2024_08_18_192118_create_achats_table',
                'batch' => 1,
            ),
            19 => 
            array (
                'id' => 21,
                'migration' => '2024_08_18_192140_create_ajustements_table',
                'batch' => 1,
            ),
            20 => 
            array (
                'id' => 22,
                'migration' => '2024_08_18_192208_create_ventes_table',
                'batch' => 1,
            ),
            21 => 
            array (
                'id' => 23,
                'migration' => '2024_08_20_155830_create_categorie_depenses_table',
                'batch' => 1,
            ),
            22 => 
            array (
                'id' => 24,
                'migration' => '2024_08_20_155845_create_libelle_depenses_table',
                'batch' => 1,
            ),
            23 => 
            array (
                'id' => 25,
                'migration' => '2024_08_20_155846_create_depenses_table',
                'batch' => 1,
            ),
            24 => 
            array (
                'id' => 26,
                'migration' => '2024_08_22_153532_create_menus_table',
                'batch' => 1,
            ),
            25 => 
            array (
                'id' => 27,
                'migration' => '2024_08_23_153339_create_menu_produit_table',
                'batch' => 1,
            ),
            26 => 
            array (
                'id' => 28,
                'migration' => '2024_09_12_132849_create_commandes_table',
                'batch' => 1,
            ),
            27 => 
            array (
                'id' => 29,
                'migration' => '2024_09_13_134742_create_commande_produit_table',
                'batch' => 1,
            ),
            28 => 
            array (
                'id' => 31,
                'migration' => '2024_09_27_182838_create_sorties_table',
                'batch' => 1,
            ),
            29 => 
            array (
                'id' => 32,
                'migration' => '2024_09_30_103252_create_produit_sortie_table',
                'batch' => 1,
            ),
            30 => 
            array (
                'id' => 33,
                'migration' => '2024_09_30_163553_create_inventaires_table',
                'batch' => 1,
            ),
            31 => 
            array (
                'id' => 34,
                'migration' => '2024_09_30_164433_create_inventaire_produit_table',
                'batch' => 1,
            ),
            32 => 
            array (
                'id' => 37,
                'migration' => '2024_09_16_163414_create_historique_caisses_table',
                'batch' => 2,
            ),
            33 => 
            array (
                'id' => 38,
                'migration' => '2024_10_01_173114_create_produit_vente_table',
                'batch' => 3,
            ),
            34 => 
            array (
                'id' => 39,
                'migration' => '2024_10_03_174118_create_cloture_caisses_table',
                'batch' => 4,
            ),
            35 => 
            array (
                'id' => 40,
                'migration' => '2024_10_03_180653_add_statut_cloture_to_ventes',
                'batch' => 5,
            ),
            36 => 
            array (
                'id' => 41,
                'migration' => '2024_10_04_132419_add_client_id_to_commandes',
                'batch' => 6,
            ),
            37 => 
            array (
                'id' => 42,
                'migration' => '2024_10_04_132433_add_caisse_id_to_commandes',
                'batch' => 6,
            ),
            38 => 
            array (
                'id' => 43,
                'migration' => '2024_10_04_194644_add_module_id_to_permissions_table',
                'batch' => 7,
            ),
            39 => 
            array (
                'id' => 44,
                'migration' => '2024_10_04_194959_add_module_id_to_permissions_table',
                'batch' => 8,
            ),
            40 => 
            array (
                'id' => 45,
                'migration' => '2024_04_29_172858_create_permission_tables',
                'batch' => 9,
            ),
            41 => 
            array (
                'id' => 46,
                'migration' => '2024_10_04_201830_add_module_id_to_permissions_table',
                'batch' => 10,
            ),
            42 => 
            array (
                'id' => 47,
                'migration' => '2024_10_05_181645_create_module_permission_table',
                'batch' => 11,
            ),
        ));
        
        
    }
}