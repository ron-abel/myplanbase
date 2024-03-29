<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            [
                'id' => 1,
                'user_role_name' => 'Super Admin',
                'user_role_description' => "this is super admin"
            ],
            [
                'id' => 3,
                'user_role_name' => 'Tenant Manager',
                'user_role_description' => "this is tenant manager"
            ],
            [
                'id' => 2,
                'user_role_name' => 'Tenant Owner',
                'user_role_description' => "this is tenant owner"
            ],
            [
                'id' => 4,
                'user_role_name' => 'Client User',
                'user_role_description' => "this is tenant viewer"
            ]
        ]);
    }
}
