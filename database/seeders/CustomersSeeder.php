<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            [
                'id' => 1,
                'contractor_id' => 2,
                'name' => 'Customer 1',
                'source_website' => 'sourcewebsite',
                'email' => "customer1@example.com",
                'phone' => "17055551212",
                'home_location' => "Augusta",
                'home_state' => "California",
                'home_zip' => "12345",
                'note' => "some note",
            ],
            [
                'id' => 2,
                'contractor_id' => 2,
                'name' => 'Customer 2',
                'source_webiste' => 'sourcewebsite',
                'email' => "customer2@example.com",
                'phone' => "17055551212",
                'home_location' => "Augusta",
                'home_state' => "California",
                'home_zip' => "12345",
                'note' => "some note",
            ],
            [
                'id' => 3,
                'contractor_id' => 2,
                'name' => 'Customer 3',
                'source_webiste' => 'sourcewebsite',
                'email' => "customer3@example.com",
                'phone' => "17055551212",
                'home_location' => "Augusta",
                'home_state' => "California",
                'home_zip' => "12345",
                'note' => "some note",
            ],
        ]);
    }
}
