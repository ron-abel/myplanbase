<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserRolesSeeder::class);
        $this->call(ContractorsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(CustomersSeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
