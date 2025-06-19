<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\FoodItem;
use App\Models\DonationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::with('donationItems.foodItem')
            ->latest()
            ->paginate(15);

        return view('donations.index', compact('donations'));
    }

    public function create()
    {
        $foodItems = FoodItem::with('category')->get();
        return view('donations.create', compact('foodItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'donor_phone' => 'nullable|string|max:20',
            'donation_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.food_item_id' => 'required|exists:food_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.value' => 'nullable|numeric|min:0'
        ]);

        DB::transaction(function () use ($validated) {
            $donation = Donation::create([
                'donor_name' => $validated['donor_name'],
                'donor_email' => $validated['donor_email'],
                'donor_phone' => $validated['donor_phone'],
                'donation_date' => $validated['donation_date'],
                'notes' => $validated['notes'],
                'total_value' => 0
            ]);

            $totalValue = 0;

            foreach ($validated['items'] as $item) {
                $donationItem = DonationItem::create([
                    'donation_id' => $donation->id,
                    'food_item_id' => $item['food_item_id'],
                    'quantity' => $item['quantity'],
                    'value' => $item['value'] ?? 0
                ]);

                // Update food item quantity
                $foodItem = FoodItem::find($item['food_item_id']);
                $foodItem->increment('quantity', $item['quantity']);

                $totalValue += $donationItem->value;
            }

            $donation->update(['total_value' => $totalValue]);
        });

        return redirect()->route('donations.index')
            ->with('success', 'Donation recorded successfully!');
    }

    public function show(Donation $donation)
    {
        $donation->load('donationItems.foodItem.category');
        return view('donations.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        $donation->load('donationItems.foodItem');
        $foodItems = FoodItem::with('category')->get();
        return view('donations.edit', compact('donation', 'foodItems'));
    }

    public function update(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'donor_phone' => 'nullable|string|max:20',
            'donation_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $donation->update($validated);

        return redirect()->route('donations.show', $donation)
            ->with('success', 'Donation updated successfully!');
    }

    public function destroy(Donation $donation)
    {
        DB::transaction(function () use ($donation) {
            // Reverse the inventory changes
            foreach ($donation->donationItems as $item) {
                $foodItem = FoodItem::find($item->food_item_id);
                if ($foodItem) {
                    $foodItem->decrement('quantity', $item->quantity);
                }
            }

            $donation->delete();
        });

        return redirect()->route('donations.index')
            ->with('success', 'Donation deleted successfully!');
    }
}