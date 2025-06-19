<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use App\Models\Category;
use App\Models\Donation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_items' => FoodItem::sum('quantity'),
            'total_categories' => Category::count(),
            'expired_items' => FoodItem::expired()->count(),
            'expiring_soon' => FoodItem::expiringSoon()->count(),
            'low_stock_items' => FoodItem::lowStock()->count(),
            'total_donations' => Donation::count(),
            'total_value' => FoodItem::sum('cost') ?? 0
        ];

        $recent_items = FoodItem::with('category')
            ->latest()
            ->take(5)
            ->get();

        $expiring_items = FoodItem::with('category')
            ->expiringSoon()
            ->orderBy('expiration_date')
            ->take(5)
            ->get();

        $categories = Category::withCount('foodItems')->get();

        return view('dashboard', compact('stats', 'recent_items', 'expiring_items', 'categories'));
    }
}