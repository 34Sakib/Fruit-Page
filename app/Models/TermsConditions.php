<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsConditions extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'introduction',
        'definitions',
        'acceptance_of_terms',
        'registration',
        'account_termination',
        'product_information',
        'order_processing',
        'pricing',
        'payment_methods',
        'delivery_areas',
        'delivery_time',
        'delivery_charges',
        'return_policy',
        'refund_process',
        'intellectual_property',
        'user_conduct',
        'limitation_of_liability',
        'termination',
        'changes_to_terms',
        'contact_email',
        'contact_phone',
        'contact_address',
        'is_active'
    ];
}
