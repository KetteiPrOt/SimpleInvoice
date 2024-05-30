<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Permission::create(['name' => 'users']);
        $role = Role::create(['name' => 'Administrador']);
        $admin = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
        ]);

        $role->givePermissionTo('users');
        $admin->assignRole('Administrador');

        $regularUser = User::factory()->create([
            'name' => 'PATRICIA ELIZABETH TRAVEZ MERO',
            'email' => 'patricia@gmail.com',
            'identification' => '1717355448001',
            'commercial_name' => 'DEPOSITO EL LICENCIADO',
            'address' => 'Jaramijo Barrio Santa Cruz, donde esta la Cruz'
        ]);

        // Product::factory(10)->create();
        // Client::factory(10)->create();

        Product::create([
            'name' => 'Jhonnie Rojo',
            'price' => 10.00,
            'user_id' => $regularUser->id
        ]);

        Client::create([
            'name' => 'PRUEBAS SERVICIO RENTAS INTERNAS',
            'identification' => '0000000000001',
            'email' => 'sri@gob.ec',
            'user_id' => $regularUser->id
        ]);
    }
}
