<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'header_title',
        'header_subtitle',
        'header_icon',
        'email',
        'phone',
        'address',
        'email_hours',
        'phone_hours',
        'map_embed_url',
        'map_address',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Scope to get only active contact info
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Get the first active contact info
     */
    public static function getActive()
    {
        return static::active()->first();
    }
}
