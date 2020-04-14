<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = "users";
    protected $fillable = [
        'name_en','name_ar', 'email', 'username', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function country(){
        return $this->belongsTo('App\Models\Country', 'country_id');
    }
    public function website(){
        return $this->hasOne('App\Models\Website');
    }
    public function careers(){
        return $this->hasMany('App\Models\Career');
    }
    public function skills(){
        return $this->hasMany('App\Models\Skill');
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function languages(){
        return $this->belongsToMany('App\Models\Language');
    }
    public function projects(){
        return $this->hasMany('App\Models\Project');
    }
    public function userEducations(){
        return $this->hasMany('App\Models\UserEducation', 'user_id');
    }
    public function mobiles(){
        return $this->hasMany('App\Models\Mobile', 'user_id');
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
