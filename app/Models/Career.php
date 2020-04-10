<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    public $table = "careers";
    protected $fillable = ['user_id', 'title_ar', 'title_en', 'employer', 'start_date', 'end_date', 'employment_status', 'role', 'description'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
