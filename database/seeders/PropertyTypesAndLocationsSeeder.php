<?php

namespace Database\Seeders;

use App\Models\PropertyType;
use App\Models\Location;
use Illuminate\Database\Seeder;

class PropertyTypesAndLocationsSeeder extends Seeder
{
    public function run(): void
    {
        // Create property types
        $propertyTypes = [
            ['name' => 'House', 'slug' => 'house', 'description' => 'Single family house'],
            ['name' => 'Apartment', 'slug' => 'apartment', 'description' => 'Apartment unit'],
            ['name' => 'Condo', 'slug' => 'condo', 'description' => 'Condominium'],
            ['name' => 'Townhouse', 'slug' => 'townhouse', 'description' => 'Townhouse property'],
            ['name' => 'Commercial', 'slug' => 'commercial', 'description' => 'Commercial space'],
            ['name' => 'Land', 'slug' => 'land', 'description' => 'Vacant land'],
        ];

        foreach ($propertyTypes as $type) {
            PropertyType::firstOrCreate(['slug' => $type['slug']], $type);
        }

        // Create locations (Pakistani cities)
        $locations = [
            ['city' => 'Karachi', 'state' => 'Sindh', 'country' => 'Pakistan', 'zip_code' => '75000'],
            ['city' => 'Lahore', 'state' => 'Punjab', 'country' => 'Pakistan', 'zip_code' => '54000'],
            ['city' => 'Islamabad', 'state' => 'Capital', 'country' => 'Pakistan', 'zip_code' => '44000'],
            ['city' => 'Rawalpindi', 'state' => 'Punjab', 'country' => 'Pakistan', 'zip_code' => '46000'],
            ['city' => 'Multan', 'state' => 'Punjab', 'country' => 'Pakistan', 'zip_code' => '60000'],
            ['city' => 'Hyderabad', 'state' => 'Sindh', 'country' => 'Pakistan', 'zip_code' => '71000'],
            ['city' => 'Peshawar', 'state' => 'Khyber Pakhtunkhwa', 'country' => 'Pakistan', 'zip_code' => '25000'],
            ['city' => 'Quetta', 'state' => 'Balochistan', 'country' => 'Pakistan', 'zip_code' => '87000'],
        ];

        foreach ($locations as $location) {
            Location::firstOrCreate(['city' => $location['city']], $location);
        }
    }
}
