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
                'id' => 10127531461,
                'last_name' => 'admin',
                'first_name' => 'admin',
                'phone' => '0102030405',
                'email' => 'admin@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$LVhJ1DghgCDGnarVJZ/vUOtA/sy53KTS04id0Ln2XvJv3CQAt5qr.',
                'avatar' => NULL,
                'role' => 'developpeur',
                'remember_token' => NULL,
                'created_at' => '2024-09-23 08:33:00',
                'updated_at' => '2024-09-23 08:33:00',
                'deleted_at' => NULL,
                'caisse_id' => NULL,
            ),
        ));
        
        
    }
}