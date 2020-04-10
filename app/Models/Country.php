<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $table = "countries";
    protected $fillable = ['name_en','name_ar'];

    public function users(){
        $this->hasMany('App\Models\User');
    }
}
