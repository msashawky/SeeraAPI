<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
//$router->get('/key', function() {
//    return \Illuminate\Support\Str::random(32);
//});

//
//$router->group(['prefix' => 'api'], function () use ($router) {
//    $router->get('/', function(){
//        return response()->json(['test']);
//    });
//    // Matches "/api/register
//    $router->post('register', 'AuthController@register');
//    // Matches "/api/login
//    $router->post('login', 'AuthController@login');
//
//    // Matches "/api/profile
//    $router->get('profile', 'UserController@profile');
//
//    // Matches "/api/users/1
//    //get one user by id
//    $router->get('users/{id}', 'UserController@singleUser');
//
//    // Matches "/api/users
//    $router->get('users', 'UserController@allUsers');
//});
//

#All Auth
$router->group(['prefix' => 'auth'], function () use ($router) {

    $router->post('register', 'AuthController@userRegister');

//    $router->post('login/facebook', 'AuthController@loginFacebook');


    $router->post('login', 'AuthController@loginUser');


    $router->post('refresh', 'AuthController@refresh');


    //need to review http type and middleware
//    $router->get('logout', 'AuthController@logout');


    /*start forget password */
    //need to change post after get third party sms
    $router->post('forgetPassword', 'AuthController@postForgetPassword');
    /*end forget password */

    $router->group(['middleware' => ['jwt.auth']], function () use ($router) {

        $router->post('changePassword', 'AuthController@changePassword');
    });
});

