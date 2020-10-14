<?php

namespace App\Repositories;


use App\Interfaces\UserRepositoryInterface;

use App\Traits\ApiResponseTrait;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Career;
use App\Models\UserEducation;
use App\Models\EducationDegree;
use App\Models\Skill;
use App\Models\UserLanguage;
use App\Models\LanguageLevel;
use App\Models\Project;
use App\Models\Mobile;
use App\Models\Website;
use App\Models\InfoWebsiteContent;
use App\Models\OrganizationWebsite;
use App\Models\Language;
use App\Models\NewsLetter;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\ExpiredException;
use Exception;
use Illuminate\Support\Str;

class AdminRepository
{

    use ApiResponseTrait;


    private $user;
    private $career;
    private $userEducation;
    private $skill;
    private $userLanguage;
    private $project;
    private $mobile;
    private $website;
    private $infoWebsite;
    private $language;
    private $languageLevel;
    private $degree;
    private $organizationWebsite;
    private $newsletter;


    public function __construct(User $user, Career $career, UserEducation $userEducation, Skill $skill, UserLanguage $userLanguage,
Project $project, Mobile $mobile, Website $website, Language $language, LanguageLevel $languageLevel, EducationDegree $degree,
 OrganizationWebsite $organizationWebsite, NewsLetter $newsLetter, InfoWebsiteContent $infoWebsite)
    {
        $this->user = $user;
        $this->career = $career;
        $this->userEducation = $userEducation;
        $this->skill = $skill;
        $this->userLanguage = $userLanguage;
        $this->project = $project;
        $this->mobile = $mobile;
        $this->website = $website;
        $this->infoWebsite = $infoWebsite;
        $this->language = $language;
        $this->languageLevel = $languageLevel;
        $this->degree = $degree;
        $this->organizationWebsite = $organizationWebsite;
        $this->newsletter = $newsLetter;
    }




    public function getPersonalWebsitesCount(){
        return $this->website->count();
    }
    public function getOrganizationWebsitesCount(){
        return $this->organizationWebsite->count();
    }
    public function getNewsletterCount(){
        return $this->newsletter->count();
    }
    public function getNewsletters(){
        return $this->newsletter->get();
    }
    public function getPersonalWebsites(){
        return $this->website->with('user')->get();
    }
    public function getOrganizationWebsites(){
        return $this->organizationWebsite->with('user')->get();
    }

    public function updateInfoContent(Request $request){
        $currentUser = $request->auth;
        if($currentUser->userType == "admin")
            return $this->infoWebsite->where('id', 1)->update($request->all());
    }

    public function validateUpdateWebsite(Request $request){
        return $this->apiValidation($request, [
            'info_website_name_ar' => 'nullable|min:3|max:100',
            'info_website_name_en' => 'nullable|min:3|max:100',
//            'phone_number' => 'required',
//            'email' => 'required',
//            'info_website_url' => 'required',
//            'logo' => 'required',
//            'favicon' => 'required',
            'about_us_ar' => 'nullable|min:5|max:1000',
            'about_us_en' => 'nullable|min:5|max:1000',
            'address_ar' => 'nullable|min:5|max:1000',
            'address_en' => 'nullable|min:5|max:1000',
            'terms_and_conditions_ar' => 'nullable|min:5|max:1000',
            'terms_and_conditions_en' => 'nullable|min:5|max:1000',
            'privacy_policy_ar' => 'nullable|min:5|max:1000',
            'privacy_policy_en' => 'nullable|min:5|max:1000',
            'facebook' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)facebook\.com\/([a-zA-Z0-9_]*)$/',
            'twitter' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)twitter\.com\/([a-zA-Z0-9_]*)$/',
            'youtube' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)youtube\.com\/([a-zA-Z0-9_]*)$/',
            'instagram' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)instagram\.com\/([a-zA-Z0-9_]*)$/',

        ]);
    }




}
