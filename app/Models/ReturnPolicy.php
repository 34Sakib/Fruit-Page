<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        // Hero Section
        'hero_title',
        'hero_subtitle',
        // Introduction
        'introduction',
        // Return Eligibility
        'fresh_produce_eligibility',
        'dairy_perishables_eligibility',
        'packaged_foods_eligibility',
        'non_returnable_items',
        // Return Process
        'contact_customer_service',
        'documentation_required',
        'return_approval',
        'product_return_step',
        // Refund Options
        'full_refund',
        'store_credit',
        'product_exchange',
        // Special Circumstances
        'wrong_item_delivered',
        'quality_issues',
        'delivery_delays',
        // Return Timeframes
        'fresh_produce_timeframe',
        'fresh_produce_conditions',
        'dairy_timeframe',
        'dairy_conditions',
        'packaged_foods_timeframe',
        'packaged_foods_conditions',
        'wrong_items_timeframe',
        'wrong_items_conditions',
        // Customer Responsibilities
        'product_inspection',
        'return_preparation',
        'communication',
        // Return Support
        'return_hotline',
        'return_email',
        'support_hours',
        'live_chat',
        'whatsapp',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
