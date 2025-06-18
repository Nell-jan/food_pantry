<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    protected $fillable = [
    'name', 'category', 'quantity', 'unit', 'expiry_date', 'notes'
];

    //// In your FoodItem model
protected $casts = [
    'expiry_date' => 'date',
];
}
