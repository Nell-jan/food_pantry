<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Fruits',
                'description' => 'Fresh fruits and produce',
                'color' => '#22c55e'
            ],
            [
                'name' => 'Vegetables',
                'description' => 'Fresh vegetables and greens',
                'color' => '#16a34a'
            ],
            [
                'name' => 'Dairy',
                'description' => 'Milk, cheese, and dairy products',
                'color' => '#3b82f6'
            ],
            [
                'name' => 'Meat & Poultry',
                'description' => 'Fresh and frozen meat products',
                'color' => '#dc2626'
            ],
            [
                'name' => 'Canned Goods',
                'description' => 'Canned and preserved foods',
                'color' => '#f59e0b'
            ],
            [
                'name' => 'Beverages',
                'description' => 'Drinks and beverages',
                'color' => '#06b6d4'
            ],
            [
                'name' => 'Grains & Cereals',
                'description' => 'Rice, pasta, bread, and cereals',
                'color' => '#8b5cf6'
            ],
            [
                'name' => 'Snacks',
                'description' => 'Chips, crackers, and snack foods',
                'color' => '#f97316'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}