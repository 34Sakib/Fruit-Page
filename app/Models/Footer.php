<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'logo',
        'description',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'youtube_url',
        'linkedin_url',
        'address',
        'phone',
        'email',
        'copyright_text',
        'status'
    ];

    /**
     * Get the URL to the logo.
     *
     * @return string
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return asset('images/default-logo.png');
    }

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the active footer
     */
    public static function getActive()
    {
        return self::where('status', true)->first();
    }
}
