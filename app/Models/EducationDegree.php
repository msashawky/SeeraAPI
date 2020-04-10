<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationDegree extends Model
{
    public $table = "education_degrees";
    protected $fillable = ['name_en', 'name_ar'];

    public function career(){
        return $this->hasMany('App\Models\Career');
    }
}
