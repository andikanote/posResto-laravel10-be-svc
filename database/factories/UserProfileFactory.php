<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'bio' => fake()->paragraph(),
            'subscribe_newsletter' => fake()->boolean(),
        ];
    }
}
