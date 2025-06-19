<?php

namespace Database\Seeders;

use App\Models\FoodItem;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FoodItemSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();

        $foodItems = [
            // Fruits
            [
                'name' => 'Apples',
                'description' => 'Fresh red apples',
                'category' => 'Fruits',
                'quantity' => 25,
                'unit' => 'pieces',
                'expiration_date' => Carbon::now()->addDays(10),
                'cost' => 12.50,
                'location' => 'Shelf A'
            ],
            [
                'name' => 'Bananas',
                'description' => 'Ripe yellow bananas',
                'category' => 'Fruits',
                'quantity' => 30,
                'unit' => 'pieces',
                'expiration_date' => Carbon::now()->addDays(5),
                'cost' => 8.00,
                'location' => 'Shelf A'
            ],
            [
                'name' => 'Oranges',
                'description' => 'Fresh oranges',
                'category' => 'Fruits',
                'quantity' => 20,
                'unit' => 'pieces',
                'expiration_date' => Carbon::now()->addDays(14),
                'cost' => 15.00,
                'location' => 'Shelf A'
            ],

            // Vegetables
            [
                'name' => 'Carrots',
                'description' => 'Fresh organic carrots',
                'category' => 'Vegetables',
                'quantity' => 15,
                'unit' => 'pieces',
                'expiration_date' => Carbon::now()->addDays(12),
                'cost' => 6.00,
                'location' => 'Refrigerator'
            ],
            [
                'name' => 'Potatoes',
                'description' => 'Russet potatoes',
                'category' => 'Vegetables',
                'quantity' => 40,
                'unit' => 'pieces',
                'expiration_date' => Carbon::now()->addDays(30),
                'cost' => 10.00,
                'location' => 'Storage Room'
            ],

            // Dairy
            [
                'name' => 'Milk',
                'description' => '2% milk',
                'category' => 'Dairy',
                'quantity' => 12,
                'unit' => 'bottles',
                'expiration_date' => Carbon::now()->addDays(7),
                'cost' => 36.00,
                'location' => 'Refrigerator'
            ],
            [
                'name' => 'Cheese',
                'description' => 'Cheddar cheese blocks',
                'category' => 'Dairy',
                'quantity' => 8,
                'unit' => 'pieces',
                'expiration_date' => Carbon::now()->addDays(21),
                'cost' => 24.00,
                'location' => 'Refrigerator'
            ],

            // Canned Goods
            [
                'name' => 'Canned Tomatoes',
                'description' => 'Diced tomatoes in juice',
                'category' => 'Canned Goods',
                'quantity' => 24,
                'unit' => 'cans',
                'expiration_date' => Carbon::now()->addMonths(18),
                'cost' => 18.00,
                'location' => 'Shelf B'
            ],
            [
                'name' => 'Canned Beans',
                'description' => 'Black beans',
                'category' => 'Canned Goods',
                'quantity' => 18,
                'unit' => 'cans',
                'expiration_date' => Carbon::now()->addMonths(24),
                'cost' => 14.40,
                'location' => 'Shelf B'
            ],

            // Grains
            [
                'name' => 'Rice',
                'description' => 'Long grain white rice',
                'category' => 'Grains & Cereals',
                'quantity' => 10,
                'unit' => 'bags',
                'expiration_date' => Carbon::now()->addMonths(12),
                'cost' => 25.00,
                'location' => 'Storage Room'
            ],
            [
                'name' => 'Pasta',
                'description' => 'Spaghetti pasta',
                'category' => 'Grains & Cereals',
                'quantity' => 15,
                'unit' => 'boxes',
                'expiration_date' => Carbon::now()->addMonths(18),
                'cost' => 12.00,
                'location' => 'Shelf C'
            ],

            // Items expiring soon (for testing alerts)
            [
                'name' => 'Bread',
                'description' => 'Whole wheat bread',
                'category' => 'Grains & Cereals',
                'quantity' => 6,
                'unit' => 'loaves',
                'expiration_date' => Carbon::now()->addDays(3),
                'cost' => 18.00,
                'location' => 'Shelf D'
            ],

            // Low stock items
            [
                'name' => 'Eggs',
                'description' => 'Large eggs',
                'category' => 'Dairy',
                'quantity' => 3,
                'unit' => 'dozens',
                'expiration_date' => Carbon::now()->addDays(14),
                'cost' => 9.00,
                'location' => 'Refrigerator'
            ],

            // Expired item (for testing)
            [
                'name' => 'Yogurt',
                'description' => 'Greek yogurt',
                'category' => 'Dairy',
                'quantity' => 4,
                'unit' => 'containers',
                'expiration_date' => Carbon::now()->subDays(2),
                'cost' => 8.00,
                'location' => 'Refrigerator'
            ]
        ];

        foreach ($foodItems as $item) {
            $category = $categories->where('name', $item['category'])->first();
            if ($category) {
                FoodItem::create([
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'category_id' => $category->id,
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'],
                    'expiration_date' => $item['expiration_date'],
                    'cost' => $item['cost'],
                    'location' => $item['location']
                ]);
            }
        }
    }
}