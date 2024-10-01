<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 6484939514,
                'last_name' => 'kouamelan',
                'first_name' => 'Tanoh Davy Alex',
                'phone' => '0779613593',
                'email' => 'alexkouamelan96@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$Ymq3vTXNraokhgMMUystkucMGUlp3Z5SVuelfn1RW07IxMkpS8X6a',
                'avatar' => NULL,
                'role' => 'developpeur',
                'remember_token' => NULL,
                'created_at' => '2024-05-09 18:22:35',
                'updated_at' => '2024-09-27 10:34:54',
                'deleted_at' => NULL,
                'caisse_id' => NULL,
            ),
            1 => 
            array (
                'id' => 11868144821,
                'last_name' => 'admin',
                'first_name' => 'admin',
                'phone' => '00000000',
                'email' => 'admin@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$dnQRfav.1Wj9LLE.cPCeF.tF1pwwztyaqYv0jH4l3DZlbCLhOHyoS',
                'avatar' => NULL,
                'role' => 'developpeur',
                'remember_token' => NULL,
                'created_at' => '2024-09-27 15:20:02',
                'updated_at' => '2024-09-27 15:20:02',
                'deleted_at' => NULL,
                'caisse_id' => NULL,
            ),
            2 => 
            array (
                'id' => 14515841191,
                'last_name' => 'alex',
                'first_name' => 'alex',
                'phone' => '0142855584',
                'email' => 'caisse@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$cMk16SjsgZnU4lS4N6vCMuXb.GyfQno9wKfQiu9fYFieVPmp5O.j.',
                'avatar' => NULL,
                'role' => 'caisse',
                'remember_token' => NULL,
                'created_at' => '2024-09-27 11:08:25',
                'updated_at' => '2024-09-30 08:20:28',
                'deleted_at' => NULL,
                'caisse_id' => NULL,
            ),
        ));
        
        
    }
}