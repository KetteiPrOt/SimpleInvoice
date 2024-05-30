<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakeIdentification = '';
        for($i = 0; $i < 10; $i++){
            $fakeIdentification .= fake()->randomDigitNotZero();
        }
        return [
            'name' => fake()->name(),
            'identification' => $fakeIdentification,
            'email' => fake()->email(),
            'user_id' => 1
        ];
    }
}
