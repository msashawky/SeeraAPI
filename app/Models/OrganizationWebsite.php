<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationWebsite extends Model
{
    public $table = "organization_websites";
    protected $fillable = ['user_id', 'website_name_ar', 'website_name_en', 'domain', 'domain_type', 'about_us_ar',
        'about_us_en', 'address_ar', 'address_en', 'email', 'background_image', 'number_of_visits', 'status'];


    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function organizationWebsiteServices(){
        return $this->hasMany('App\Models\OrganizationWebsiteService');
    }
    public function organizationWebsiteNewsletters(){
        return $this->hasMany('App\Models\OrganizationWebsiteNewsletter');
    }
    public function organizationWebsitePortfolios(){
        return $this->hasMany('App\Models\OrganizationWebsitePortfolio');
    }
    public function organizationWebsiteTeam(){
        return $this->hasMany('App\Models\OrganizationWebsiteTeam');
    }
}
