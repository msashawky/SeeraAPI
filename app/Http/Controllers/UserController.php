<?php

namespace App\Http\Controllers;
use App\Http\Resources\CountriesResource;
use App\Http\Resources\UserEducationsResource;
use App\Http\Resources\UserLanguagesResource;
use App\Http\Resources\UserMobilesResource;
use App\Http\Resources\UserProjectsCountResource;
use App\Http\Resources\UserProjectsResource;
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

    public function userMobiles($user_id){
        $mobiles = $this->userRepository->getUserMobiles($user_id);
        if(count($mobiles) > 0)
            return $this->apiResponse(UserMobilesResource::collection($mobiles));
        return $this->notFoundResponse("careers not found");
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

    public function userLanguages($user_id){
        $languages = $this->userRepository->getUserLanguages($user_id);
        if(count($languages) > 0)
            return $this->apiResponse(UserLanguagesResource::collection($languages));
        return $this->notFoundResponse("languages not found");
    }

    public function userProjects($user_id){
        $projects = $this->userRepository->getUserProjects($user_id);
        if(count($projects) > 0)
            return $this->apiResponse(UserProjectsResource::collection($projects));
        return $this->notFoundResponse("languages not found");
    }

    public function userProjectsCount($user_id){
        $data = $this->userRepository->getUserProjectsCount($user_id);//dd($data);
        if($data)
            return response()->json(['projects_count' => $data]);//$this->apiResponse(UserProjectsCountResource::make($data));
        return $this->notFoundResponse("projects not found");
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

    public function updateUser(Request $request, $user_id){
        $validation = $this->userRepository->validateEditUser($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }
        $updatedData = $this->userRepository->updateUserData($request, $user_id);
        return $this->apiResponse($updatedData);
    }

    public function countries(){
        $countries = $this->userRepository->getAllCountries();
        if($countries)
            return $this->apiResponse(CountriesResource::collection($countries));
        return $this->notFoundResponse("no countries found");
    }
//    public function uploadImage(Request $request, $directory){
//        $currentUser = $request->auth;
//        $user_id= $currentUser->id;
//        return \response()->json(upload_single_photo($request->file('file'),'/images/upload_images/presonal_websites/'.$directory, $user_id),200);
//    }


}
