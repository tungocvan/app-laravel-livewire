<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Client;

class country_clients extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo 10 quốc gia ngẫu nhiên
        Country::factory(10)->create();

        // Tạo 50 khách hàng ngẫu nhiên
        Client::factory(50)->create();
    }
}
