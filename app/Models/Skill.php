<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public $table = "skills";
    protected $fillable = ['user_id', 'skill'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}
