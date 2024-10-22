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
                'id' => 3755024613,
                'last_name' => 'developpeur',
                'first_name' => 'developpeur',
                'phone' => '0779613593',
                'email' => 'developpeur@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$fYcvVhUD9XqNe02Cg5ZNZ.04bqAgnslPSlnMRA1w75Jiu7aFEWH3i',
                'avatar' => NULL,
                'role' => 'developpeur',
                'remember_token' => NULL,
                'created_at' => '2024-10-22 16:17:35',
                'updated_at' => '2024-10-22 16:17:35',
                'deleted_at' => NULL,
                'caisse_id' => NULL,
            ),
            1 => 
            array (
                'id' => 13761896451,
                'last_name' => 'caisse_defaut',
                'first_name' => 'caisse_defaut',
                'phone' => '0102030405',
                'email' => 'caisse-defaut@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$yebEJex1IK7iniBII4.3bu1Kszf7IQnhvcK.h99EtGvxVH9oRPu9i',
                'avatar' => NULL,
                'role' => 'caisse',
                'remember_token' => NULL,
                'created_at' => '2024-10-21 16:29:06',
                'updated_at' => '2024-10-22 16:41:47',
                'deleted_at' => NULL,
                'caisse_id' => NULL,
            ),
            2 => 
            array (
                'id' => 15591038721,
                'last_name' => 'superadmin',
                'first_name' => 'superadmin',
                'phone' => '2520212563',
                'email' => 'superadmin@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$kA0s24kDRqy1cLW6meiW0Oc4I5/Hxm03c0eyyn63N5JMREqfphQu6',
                'avatar' => NULL,
                'role' => 'superadmin',
                'remember_token' => NULL,
                'created_at' => '2024-10-05 21:04:37',
                'updated_at' => '2024-10-22 16:16:35',
                'deleted_at' => NULL,
                'caisse_id' => NULL,
            ),
        ));
        
        
    }
}