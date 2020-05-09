<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrganizationWebsite\WebsiteMobilesResource;
use App\Http\Resources\OrganizationWebsite\WebsitePortfolioResource;
use App\Http\Resources\OrganizationWebsite\WebsiteServicesResource;
use App\Http\Resources\OrganizationWebsite\WebsiteTeamResource;
use Illuminate\Http\Request;
use App\Repositories\OrganizationWebsiteRepository;
use App\Http\Resources\OrganizationWebsite\WebsiteDataResource;
class OrganizationWebsiteController extends Controller
{
    private $organizationWebsiteRepository;

    public function __construct(OrganizationWebsiteRepository $organizationWebsiteRepository)
    {
        $this->organizationWebsiteRepository = $organizationWebsiteRepository;
    }

    public function websiteData($domain){
        $data = $this->organizationWebsiteRepository->getWebsiteData($domain);
        if($data)
            return $this->apiResponse(WebsiteDataResource::make($data));
        return $this->notFoundResponse("user not found");
    }

    public function websiteMobiles($website_id){
        $mobiles = $this->organizationWebsiteRepository->getWebsiteMobiles($website_id);
        if($mobiles)
            return $this->apiResponse(WebsiteMobilesResource::collection($mobiles));
        return $this->notFoundResponse("mobiles not found");
    }

    public function websiteServices($website_id){
        $services = $this->organizationWebsiteRepository->getWebsiteServices($website_id);
        if($services)
            return $this->apiResponse(WebsiteServicesResource::collection($services));
        return $this->notFoundResponse("services not found");
    }
    public function websitePortfolio($website_id){
        $portfolio = $this->organizationWebsiteRepository->getWebsitePortfolios($website_id);
        if($portfolio)
            return $this->apiResponse(WebsitePortfolioResource::collection($portfolio));
        return $this->notFoundResponse("portfolio not found");
    }
    public function websiteTeam($website_id){
        $team = $this->organizationWebsiteRepository->getWebsiteTeam($website_id);
        if($team)
            return $this->apiResponse(WebsiteTeamResource::collection($team));
        return $this->notFoundResponse("Team not found");
    }

}
