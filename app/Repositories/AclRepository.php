<?php

namespace App\Repositories;


use App\Interfaces\AclRepositoryInterface;

use App\Traits\ApiResponseTrait;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\ExpiredException;
use Exception;
use Illuminate\Support\Str;

class AclRepository implements AclRepositoryInterface
{

    use ApiResponseTrait;
    //valid for one hour 60 * 60
    static $offset = ((10 * 24) * (60 * 60));

    protected $user;


    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function authenticateUser(Request $request)
    {
        // Find the user by email
        $user = $this->user->where('email', $request->input('email'))->first();

        if (!$user) {
            $error = 'Email does not exist.';
            return $this->notFoundResponse($error);
        }

        // Verify the password and generate the token
        if (Hash::check($request->input('password'), $user->password)) {

            $token = jwt($user);


            return $this->apiResponse([ 'token' => $token, 'code' => $user->code,
                'name_en' => $user->name_en, 'name_ar' => $user->name_ar, 'photo' => $user->photo]);

        }
        // Bad Request response wrong password

        $error = 'please check your credentials';
        return $this->unKnowError($error);
    }


    //register user init only
    public function storeUser(Request $request)
    {
        $input = $request->all();

        $input['password'] = Hash::make($input['password']);
        //the idea of creation code
        $user = $this->user->create($input);

        //type of users
        //...

        if ($user) {
            $input['user_id'] = $user->id;

//            if ($request->userType == 'school') {
//
//                $this->school->create($input);
//            }

            $token = jwt($user);

            //for testing return token if sms code api get make change status to activate
            return $this->apiResponse(['token' => $token,
                'name_en' => $user->name_en, 'email' => $user->email], null, 201);
        }
        return $this->unKnowError('error while creating');
    }


    public function changePassword(Request $request)
    {
        $user = decodeUser($request->bearerToken()); //get the token from header
        // Verify the password and generate the token
        if (Hash::check($request->input('oldPassword'), $user->password)) {
            $input['password'] = Hash::make($request->get('newPassword'));

            if ($user->update($input)) {

                $token = jwt($user);
                return $this->apiResponse(['token' => $token], null, 200);
            }
        }

        return $this->unKnowError('please check your password');
    }

    public function refreshToken($token)
    {
        try {
            JWT::decode($token, env('JWT_SECRET'), ['HS256']);
            //TODO: do something if exception is not fired
        } catch (ExpiredException $e) {
            JWT::$leeway = 720000;
            $decoded = (array)JWT::decode($token, env('JWT_SECRET'), ['HS256']);
            // dd($decoded);
            // TODO: test if token is blacklisted

            $decoded['iat'] = time();

            //for along time
            //$decoded['exp'] = time() + self::$offset;

            //for 1 minute for test
            $decoded['exp'] = time() + 10;

            //success expired token and return new token
            return $this->apiResponse(JWT::encode($decoded, env('JWT_SECRET')));
        } catch (Exception $e) {
            return $this->unauthorizedResponse('ex token provided is incorrect.');
        }
        return $this->unauthorizedResponse('token provided is incorrect.');
    }

    public function validateLogin(Request $request)
    {
        return $this->apiValidation($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

    }

    public function validateUserRegister(Request $request)
    {
        return $this->apiValidation($request, [
            'email' => 'required|email|unique:users,email',
            'name_ar' => 'required',
            'name_en' => 'required',
            'password' => 'required',
            'date_of_birth' => 'date_format:Y-m-d|before:"2015-12-31"',
//            'gender' => 'required',
//            'userType' => 'required|in:school,training_center,instructor,parents,student,teacher',
        ]);
    }


        public function validateChangePassword(Request $request)
    {
        return $this->apiValidation($request, [
            'oldPassword' => 'required',
            'newPassword' => 'required',
        ]);
    }

}
