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
                'id' => 15591038721,
                'last_name' => 'superadmin',
                'first_name' => 'superadmin',
                'phone' => '2520212563',
                'email' => 'superadmin@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$5ZRMXY1sNMVzcy6371P8DeXTJUE0ImYhRPM8hmU8cLUFA/2JpRXIu',
                'avatar' => NULL,
                'role' => 'developpeur',
                'remember_token' => NULL,
                'created_at' => '2024-10-05 21:04:37',
                'updated_at' => '2024-10-05 21:04:37',
                'deleted_at' => NULL,
                'caisse_id' => NULL,
            ),
        ));
        
        
    }
}