<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model
{
    public $table = "user_languages";

    public function languageLevel(){
        return $this->belongsTo('App\Models\LanguageLevel');
    }

    public function language(){
        return $this->belongsTo('App\Models\Language');
    }

}
