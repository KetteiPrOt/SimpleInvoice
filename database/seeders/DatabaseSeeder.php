<?php

namespace Database\Seeders;

use App\Models\Client;
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

        User::factory()->create([
            'name' => 'PATRICIA ELIZABETH TRAVEZ MERO',
            'email' => 'sd.kettei@gmail.com',
        ]);

        // Product::factory(10)->create();
        // Client::factory(10)->create();

        Product::create([
            'name' => 'Jhonnie Rojo',
            'price' => 10.00,
            'user_id' => 1
        ]);

        Client::create([
            'name' => 'PRUEBAS SERVICIO RENTAS INTERNAS',
            'identification' => '0000000000001',
            'user_id' => 1
        ]);
    }
}
