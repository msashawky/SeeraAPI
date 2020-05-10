<?php

namespace App\Http\Controllers;
use App\Http\Resources\InfoWebsite\OrganizationWebsitesResource;
use App\Http\Resources\InfoWebsite\PersonalWebsitesResource;
use App\Http\Resources\InfoWebsite\WebsiteNewslettertResource;
use Illuminate\Http\Request;

use App\Repositories\AdminRepository;
use App\Repositories\InfoWebsiteRepository;
class AdminController extends Controller
{
    private $adminRepository;
    private $infoWebsiteRepository;

    public function __construct(AdminRepository $adminRepository, InfoWebsiteRepository $infoWebsiteRepository)
    {
        $this->adminRepository = $adminRepository;
        $this->infoWebsiteRepository = $infoWebsiteRepository;
    }

    public function personalWebsitesCount(){
        $count = $this->adminRepository->getPersonalWebsitesCount();
        if($count)
            return $this->apiResponse($count);
        return $this->notFoundResponse("websites count not found");
    }
    public function organizationWebsitesCount(){
        $count = $this->adminRepository->getOrganizationWebsitesCount();
        if($count)
            return $this->apiResponse($count);
        return $this->notFoundResponse("websites count not found");
    }
    public function newslettersCount(){
        $count = $this->adminRepository->getNewsletterCount();
        if($count)
            return $this->apiResponse($count);
        return $this->notFoundResponse("No Newsletters found");
    }

    public function newsletters(){
        $newsletters = $this->adminRepository->getNewsletters();
        if($newsletters)
            return $this->apiResponse(WebsiteNewslettertResource::collection($newsletters));
        return $this->notFoundResponse("No Newsletters found");
    }
    public function personalWebsites(){
        $websites = $this->adminRepository->getPersonalWebsites();
        if($websites)
            return $this->apiResponse(PersonalWebsitesResource::collection($websites));
        return $this->notFoundResponse("No websites found");
    }
    public function organizationWebsites(){
        $websites = $this->adminRepository->getOrganizationWebsites();
        if($websites)
            return $this->apiResponse(OrganizationWebsitesResource::collection($websites));
        return $this->notFoundResponse("No websites found");
    }

    public function updateWebsite(Request $request){
        $validation = $this->adminRepository->validateUpdateWebsite($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }
        $content = $this->adminRepository->updateInfoContent($request);
        return $this->apiResponse($content);

    }


}
