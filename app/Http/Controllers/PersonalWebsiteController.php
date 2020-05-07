<?php

namespace App\Http\Controllers;

use App\Http\Resources\EducationDegreeResource;
use App\Http\Resources\LanguagesResource;
use App\Http\Resources\LanguageLevelsResource;
use Illuminate\Http\Request;
use App\Repositories\PersonalWebsiteRepository;



class PersonalWebsiteController extends Controller
{
    private $websiteRepository;

    public function __construct(PersonalWebsiteRepository $personalWebsiteRepository){
        $this->personalWebsiteRepository = $personalWebsiteRepository;
    }
    public function updateWebsite(Request $request, $user_id){
        $validation = $this->personalWebsiteRepository->validateEditWebsite($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }
        $updatedData = $this->personalWebsiteRepository->updateWebsiteInfo($request, $user_id);
        return $this->apiResponse($updatedData);
    }

    public function educationDegrees(){
        $degrees = $this->personalWebsiteRepository->getEducationDegrees();
        if($degrees)
            return $this->apiResponse(EducationDegreeResource::collection($degrees));
        $this->unKnowError("no Degrees Found");
    }

    public function createEducation(Request $request){
        $validation = $this->personalWebsiteRepository->validateCreateWebsiteEducation($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }
        $education = $this->personalWebsiteRepository->createWebsiteEducation($request);
        return $this->apiResponse($education);
    }
    public function updateEducation(Request $request){
        $validation = $this->personalWebsiteRepository->validateCreateWebsiteEducation($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }
        $education = $this->personalWebsiteRepository->updateWebsiteEducation($request);
        return $this->apiResponse($education);
    }
    public function deleteEducation(Request $request){
        return $this->personalWebsiteRepository->deleteWebsiteEducation($request);
    }

    public function languages(){
        $languages = $this->personalWebsiteRepository->getLanguages();
        if($languages)
            return $this->apiResponse(LanguagesResource::collection($languages));
        return $this->notFoundResponse("no languages found");
    }

    public function languagelevels(){
        $languagLevels = $this->personalWebsiteRepository->getLanguageLevels();
        if($languagLevels)
            return $this->apiResponse(LanguageLevelsResource::collection($languagLevels));
        return $this->notFoundResponse("no languages levels found");
    }

    public function createLanguage(Request $request){
        $validation = $this->personalWebsiteRepository->validateCreateWebsiteLanguage($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }
        $createdLanguage = $this->personalWebsiteRepository->createWebsiteLanguage($request);
        return $this->apiResponse($createdLanguage);
    }

    public function deleteLanguage(Request $request){
        return $this->personalWebsiteRepository->deleteWebsiteLanguage($request);
    }


    public function createSkill(Request $request){
        $validation = $this->personalWebsiteRepository->validateCreateWebsiteSkill($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }
        $skill = $this->personalWebsiteRepository->createWebsiteSkill($request);
        return $this->apiResponse($skill);

    }

    public function updateSkill(Request $request){
        $validation = $this->personalWebsiteRepository->validateUpdateWebsiteSkill($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }
        $skill = $this->personalWebsiteRepository->updateWebsiteSkill($request);
        return $this->apiResponse($skill);
    }
    public function deleteSkill(Request $request){
        return $this->personalWebsiteRepository->deleteWebsiteskill($request);
    }
}
