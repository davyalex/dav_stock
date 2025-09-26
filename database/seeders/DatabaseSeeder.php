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

      
        $this->call(CategoriesTableSeeder::class);
        $this->call(CaissesTableSeeder::class);
        $this->call(ProduitSeeder::class);
        $this->call(IntrantSeeder::class);
        }
}
