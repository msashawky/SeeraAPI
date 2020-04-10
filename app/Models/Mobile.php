<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobile extends Model
{
    public $table = "mobiles";
    protected $fillable = ['user_id','modile_number'];

    public function users(){
        $this->belongsTo('App\Models\User');
    }
}
