<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Location;
use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed property types and locations with standard options
        $this->call(PropertyTypesAndLocationsSeeder::class);

        // Create admin user
        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Create agent users
        User::factory(5)->agent()->create();

        // Create regular users
        User::factory(10)->create();

        // Create properties (with existing agents, types, and locations)
        Property::factory(20)->create();

        // Create media files for properties
        foreach (Property::all() as $property) {
            Media::factory(3)->create([
                'property_id' => $property->id,
            ]);
            Media::factory()->primary()->create([
                'property_id' => $property->id,
            ]);
        }
    }
}
