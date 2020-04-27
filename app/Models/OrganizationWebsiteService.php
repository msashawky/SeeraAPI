<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationWebsiteService extends Model
{
    public $table = "organization_website_services";
    protected $fillable = ['organization_website_id', 'name_ar', 'name_en', 'description_ar', 'description_en'];

    public function organizationWebsite(){
        return $this->belongsTo('App\Models\OrganizationWebsite');
    }
}
