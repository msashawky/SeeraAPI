<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $table = "projects";
    protected $fillable = ['user_id', 'project_title', 'project_description'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
