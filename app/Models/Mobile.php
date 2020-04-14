<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobile extends Model
{
    public $table = "mobiles";
    protected $fillable = ['user_id','mobile_number'];

    public function user(){
        $this->belongsTo('App\Models\User');
    }
}
