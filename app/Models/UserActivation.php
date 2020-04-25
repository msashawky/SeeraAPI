<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivation extends Model
{
    public $table = "user_activations";

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
