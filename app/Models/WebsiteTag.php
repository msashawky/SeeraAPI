<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteTag extends Model
{
    public $table = "website_tags";
    protected $fillable = ['website_id','tag'];

    public function website(){
        return $this->belongsTo('App\Models\Website');
    }
}
