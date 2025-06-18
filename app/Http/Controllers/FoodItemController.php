<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use Illuminate\Http\Request;

class FoodItemController extends Controller
{
    public function index()
    {
        $items = FoodItem::orderBy('expiry_date', 'asc')->get();
        
        // Group items by expiry status
        $today = now()->toDateString();
        $nextWeek = now()->addWeek()->toDateString();
        
        $expiredItems = $items->filter(function ($item) use ($today) {
            return $item->expiry_date->toDateString() < $today;
        });
        
        $expiringSoon = $items->filter(function ($item) use ($today, $nextWeek) {
            $expiryDate = $item->expiry_date->toDateString();
            return $expiryDate >= $today && $expiryDate <= $nextWeek;
        });
        
        return view('food.index', compact('items', 'expiredItems', 'expiringSoon'));
    }

    public function create()
    {
        $categories = [
            'Grains & Cereals' => ['Rice', 'Wheat', 'Oats', 'Quinoa', 'Barley', 'Pasta', 'Bread', 'Cereal'],
            'Proteins' => ['Chicken', 'Beef', 'Pork', 'Fish', 'Eggs', 'Tofu', 'Beans', 'Lentils', 'Nuts'],
            'Dairy & Alternatives' => ['Milk', 'Cheese', 'Yogurt', 'Butter', 'Cream', 'Almond Milk', 'Soy Milk'],
            'Vegetables' => ['Onions', 'Garlic', 'Potatoes', 'Carrots', 'Tomatoes', 'Lettuce', 'Spinach', 'Broccoli'],
            'Fruits' => ['Apples', 'Bananas', 'Oranges', 'Berries', 'Grapes', 'Avocados', 'Lemons', 'Limes'],
            'Pantry Staples' => ['Oil', 'Vinegar', 'Salt', 'Sugar', 'Flour', 'Spices', 'Herbs', 'Condiments'],
            'Canned & Packaged' => ['Canned Tomatoes', 'Canned Beans', 'Soup', 'Sauce', 'Crackers', 'Snacks'],
            'Frozen Foods' => ['Frozen Vegetables', 'Ice Cream', 'Frozen Fruits', 'Frozen Meals', 'Frozen Meat'],
            'Beverages' => ['Water', 'Juice', 'Soda', 'Tea', 'Coffee', 'Wine', 'Beer'],
            'Baking & Desserts' => ['Baking Powder', 'Vanilla', 'Chocolate', 'Cake Mix', 'Cookies']
        ];
        
        $units = [
            'Weight' => ['g', 'kg', 'oz', 'lbs'],
            'Volume' => ['ml', 'L', 'fl oz', 'cups', 'tbsp', 'tsp'],
            'Count' => ['pcs', 'items', 'dozen', 'pair'],
            'Packaging' => ['pack', 'box', 'bag', 'bottle', 'can', 'jar', 'container']
        ];
        
        return view('food.create', compact('categories', 'units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string',
            'expiry_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:500',
        ]);

        FoodItem::create($validated);
        return redirect()->route('food-items.index')->with('success', 'Item added successfully!');
    }

    public function edit(FoodItem $foodItem)
    {
        $categories = [
            'Grains & Cereals' => ['Rice', 'Wheat', 'Oats', 'Quinoa', 'Barley', 'Pasta', 'Bread', 'Cereal'],
            'Proteins' => ['Chicken', 'Beef', 'Pork', 'Fish', 'Eggs', 'Tofu', 'Beans', 'Lentils', 'Nuts'],
            'Dairy & Alternatives' => ['Milk', 'Cheese', 'Yogurt', 'Butter', 'Cream', 'Almond Milk', 'Soy Milk'],
            'Vegetables' => ['Onions', 'Garlic', 'Potatoes', 'Carrots', 'Tomatoes', 'Lettuce', 'Spinach', 'Broccoli'],
            'Fruits' => ['Apples', 'Bananas', 'Oranges', 'Berries', 'Grapes', 'Avocados', 'Lemons', 'Limes'],
            'Pantry Staples' => ['Oil', 'Vinegar', 'Salt', 'Sugar', 'Flour', 'Spices', 'Herbs', 'Condiments'],
            'Canned & Packaged' => ['Canned Tomatoes', 'Canned Beans', 'Soup', 'Sauce', 'Crackers', 'Snacks'],
            'Frozen Foods' => ['Frozen Vegetables', 'Ice Cream', 'Frozen Fruits', 'Frozen Meals', 'Frozen Meat'],
            'Beverages' => ['Water', 'Juice', 'Soda', 'Tea', 'Coffee', 'Wine', 'Beer'],
            'Baking & Desserts' => ['Baking Powder', 'Vanilla', 'Chocolate', 'Cake Mix', 'Cookies']
        ];
        
        $units = [
            'Weight' => ['g', 'kg', 'oz', 'lbs'],
            'Volume' => ['ml', 'L', 'fl oz', 'cups', 'tbsp', 'tsp'],
            'Count' => ['pcs', 'items', 'dozen', 'pair'],
            'Packaging' => ['pack', 'box', 'bag', 'bottle', 'can', 'jar', 'container']
        ];
        
        return view('food.edit', compact('foodItem', 'categories', 'units'));
    }

    public function update(Request $request, FoodItem $foodItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string',
            'expiry_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $foodItem->update($validated);
        return redirect()->route('food-items.index')->with('success', 'Item updated successfully!');
    }

    public function destroy(FoodItem $foodItem)
    {
        $foodItem->delete();
        return redirect()->route('food-items.index')->with('success', 'Item deleted successfully!');
    }
}