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
    $router->get('/{website_id}/mobiles', 'OrganizationWebsiteController@websiteMobiles');
    $router->get('/{website_id}/services', 'OrganizationWebsiteController@websiteServices');
    $router->get('/{website_id}/portfolio', 'OrganizationWebsiteController@websitePortfolio');
    $router->get('/{website_id}/team', 'OrganizationWebsiteController@websiteTeam');
    $router->post('/{user_id}/contact', 'OrganizationWebsiteController@contact');
});
$router->group(['middleware' => ['jwt.auth']], function () use ($router) {

    $router->post('changePassword', 'AuthController@changePassword');






//Dashboard
    $router->group(['prefix' => 'dashboardApi'], function () use ($router) {
        $router->post('/user/{user_id}/update', 'UserController@updateUser');

        //Personal Website Dashboard
        $router->group(['prefix' => 'personalSite'], function () use ($router) {
            $router->post('/{user_id}/update', 'PersonalWebsiteController@updateWebsite');
            //Educations
            $router->get('educationDegrees', 'PersonalWebsiteController@educationDegrees');
            $router->post('userEducation/create', 'PersonalWebsiteController@createEducation');
            $router->post('userEducation/{id}/update', 'PersonalWebsiteController@UpdateEducation');
            $router->delete('userEducation/delete', 'PersonalWebsiteController@deleteEducation');
            //Languages
            $router->get('languages', 'PersonalWebsiteController@languages');
            $router->get('languageLevels', 'PersonalWebsiteController@languageLevels');
            $router->post('userLanguage/create', 'PersonalWebsiteController@createLanguage');
            $router->delete('userLanguage/delete', 'PersonalWebsiteController@deleteLanguage');
            //Skills
            $router->post('userSkill/create', 'PersonalWebsiteController@createSkill');
            $router->post('userSkill/{id}/update', 'PersonalWebsiteController@updateSkill');
            $router->delete('userSkill/delete', 'PersonalWebsiteController@deleteSkill');
            //Career
            $router->post('userCareer/create', 'PersonalWebsiteController@createCareer');
            $router->post('userCareer/{id}/update', 'PersonalWebsiteController@updateCareer');
            $router->delete('userCareer/delete', 'PersonalWebsiteController@deleteCareer');
            //Project
            $router->post('userProject/create', 'PersonalWebsiteController@createProject');
            $router->post('userProject/{id}/update', 'PersonalWebsiteController@updateProject');
            $router->delete('userProject/delete', 'PersonalWebsiteController@deleteProject');
        });

        //Organization Website Dashboard
        $router->group(['prefix' => 'organizationSite'], function () use ($router) {
            $router->post('{id}/update', 'OrganizationWebsiteController@updateWebsite');
            //Services
            $router->post('service/create', 'OrganizationWebsiteController@createService');
            $router->post('service/{id}/update', 'OrganizationWebsiteController@updateService');
            $router->delete('service/delete', 'OrganizationWebsiteController@deleteService');
            //Team Member
            $router->post('teamMember/create', 'OrganizationWebsiteController@createTeam');
            $router->post('teamMember/{id}/update', 'OrganizationWebsiteController@updateTeam');
            $router->delete('teamMember/delete', 'OrganizationWebsiteController@deleteTeam');

            //Portfolio
            $router->post('portfolio/create', 'OrganizationWebsiteController@createPortfolio');
            $router->post('portfolio/{id}/update', 'OrganizationWebsiteController@updatePortfolio');
            $router->delete('portfolio/delete', 'OrganizationWebsiteController@deletePortfolio');

        });

        $router->group(['prefix' => 'admin'], function () use ($router) {
            $router->get('personalWebsites/count', 'AdminController@personalWebsitesCount');
            $router->get('organizationWebsites/count', 'AdminController@organizationWebsitesCount');
            $router->get('newsletters/count', 'AdminController@newslettersCount');
            $router->get('infoWebsite/newsletters', 'AdminController@newsletters');
            $router->get('infoWebsite/personalWebsites', 'AdminController@personalWebsites');
            $router->get('infoWebsite/organizationWebsites', 'AdminController@organizationWebsites');

            $router->post('infoWebsite/update', 'AdminController@updateWebsite');

        });


    });
//Domains


    //CurrentUser
    $router->post('/currentUser', 'AuthController@currentUser');
});

$router->group(['prefix' => 'domains'], function () use ($router) {
    $router->post('/normalDomainCheck', 'InfoWebsiteController@normalDomainCheck');
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

