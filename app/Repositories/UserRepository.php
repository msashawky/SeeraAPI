<?php

namespace App\Repositories;


use App\Interfaces\UserRepositoryInterface;

use App\Traits\ApiResponseTrait;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Career;
use App\Models\UserEducation;
use App\Models\Skill;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\ExpiredException;
use Exception;
use Illuminate\Support\Str;

class UserRepository implements UserRepositoryInterface
{

    use ApiResponseTrait;
    //valid for one hour 60 * 60
    static $offset = ((10 * 24) * (60 * 60));

    private $user;
    private $career;
    private $userEducation;
    private $skill;


    public function __construct(User $user, Career $career, UserEducation $userEducation, Skill $skill)
    {
        $this->user = $user;
        $this->career = $career;
        $this->userEducation = $userEducation;
        $this->skill = $skill;
    }

    public function getUserData($domain){
        return $this->user->where('username','LIKE', $domain)->with('country')->first();
    }
    public function getUserCareers($user_id){
        return $this->career->where('user_id', $user_id)->get();
    }

    public function getUserEducations($user_id){
        return $this->userEducation->where('user_id', $user_id)->with('educationDegree')->get();
    }

    public function getUserSkills($user_id){
        return $this->skill->where('user_id', $user_id)->get();
    }

    public function validateContactFormData(Request $request){
        return $this->apiValidation($request, [
            'name' => 'required|min:3|max:100',
            'email' => 'required|email|max:100',
            'message' => 'required|min:5|max:200',
            ]);
    }

    public function sendContactForm(Request $request, $user_id){
//        $data = decodeUser($request->bearerToken());
        $message = '<p><strong>Name: '.$request->name.'</strong><br> email:'.$request->email.'</p><br>'.'message: <p>'.$request->message.'</p>';
        $headers = "Content-Type: text/html; charset=UTF-8\r\n";
//        dd($request);
            mail($this->getUseById($user_id)->email,"Seera - Contact Form", $message, $headers);
    }


    public function getUseById($user_id){
        return $this->user->where('id', $user_id)->first();
    }

}
