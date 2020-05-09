<?php

use App\Models\User;
use Firebase\JWT\JWT;
use Carbon\Carbon;

//handle config path for lumen
if (!function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param string $path
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }

}
/**
 * Create a new token.
 *
 * @param \App\User $user
 * @return string
 */

// generate tokens for users
function jwt(User $user)
{
    $payload = [
        'iss' => "seera-online-dev", // Issuer of the token "iss" => $service_account_email,
        'sub' => $user->id, // Subject of the token
        'iat' => time(), // Time when JWT was issued.
        //old time (60 * 60) for 1 hour
//           'exp' => time() + 60 * 15 //* 8// Expiration time valid for 1 minute
        'exp' => time() + ((30 * 24) * (60 * 60)) // Expiration time valid for 30 days
    ];

    // As you can see we are passing `JWT_SECRET` as the second parameter that will
    // be used to decode the token in the future.
    return JWT::encode($payload, env('JWT_SECRET'));
}


//decode token and get user data
function decodeUser($token)
{
    $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
    return User::find($credentials->sub);
}







