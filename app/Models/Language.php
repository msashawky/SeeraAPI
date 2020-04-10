<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public $table = "languages";
    protected $fillable = ['name_en','name_ar'];

    public function users(){
        $this->belongsToMany('App\Models\User');
    }
}
