<?php

namespace App\Http\Controllers;

use App\Http\Resources\CurrentUserDataResource;
use App\Http\Resources\CurrentUserOrganizationDataResource;
use App\Http\Resources\CurrentUserPersonalWebsiteDataResource;
use App\Repositories\AclRepository;
use Illuminate\Http\Request;


class AuthController extends Controller
{

    private $aclRepository;


    public function __construct(AclRepository $aclRepository)
    {
        $this->aclRepository = $aclRepository;
    }

    public function loginUser(Request $request)
    {

        $validation = $this->aclRepository->validateLogin($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }

        return $this->aclRepository->authenticateUser($request);

    }


    public function userRegister(Request $request)
    {
        $validation = $this->aclRepository->validateUserRegister($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }

        return $this->aclRepository->storeUser($request);
    }

    public function activateUser($token){
        $activated = $this->aclRepository->userActivation($token);
        if($activated)
            return response()->json(['data' => 'User has been activated']);
        return $this->unKnowError("error while activating user");

    }

    public function changePassword(Request $request)
    {
        $validation = $this->aclRepository->validateChangePassword($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }

        return $this->aclRepository->changePassword($request);
    }


    public function refresh(Request $request)
    {
        $token = $request->token;
        return $this->aclRepository->refreshToken($token);
    }


    public function postForgetPassword(Request $request)
    {
        return $this->aclRepository->forgetPasswordCodeActivation($request);

    }

    public function currentUser(Request $request){
        $user = $this->aclRepository->getCurrentUser($request);
        if($user->userType == 'personal_website'){
            return $this->apiResponse(CurrentUserPersonalWebsiteDataResource::make($user));}
        elseif($user->userType == 'personal_website'){
            return $this->apiResponse(CurrentUserOrganizationDataResource::make($user));}
        else{
            return $this->apiResponse(CurrentUserDataResource::make($user));}

    }
}
