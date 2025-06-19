<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'food_item_id',
        'type',
        'quantity',
        'unit',
        'notes'
    ];

    protected $casts = [
        'quantity' => 'decimal:2'
    ];

    // Relationships
    public function foodItem()
    {
        return $this->belongsTo(FoodItem::class);
    }

    // Get transaction type with icon
    public function getTypeDisplay()
    {
        $types = [
            'added' => ['icon' => 'bi-plus-circle', 'text' => 'Added', 'class' => 'text-success'],
            'consumed' => ['icon' => 'bi-check-circle', 'text' => 'Consumed', 'class' => 'text-primary'],
            'expired' => ['icon' => 'bi-exclamation-triangle', 'text' => 'Expired', 'class' => 'text-danger'],
            'wasted' => ['icon' => 'bi-trash', 'text' => 'Wasted', 'class' => 'text-warning']
        ];

        return $types[$this->type] ?? ['icon' => 'bi-circle', 'text' => 'Unknown', 'class' => 'text-muted'];
    }
}