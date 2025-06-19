<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use App\Models\Category;
use Illuminate\Http\Request;

class FoodItemController extends Controller
{
    public function index(Request $request)
    {
        $query = FoodItem::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            switch ($request->status) {
                case 'expired':
                    $query->expired();
                    break;
                case 'expiring_soon':
                    $query->expiringSoon();
                    break;
                case 'low_stock':
                    $query->lowStock();
                    break;
            }
        }

        $items = $query->paginate(15);
        $categories = Category::all();

        return view('food-items.index', compact('items', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('food-items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'expiration_date' => 'nullable|date|after:today',
            'cost' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255'
        ]);

        FoodItem::create($validated);

        return redirect()->route('food-items.index')
            ->with('success', 'Food item added successfully!');
    }

    public function show(FoodItem $foodItem)
    {
        $foodItem->load('category');
        return view('food-items.show', compact('foodItem'));
    }

    public function edit(FoodItem $foodItem)
    {
        $categories = Category::all();
        return view('food-items.edit', compact('foodItem', 'categories'));
    }

    public function update(Request $request, FoodItem $foodItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'expiration_date' => 'nullable|date',
            'cost' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255'
        ]);

        $foodItem->update($validated);

        return redirect()->route('food-items.index')
            ->with('success', 'Food item updated successfully!');
    }

    public function destroy(FoodItem $foodItem)
    {
        $foodItem->delete();

        return redirect()->route('food-items.index')
            ->with('success', 'Food item deleted successfully!');
    }
}