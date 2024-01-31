<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contractors')->insert([
            [
                'id' => 1,
                'company_name' => 'Super Admin',
                'sub_domain' => "admin",
                'address' => "Los Angelos",
                'zip' => '20004'
            ],
            [
                'id' => 2,
                'company_name' => 'ABC Company',
                'sub_domain' => "first",
                'address' => "Los Angelos",
                'zip' => '20004'
            ]
        ]);
    }
}
