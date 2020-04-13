<?php
namespace App\Interfaces;

use Illuminate\Http\Request;

interface UserRepositoryInterface{
    public function getUserData($domain);
    public function getUserCareers($user_id);
    public function getUserEducations($user_id);
//    public function getUserSkills($user_id);


}
