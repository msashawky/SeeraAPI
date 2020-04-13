<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LanguageLevel extends Model
{
    public $table = "language_levels";

    public function userLanguage(){
        return $this->hasOne('App\Models\UserLanguage');
    }
}
