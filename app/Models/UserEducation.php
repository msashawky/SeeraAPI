<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEducation extends Model
{
    public $table = "user_educations";
    protected $fillable = ['user_id', 'degree_id', 'school', 'started_year', 'graduation_year', 'education_status'];

    public function educationDegree(){
        return $this->belongsTo('App\Models\EducationDegree', 'degree_id');
    }
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
