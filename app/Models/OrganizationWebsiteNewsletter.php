<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationWebsiteNewsletter extends Model
{
    public $table = "organization_website_newsletters";
    protected $fillable = ['organization_website_id','email'];

    public function organizationWebsite(){
        return $this->belongsTo('App\Models\OrganizationWebsite');
    }
}
