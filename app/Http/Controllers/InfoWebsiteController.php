<?php

namespace App\Http\Controllers;

use App\Http\Resources\InfoWebsite\NormalDomainCheckResource;
use App\Http\Resources\InfoWebsite\WebsiteNewslettertResource;
use Illuminate\Http\Request;
use App\Repositories\InfoWebsiteRepository;
use App\Http\Resources\InfoWebsite\InfoWebsiteContentResource;
use App\Http\Resources\InfoWebsite\WebsitesCountResource;

class InfoWebsiteController extends Controller
{
    private $infoWebsiteRepository;
    public function __construct(InfoWebsiteRepository $infoWebsiteRepository)
    {
        $this->infoWebsiteRepository = $infoWebsiteRepository;
    }

    public function infoWebsiteContent(){
        $content = $this->infoWebsiteRepository->getInfoWebsiteContent();
        if($content)
            return $this->apiResponse(InfoWebsiteContentResource::make($content));
        return $this->notFoundResponse("user not found");
    }


    public function create(Request $request){
        if($this->infoWebsiteRepository->contentExisted() == null){
            $validation = $this->infoWebsiteRepository->validatecreateContent($request);

            if ($validation instanceof \Illuminate\Http\Response) {

                return $validation;
            }
            $content = $this->infoWebsiteRepository->createContent($request);
            if ($content) {
                return $this->apiResponse(new InfoWebsiteContentResource($content));
            }
            return $this->unKnowError("error while creating the content");
        }
        else{
            $this->update($request);
        }
    }

    public function update(Request $request){
        $validation = $this->infoWebsiteRepository->validatecreateContent($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }
        if ($this->infoWebsiteRepository->updateContent($request))

            return $this->apiResponse("updated successfully");

        return $this->unKnowError("error while updating the content");
    }

    public function websitesCount(){
        $count = $this->infoWebsiteRepository->getWebsitesCount();
        if($count)
            return response()->json(['data' => $count + 1000]);
        return $this->notFoundResponse("No websites found");
    }

    public function createNewsletter(Request $request){
        $validation = $this->infoWebsiteRepository->validateCreateNewsletter($request);
        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }
        $newsletter = $this->infoWebsiteRepository->addToNewsletterList($request);
        if($newsletter != null)
            return $this->apiResponse(new WebsiteNewslettertResource($newsletter));
        return $this->unKnowError("already registered email");

    }

    public function contact(Request $request){
        $validation = $this->infoWebsiteRepository->validateContactFormData($request);
        if ($validation instanceof \Illuminate\Http\Response) {
            return $validation;
        }
        $this->infoWebsiteRepository->sendContactForm($request);
    }

    public function normalDomainCheck(Request $request){
        $validation = $this->infoWebsiteRepository->validateCheckForNormalDomain($request);
        if ($validation instanceof \Illuminate\Http\Response) {
            return $validation;
        }
        $result = $this->infoWebsiteRepository->checkForDomainAvailability($request);
        if($result)
            return $this->apiResponse(NormalDomainCheckResource::make($result));
        return response()->json(['data' => null]);
    }






}
