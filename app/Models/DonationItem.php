<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_id',
        'food_item_id',
        'quantity',
        'value'
    ];

    protected $casts = [
        'value' => 'decimal:2'
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function foodItem()
    {
        return $this->belongsTo(FoodItem::class);
    }
}