<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'contractor_id' => 1,
                'first_name' => "Super",
                'last_name' => "Admin",
                'email' => 'superadmin@myplanbase.com',
                'password' => bcrypt('Abc123'),
                'user_role_id' => 1,
                'admin_token' => Str::random(60)
            ],
            [
                'id' => 2,
                'contractor_id' => 2,
                'first_name' => "Contractor",
                'last_name' => "Admin",
                'email' => 'contractoradmin@myplanbase.com',
                'password' => bcrypt('Abc123'),
                'user_role_id' => 3,
                'admin_token' => Str::random(60)
            ]
        ]);
    }
}
