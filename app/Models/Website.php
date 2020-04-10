<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    public $table = "websites";
    protected $fillable = ['user_id', 'website_name_en', 'website_name_ar', 'domain', 'domain_type', 'background_image'];

    public function tags(){
        return $this->hasMany('App\Models\WebsiteTag');
    }
}
