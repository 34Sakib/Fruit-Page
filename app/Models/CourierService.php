<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'base_charge',
        'inside_dhaka_charge',
        'outside_dhaka_charge',
        'delivery_days_inside',
        'delivery_days_outside',
        'contact_phone',
        'contact_email',
        'website',
        'tracking_url_template',
        'is_active',
    ];

    protected $casts = [
        'base_charge' => 'decimal:2',
        'inside_dhaka_charge' => 'decimal:2',
        'outside_dhaka_charge' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function specialOrders()
    {
        return $this->hasMany(SpecialOrder::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper method to get appropriate charge based on location
    public function getChargeForLocation($isInsideDhaka)
    {
        return $isInsideDhaka ? $this->inside_dhaka_charge : $this->outside_dhaka_charge;
    }

    // Helper method to get delivery days based on location
    public function getDeliveryDaysForLocation($isInsideDhaka)
    {
        return $isInsideDhaka ? $this->delivery_days_inside : $this->delivery_days_outside;
    }
}
