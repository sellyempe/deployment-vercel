<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Destination Categories (type = 1)
        $destinationCategories = ['Bersejarah', 'Budaya', 'Diving & Snorkeling', 'Alam'];
        foreach ($destinationCategories as $name) {
            Category::create([
                'category_type' => 1,
                'category_name' => $name,
            ]);
        }

        // Trip Include Categories (type = 2)
        $includeCategories = ['Flights', 'Accommodation', 'Transport', 'Guide', 'Tickets', 'Activities', 'Meals', 'Insurance', 'Others'];
        foreach ($includeCategories as $name) {
            Category::create([
                'category_type' => 2,
                'category_name' => $name,
            ]);
        }

        // Trip Exclude Categories (type = 3)
        $excludeCategories = ['Beverages', 'Gratuity', 'Personal', 'Extra', 'Media'];
        foreach ($excludeCategories as $name) {
            Category::create([
                'category_type' => 3,
                'category_name' => $name,
            ]);
        }
    }
}
