<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $table = "payments";
    protected $fillable = ['user_id','money_amount', 'paid', 'paid_at'];
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}
