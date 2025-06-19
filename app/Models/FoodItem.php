<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FoodItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'quantity',
        'unit',
        'expiration_date',
        'date_added',
        'cost',
        'location',
        'status'
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'date_added' => 'date',
        'cost' => 'decimal:2'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function donationItems()
    {
        return $this->hasMany(DonationItem::class);
    }

    public function getIsExpiredAttribute()
    {
        return $this->expiration_date && $this->expiration_date->isPast();
    }

    public function getIsExpiringSoonAttribute()
    {
        return $this->expiration_date &&
               $this->expiration_date->between(now(), now()->addDays(7));
    }

    public function getDaysUntilExpirationAttribute()
    {
        if (!$this->expiration_date) return null;
        return now()->diffInDays($this->expiration_date, false);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')->where('quantity', '>', 0);
    }

    public function scopeExpired($query)
    {
        return $query->where('expiration_date', '<', now());
    }

    public function scopeExpiringSoon($query)
    {
        return $query->whereBetween('expiration_date', [now(), now()->addDays(7)]);
    }

    public function scopeLowStock($query)
    {
        return $query->where('quantity', '<=', 5);
    }
}