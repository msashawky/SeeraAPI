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
use App\Models\Language;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\ExpiredException;
use Exception;
use Illuminate\Support\Str;

class PersonalWebsiteRepository
{

    use ApiResponseTrait;
    //valid for one hour 60 * 60
    static $offset = ((10 * 24) * (60 * 60));

    private $user;
    private $career;
    private $userEducation;
    private $skill;
    private $userLanguage;
    private $project;
    private $mobile;
    private $website;
    private $language;
    private $languageLevel;
    private $degree;


    public function __construct(User $user, Career $career, UserEducation $userEducation, Skill $skill, UserLanguage $userLanguage,
Project $project, Mobile $mobile, Website $website, Language $language, LanguageLevel $languageLevel, EducationDegree $degree)
    {
        $this->user = $user;
        $this->career = $career;
        $this->userEducation = $userEducation;
        $this->skill = $skill;
        $this->userLanguage = $userLanguage;
        $this->project = $project;
        $this->mobile = $mobile;
        $this->website = $website;
        $this->language = $language;
        $this->languageLevel = $languageLevel;
        $this->degree = $degree;
    }




    public function updateWebsiteInfo(Request $request, $user_id){
        return $this->website->where('user_id', $user_id)->update($request->all());
    }

    public function validateEditWebsite(Request $request){
        return $this->apiValidation($request, [
            'website_name_ar' => 'required|min:3|max:100',
            'website_name_en' => 'required|min:3|max:100',
            'domain' => 'required',
            'domain_type' => 'required',
            'facebook' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)facebook\.com\/([a-zA-Z0-9_]*)$/',
            'twitter' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)twitter\.com\/([a-zA-Z0-9_]*)$/',
            'linkedin' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)linkedin\.com\/([a-zA-Z0-9_]*)$/',
            'youtube' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)youtube\.com\/([a-zA-Z0-9_]*)$/',
            'google_plus' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)google\.com\/([a-zA-Z0-9_]*)$/',
            'behance' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)behance\.com\/([a-zA-Z0-9_]*)$/',
            'instagram' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)instagram\.com\/([a-zA-Z0-9_]*)$/',
            'pinterest' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)pinterest\.com\/([a-zA-Z0-9_]*)$/',
            'vimeo' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)vimeo\.com\/([a-zA-Z0-9_]*)$/',
        ]);
    }


    //Education
    public function getEducationDegrees(){
        return $this->degree->all();
    }
    public function createWebsiteEducation(Request $request){
        return $this->userEducation->create($request->all());
    }

    public function updateWebsiteEducation(Request $request){
        return $this->userEducation->where('id', $request->id)->update($request->all());
    }

    public function validateCreateWebsiteEducation(Request $request){
        return $this->apiValidation($request, [
            'user_id' => 'required',
            'degree_id' => 'required',
            'school' => 'required|min:2|max:200',
            'started_year' => 'required',
            'graduation_year' => 'nullable',
            'education_status' => 'required'
        ]);
    }

    public function deleteWebsiteEducation(Request $request){
        $this->userEducation->where('id', $request->id)->delete();
    }


    //Languages
    public function getLanguages(){
        return $this->language->all();
    }
    public function getLanguageLevels(){
        return $this->languageLevel->all();
    }

    public function checkWebsiteLanguage($user_id, $language_id){
        return $this->userLanguage->where('user_id', $user_id)->where('language_id', $language_id)->first();
    }

    public function createWebsiteLanguage(Request $request){
        if($this->checkWebsiteLanguage($request->user_id, $request->language_id) == null)
            return $this->userLanguage->create($request->all());
    }

    public function validateCreateWebsiteLanguage(Request $request){
        return $this->apiValidation($request, [
            'user_id' => 'required',
            'language_id' => 'required',
            'language_level_id' => 'required',
        ]);
    }

    public function deleteWebsiteLanguage(Request $request){
        $this->userLanguage->where('id', $request->id)->delete();
    }


    //Skills
    public function createWebsiteSkill(Request $request){
        return $this->skill->create($request->all());
    }
    public function validateCreateWebsiteSkill(Request $request){
        return $this->apiValidation($request, [
            'user_id' => 'required',
            'skill' => 'required',
            'skill_percentage' => 'required',
        ]);
    }
    public function updateWebsiteSkill(Request $request){
        return $this->skill->where('id', $request->id)->update($request->all());
    }
    public function validateUpdateWebsiteSkill(Request $request){
        return $this->apiValidation($request, [
            'id' => 'required', //userSkill id
            'skill' => 'required',
            'skill_percentage' => 'required',
        ]);
    }

    public function deleteWebsiteskill(Request $request){
        $this->skill->where('id', $request->id)->delete();
    }


    //Career
    public function createWebsiteCareer(Request $request){
        return $this->career->create($request->all());
    }
    public function validateCreateWebsiteCareer(Request $request){
        return $this->apiValidation($request, [
            'user_id' => 'required',
            'title_ar' => 'required|min:3|max:200',
            'title_en' => 'required|min:3|max:200',
            'employer' => 'required|max:200',
            'start_date' => 'required',
            'end_date' => 'required',
            'employment_status' => 'required',
            'role' => 'required|min:2|max:200',
            'description_ar' => 'nullable| max:500',
            'description_en' => 'nullable| max:500'
        ]);
    }
    public function updateWebsiteCareer(Request $request){
        return $this->career->where('id', $request->id)->update($request->all());
    }

    public function deleteWebsiteCareer(Request $request){
        $this->career->where('id', $request->id)->delete();
    }


    //Project
    public function createWebsiteProject(Request $request){
        return $this->project->create($request->all());
    }
    public function validateCreateWebsiteProject(Request $request){
        return $this->apiValidation($request, [
            'user_id' => 'required',
            'project_title' => 'required|min:3|max:200',
            'project_description' => 'required|min:3|max:500',
        ]);
    }
    public function updateWebsiteProject(Request $request){
        return $this->project->where('id', $request->id)->update($request->all());
    }

    public function deleteWebsiteProject(Request $request){
        $this->project->where('id', $request->id)->delete();
    }


}
