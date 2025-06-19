<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_name',
        'donor_email',
        'donor_phone',
        'donation_date',
        'notes',
        'total_value'
    ];

    protected $casts = [
        'donation_date' => 'date',
        'total_value' => 'decimal:2'
    ];

    public function donationItems()
    {
        return $this->hasMany(DonationItem::class);
    }

    public function getTotalItemsAttribute()
    {
        return $this->donationItems()->sum('quantity');
    }
}