<?php

namespace App\Http\Controllers;

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
}
