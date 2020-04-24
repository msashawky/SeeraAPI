<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsLetter extends Model
{
    public $table = "news_letters";
    protected $fillable = ['email'];
}
