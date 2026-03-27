<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_icon',
        'happy_customers',
        'deliveries_made',
        'local_farms',
        'years_excellence',
        'mission_title',
        'mission_subtitle',
        'feature1_title',
        'feature1_text',
        'feature1_icon',
        'feature2_title',
        'feature2_text',
        'feature2_icon',
        'feature3_title',
        'feature3_text',
        'feature3_icon',
        'team_title',
        'team_subtitle',
        'values_title',
        'values_subtitle',
        'value1_title',
        'value1_text',
        'value2_title',
        'value2_text',
        'value3_title',
        'value3_text',
        'cta_title',
        'cta_text',
        'cta_button_text',
        'cta_button_url',
        'cta_button_icon',
    ];

    public static function getContent()
    {
        return self::first();
    }
}
