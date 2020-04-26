<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OrganizationWebsiteRepository;
use App\Http\Resources\OrganizationWebsite\WebsiteDataResource;
class OrganizationWebsiteController extends Controller
{
    private $websiteRepository;

    public function __construct(OrganizationWebsiteRepository $websiteRepository)
    {
        $this->websiteRepository = $websiteRepository;
    }

    public function websiteData($domain){
        $data = $this->websiteRepository->getWebsiteData($domain);
        if($data)
            return $this->apiResponse(WebsiteDataResource::make($data));
        return $this->notFoundResponse("user not found");
    }

}
