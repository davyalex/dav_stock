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
                'first_name' => 'Tanoh Davy Alex',
                'last_name' => 'kouamelan',
                'phone' => '0779613593',
                'email' => 'alexkouamelan96@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$Ymq3vTXNraokhgMMUystkucMGUlp3Z5SVuelfn1RW07IxMkpS8X6a',
                'avatar' => NULL,
                'role' => 'developpeur',
                'remember_token' => NULL,
                'created_at' => '2024-05-09 18:22:35',
                'updated_at' => '2024-05-09 22:54:27',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 19361350221,
                'first_name' => 'admin',
                'last_name' => 'admin1',
                'phone' => '0000000000',
                'email' => 'admin1@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$DMe6X316H4UOgTc6meV7xucgXFC9tZOiBdYzGrRgB3OB7QtaBgcmu',
                'avatar' => NULL,
                'role' => 'developpeur',
                'remember_token' => NULL,
                'created_at' => '2024-05-27 11:12:14',
                'updated_at' => '2024-05-27 11:12:14',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}