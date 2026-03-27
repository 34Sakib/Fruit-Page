<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        // Our Shipping Commitment
        'introduction',
        // Delivery Areas
        'current_coverage',
        'expansion_plans',
        // Delivery Timeframes
        'standard_delivery_time',
        'express_delivery_time',
        'scheduled_delivery',
        // Shipping Charges
        'standard_delivery_rates',
        'additional_services',
        // Order Processing
        'order_confirmation',
        'quality_assurance',
        'dispatch_process',
        // Packaging Standards
        'fresh_produce_packaging',
        'dairy_perishables_packaging',
        'packaged_goods_packaging',
        // Delivery Process
        'before_delivery',
        'during_delivery',
        'after_delivery',
        // Special Circumstances
        'weather_conditions',
        'product_unavailability',
        'failed_delivery_attempts',
        // International Shipping
        'international_shipping',
        // Shipping Support
        'shipping_hotline',
        'shipping_email',
        'support_hours',
        'live_chat',
        // Legacy fields for backward compatibility
        'delivery_areas',
        'delivery_time',
        'delivery_charges',
        'order_processing',
        'packaging_standards',
        'delivery_process',
        'special_circumstances',
        'contact_email',
        'contact_phone',
        'contact_address',
        'is_active'
    ];
}
