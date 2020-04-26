<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationWebsiteTeam extends Model
{
    public $table = "organization_website_teams";
    protected $fillable = ['organization_website_id','name_ar', 'name_en', 'job_title_ar', 'job_title_en', 'facebook',
        'twitter', 'linkedin', 'photo'];

    public function organizationWebsite(){
        return $this->belongsTo('App\Models\OrganizationWebsite');
    }
}
