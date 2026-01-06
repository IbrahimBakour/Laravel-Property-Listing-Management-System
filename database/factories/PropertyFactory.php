<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(1000000, 50000000),
            'bedrooms' => fake()->numberBetween(1, 5),
            'bathrooms' => fake()->numberBetween(1, 3),
            'area' => fake()->numberBetween(1000, 10000),
            'status' => fake()->randomElement(['For Sale', 'For Rent', 'Sold']),
            'agent_id' => User::where('role', 'agent')->inRandomOrder()->first()?->id ?? User::factory()->agent(),
            'property_type_id' => PropertyType::inRandomOrder()->first()?->id ?? PropertyType::factory(),
            'location_id' => Location::inRandomOrder()->first()?->id ?? Location::factory(),
        ];
    }
}
