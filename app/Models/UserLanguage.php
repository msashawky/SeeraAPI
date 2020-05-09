<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model
{
    public $table = "user_languages";
    protected $fillable = ['user_id', 'language_id', 'language_level_id'];

    public function languageLevel(){
        return $this->belongsTo('App\Models\LanguageLevel');
    }

    public function language(){
        return $this->belongsTo('App\Models\Language');
    }

}
