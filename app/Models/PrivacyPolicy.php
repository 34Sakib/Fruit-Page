<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'introduction',
        'personal_info',
        'auto_collected_info',
        'information_usage',
        'data_sharing',
        'data_security',
        'cookies_tracking',
        'privacy_rights',
        'third_party_links',
        'children_privacy',
        'policy_changes',
        'contact_email',
        'contact_phone',
        'contact_address',
        'is_active'
    ];
}
