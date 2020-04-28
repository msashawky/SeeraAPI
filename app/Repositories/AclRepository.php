<?php

namespace App\Repositories;


use App\Interfaces\AclRepositoryInterface;

use App\Models\Website;
use App\Traits\ApiResponseTrait;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserActivation;
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
    protected $userActivation;


    public function __construct(User $user, UserActivation $userActivation)
    {
        $this->user = $user;
        $this->userActivation = $userActivation;
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
            $token = jwt($user);

            //create User Activation token/code
            $userActivation = new UserActivation();
            $userActivation->user_id = $input['user_id'];
            $userActivation->token = str_random(30);
            $userActivation->save();

            //Create not completed website
            $website = new Website();
            $website->user_id = $input['user_id'];
            $website->domain = $input['domain'];
            $website->domain_type = $input['domain_type'];
            $website->save();
            $activationToken = $input = $this->userActivation->orderBy('id', 'DESC')->value('token');
            $message = '<p><strong>Welcome Seera</strong> ,please Activate your Account:</p>'.'<a href="user/activation/'.$activationToken.'">Activate</a>';
            $headers = "Content-Type: text/html; charset=UTF-8\r\n";

//            mail($request->email,"Seera - Activation Code", $message, $headers);

            //for testing return token if sms code api get make change status to activate
            return $this->apiResponse(['token' => $token,
                'name_en' => $user->name_en, 'email' => $user->email], null, 201);
        }
        return $this->unKnowError('error while creating');
    }

    public function userActivation($token){
        $check = UserActivation::where('token', $token)->first();
        if(!is_null($check)) {
            $user = User::find($check->user_id);
            if($user->is_activated == 0){
                $user->is_activated = 1;
                $user->save();
                UserActivation::where('token', $token)->delete();
                return true;
            }
        }
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
            'username' => 'required|unique:users,username',
            'name_ar' => 'required',
            'name_en' => 'required',
            'password' => 'required',
            'date_of_birth' => 'date_format:Y-m-d|before:"2015-12-31"',
            'gender' => 'required',
            'userType' => 'required|in:admin,personal_website,organization_website',
            'domain' => 'required|min:3|max:100|alpha_dash',
            'domain_type' => 'required|in:normal,premium',
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
