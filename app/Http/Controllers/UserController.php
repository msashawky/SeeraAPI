<?php

namespace App\Http\Controllers;
use App\Http\Resources\UserEducationsResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Http\Resources\UserDataResource;
use App\Http\Resources\UserCareersResource;
use App\Http\Resources\UserSkillsResource;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function userData($domain){
        $data = $this->userRepository->getUserData($domain);
        if($data)
            return $this->apiResponse(UserDataResource::make($data));
        return $this->notFoundResponse("user not found");
    }

    public function userCareers($user_id){
        $careers = $this->userRepository->getUserCareers($user_id);
        if(count($careers) > 0)
            return $this->apiResponse(UserCareersResource::collection($careers));
        return $this->notFoundResponse("careers not found");
    }

    public function userEducations($user_id){
        $educations = $this->userRepository->getUserEducations($user_id);
        if(count($educations) > 0)
            return $this->apiResponse(UserEducationsResource::collection($educations));
        return $this->notFoundResponse("educations not found");
    }

    public function userSkills($user_id){
        $skills = $this->userRepository->getUserSkills($user_id);
        if(count($skills) > 0)
            return $this->apiResponse(UserSkillsResource::collection($skills));
        return $this->notFoundResponse("skills not found");
    }

    public function contact(Request $request, $user_id){
        $validation = $this->userRepository->validateContactFormData($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }

//        $contact =
            $this->userRepository->sendContactForm($request, $user_id);
//
//        if ($contact) {
//
//            return $this->apiResponse(new PostResource($post));
//        }
//        return $this->unKnowError("error while creating the post");
    }
}
