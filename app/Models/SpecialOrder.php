<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpecialOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'customer_name',
        'email',
        'phone',
        'address',
        'is_inside_dhaka',
        'category_id',
        'product_id',
        'product_name',
        'quantity',
        'notes',
        'delivery_charge',
        'status',
        'admin_notes',
        'final_price',
        'invoice_sent_at',
        'tracking_number',
        'courier_service_id',
        'courier_charge',
        'courier_tracking_number',
        'shipped_at',
    ];

    protected $casts = [
        'is_inside_dhaka' => 'boolean',
        'quantity' => 'decimal:2',
        'delivery_charge' => 'decimal:2',
        'final_price' => 'decimal:2',
        'courier_charge' => 'decimal:2',
        'invoice_sent_at' => 'datetime',
        'shipped_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function courierService()
    {
        return $this->belongsTo(CourierService::class);
    }

    public static function generateOrderNumber()
    {
        $latest = static::latest()->first();
        if (!$latest) {
            return 'SO' . date('Y') . '0001';
        }
        
        $number = intval(substr($latest->order_number, -4)) + 1;
        return 'SO' . date('Y') . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function getDeliveryChargeAttribute()
    {
        return $this->is_inside_dhaka ? 50 : 120;
    }

    public function getTotalPriceAttribute()
    {
        $price = $this->final_price ?? 0;
        $deliveryCharge = $this->delivery_charge ?? 0;
        $courierCharge = $this->courier_charge ?? 0;
        return $price + $deliveryCharge + $courierCharge;
    }

    public function sendInvoice()
    {
        $this->update(['invoice_sent_at' => now()]);
        
        // Send email notification
        \Mail::to($this->email)->send(new \App\Mail\SpecialOrderInvoice($this));
    }

    public function generateTrackingNumber()
    {
        return 'SO' . strtoupper(uniqid());
    }

    public function canBeTracked()
    {
        return !in_array($this->status, ['rejected']);
    }
}
