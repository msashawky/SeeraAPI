<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoWebsiteContent extends Model
{
    public $table = "info_website_contents";
    protected $fillable = ['info_website_name_en','info_website_name_ar', 'info_website_url', 'logo', 'favicon',
        'about_us_ar', 'about_us_en', 'terms_and_conditions_ar', 'terms_and_conditions_en', 'privacy_policy_ar', 'privacy_policy_en',
        'facebook', 'twitter', 'instagram', 'youtube'];
}
