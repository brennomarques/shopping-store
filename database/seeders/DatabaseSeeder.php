<?php

namespace Database\Seeders;

use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Products;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @return void
     */
    public function run(): void
    {
        User::factory(10)->create();
        Products::factory(10)->create();
        Orders::factory(5)->create();
        OrderItems::factory(5)->create();

        User::factory()
            ->create(
                [
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                ]
            );
    }
}
