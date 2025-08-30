<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Concerts',
                'slug' => 'concerts',
                'status' => 'active',
                'type' => 'events',
                'user_id' => 1,
            ],
            [
                'name' => 'Conferences',
                'slug' => 'conferences',
                'status' => 'active',
                'type' => 'events',
                'user_id' => 1,
            ],
            [
                'name' => 'Circus',
                'slug' => 'circus',
                'status' => 'active',
                'type' => 'events',
                'user_id' => 1,
            ],
            [
                'name' => 'Workshops',
                'slug' => 'workshops',
                'status' => 'inactive',
                'type' => 'events',
                'user_id' => 1,
            ],
            [
                'name' => 'Fast Food',
                'slug' => 'fast-food',
                'status' => 'active',
                'type' => 'restaurants',
                'user_id' => 1,
            ],
            [
                'name' => 'Seafood',
                'slug' => 'seafood',
                'status' => 'active',
                'type' => 'restaurants',
                'user_id' => 1,
            ],
            [
                'name' => 'Italian Cuisine',
                'slug' => 'italian-cuisine',
                'status' => 'active',
                'type' => 'restaurants',
                'user_id' => 1,
            ],
            [
                'name' => 'Desserts & Sweets',
                'slug' => 'desserts-sweets',
                'status' => 'active',
                'type' => 'restaurants',
                'user_id' => 1,
            ],
            [
                'name' => 'Steakhouses',
                'slug' => 'steakhouses',
                'status' => 'inactive',
                'type' => 'restaurants',
                'user_id' => 1,
            ],

        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
