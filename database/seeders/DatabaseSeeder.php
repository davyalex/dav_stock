<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PermissionsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
              

        
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(ModulesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);

        $this->call(FormatsTableSeeder::class);
        $this->call(FournisseursTableSeeder::class);
        $this->call(UnitesTableSeeder::class);
        $this->call(CategorieTableSeeder::class);

        $this->call(CategorieDepensesTableSeeder::class);
<<<<<<< HEAD
        $this->call(LibelleDepensesTableSeeder::class);
=======

>>>>>>> a5523234f34261c7c78b5db23027e42d65e008cd
    }
}
