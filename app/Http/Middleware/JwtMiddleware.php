<?php
namespace App\Http\Middleware;
use App\Traits\ApiResponseTrait;
use Closure;
use Exception;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
class JwtMiddleware
{

    use ApiResponseTrait;

    public function handle($request, Closure $next, $guard = null)
    {
        //$token = $request->get('token'); as query parameter
        // work with barer token in header
        $token = $request->bearerToken();

        if(!$token) {
            // Unauthorized response if token not there
            $error = "Token not provided.";
            return $this->unauthorizedResponse($error);
        }
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {

           return $this->unauthorizedResponse('Provided token is expired.');

        } catch(Exception $e) {

            return $this->unauthorizedResponse('token provided is incorrect.');
        }
        $user = User::find($credentials->sub);


        //check if user logout or change his password time with seconds
//        if(!($credentials->iat > strtotime($user->last_logged_out))){
//            $error = "Please login";
//            return $this->unauthorizedResponse($error);
//        }

        // Now let's put the user in the request class so that you can grab it from there
        $request->auth = $user;
        return $next($request);
    }
}
