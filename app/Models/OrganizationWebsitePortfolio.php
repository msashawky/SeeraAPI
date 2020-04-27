<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationWebsitePortfolio extends Model
{
    public $table = "organization_website_portfolios";
    protected $fillable = ['organization_website_id', 'name_ar', 'name_en', 'image'];

    public function organizationWebsite(){
        return $this->belongsTo('App\Models\OrganizationWebsite');
    }
}
