<?php

namespace Database\Seeders;

use App\Models\Counter;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

//        Counter::factory(1)->create();
//        Product::factory(5)->create();
//        Customer::factory(50)->create();
        Invoice::factory(100)->create();
    }
}
