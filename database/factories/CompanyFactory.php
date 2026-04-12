<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'legal_name' => fake()->company().' SA de CV',
            'tax_id' => strtoupper(fake()->bothify('???######??#')),
            'email' => fake()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'active' => true,
        ];
    }
}
