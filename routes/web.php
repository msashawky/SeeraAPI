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
$router->get('countries', 'UserController@countries');


//Website
$router->group(['prefix' => 'websiteApi'], function () use ($router) {
    $router->get('/{domain}', 'UserController@userData');
    $router->get('/{domain}/mobiles', 'UserController@userMobiles');
    $router->get('/{user_id}/careers', 'UserController@userCareers');
    $router->get('/{user_id}/educations', 'UserController@userEducations');
    $router->get('/{user_id}/skills', 'UserController@userSkills');
    $router->get('/{user_id}/languages', 'UserController@userLanguages');
    $router->get('/{user_id}/projects', 'UserController@userProjects');
    $router->get('/{user_id}/projects/count', 'UserController@userProjectsCount');
    $router->post('/{user_id}/contact', 'UserController@contact');
});

//Info Website
$router->group(['prefix' => 'infowebsiteApi'], function () use ($router) {
    $router->get('/websiteContent', 'InfoWebsiteController@infoWebsiteContent');
    $router->post('/websiteContent/create', 'InfoWebsiteController@create');
    $router->post('/websiteContent/update', 'InfoWebsiteController@update');
    $router->get('/websites/count', 'InfoWebsiteController@websitesCount');
    $router->post('/newsletter/create', 'InfoWebsiteController@createNewsletter');
    $router->post('/contact', 'InfoWebsiteController@contact');
});

//Organization Website
$router->group(['prefix' => 'organizationWebsiteApi'], function () use ($router) {
    $router->get('/{domain}', 'OrganizationWebsiteController@websiteData');
    $router->get('/{domain}/mobiles', 'OrganizationWebsiteController@userMobiles');
    $router->get('/{user_id}/projects', 'OrganizationWebsiteController@websiteProjects');
    $router->get('/{user_id}/projects/count', 'OrganizationWebsiteController@websiteProjectsCount');
    $router->post('/{user_id}/contact', 'OrganizationWebsiteController@contact');
});
$router->group(['middleware' => ['jwt.auth']], function () use ($router) {

    $router->post('changePassword', 'AuthController@changePassword');






//Dashboard
    $router->group(['prefix' => 'dashboardApi'], function () use ($router) {
        $router->post('/user/{user_id}/update', 'UserController@updateUser');
        $router->post('/personalSite/{user_id}/update', 'PersonalWebsiteController@updateWebsite');

        //Educations
        $router->get('personalSite/educationDegrees', 'PersonalWebsiteController@educationDegrees');
        $router->post('personalSite/userEducation/create', 'PersonalWebsiteController@createEducation');
        $router->post('personalSite/userEducation/{id}/update', 'PersonalWebsiteController@UpdateEducation');
        $router->delete('personalSite/userEducation/delete', 'PersonalWebsiteController@deleteEducation');
        //Languages
        $router->get('/personalSite/languages', 'PersonalWebsiteController@languages');
        $router->get('/personalSite/languageLevels', 'PersonalWebsiteController@languageLevels');
        $router->post('/personalSite/userLanguage/create', 'PersonalWebsiteController@createLanguage');
        $router->delete('/personalSite/userLanguage/delete', 'PersonalWebsiteController@deleteLanguage');

        //Skills
        $router->post('/personalSite/userSkill/create', 'PersonalWebsiteController@createSkill');
        $router->post('/personalSite/userSkill/{id}/update', 'PersonalWebsiteController@updateSkill');
        $router->delete('/personalSite/userSkill/delete', 'PersonalWebsiteController@deleteSkill');

        //Career
        $router->post('/personalSite/userCareer/create', 'PersonalWebsiteController@createCareer');
        $router->post('/personalSite/userCareer/{id}/update', 'PersonalWebsiteController@updateCareer');
        $router->delete('/personalSite/userCareer/delete', 'PersonalWebsiteController@deleteCareer');

        //Project
        $router->post('/personalSite/userProject/create', 'PersonalWebsiteController@createProject');
        $router->post('/personalSite/userProject/{id}/update', 'PersonalWebsiteController@updateProject');
        $router->delete('/personalSite/userProject/delete', 'PersonalWebsiteController@deleteProject');

    });
//Domains
    $router->group(['prefix' => 'domains'], function () use ($router) {
        $router->post('/normalDomainCheck', 'InfoWebsiteController@normalDomainCheck');
    });

    //CurrentUser
    $router->post('/currentUser', 'AuthController@currentUser');
});


#All Auth
$router->group(['prefix' => 'auth'], function () use ($router) {

    $router->post('register', 'AuthController@userRegister');
    $router->get('/user/activation/{token}', 'AuthController@activateUser');

//    $router->post('login/facebook', 'AuthController@loginFacebook');


    $router->post('login', 'AuthController@loginUser');


    $router->post('refresh', 'AuthController@refresh');


    //need to review http type and middleware
//    $router->get('logout', 'AuthController@logout');


    /*start forget password */
    //need to change post after get third party sms
    $router->post('forgetPassword', 'AuthController@postForgetPassword');
    /*end forget password */


});

