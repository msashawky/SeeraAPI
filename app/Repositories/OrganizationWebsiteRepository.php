<?php

namespace App\Repositories;


use App\Interfaces\implementsOrganizationWebsiteRepositoryInterface;

use App\Traits\ApiResponseTrait;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\OrganizationWebsite;
use App\Models\OrganizationWebsiteNewsletter;
use App\Models\OrganizationWebsitePortfolio;
use App\Models\OrganizationWebsiteTeam;
use App\Models\OrganizationWebsiteService;
use App\Models\Mobile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\ExpiredException;
use Exception;
use Illuminate\Support\Str;

class OrganizationWebsiteRepository //implements OrganizationWebsiteRepositoryInterface
{

    use ApiResponseTrait;
    //valid for one hour 60 * 60
    static $offset = ((10 * 24) * (60 * 60));

    private $user;
    private $newsletter;
    private $service;
    private $team;
    private $portfolio;
    private $mobile;
    private $organizationWebsite;


    public function __construct(User $user, OrganizationWebsite $organizationWebsite, OrganizationWebsiteService $service,
                                OrganizationWebsiteNewsletter $newsletter, OrganizationWebsitePortfolio $portfolio,
                                OrganizationWebsiteTeam $team, Mobile $mobile)
    {
        $this->user = $user;
        $this->organizationWebsite = $organizationWebsite;
        $this->team = $team;
        $this->service = $service;
        $this->portfolio = $portfolio;
        $this->newsletter = $newsletter;
        $this->mobile = $mobile;

    }

    public function getWebsiteData($domain){
        return $this->user->where('username','LIKE', $domain)->with(['country', 'organizationWebsite'])->first();
    }
    public function getWebsiteMobiles($website_id){
        $user_id = $this->organizationWebsite->where('id', $website_id)->value('user_id');
        return $this->mobile->where('user_id', $user_id)->get();
    }

    public function getWebsiteServices($website_id){
        return $this->service->where('organization_website_id', $website_id)->get();
    }
    public function getWebsitePortfolios($website_id){
        return $this->portfolio->where('organization_website_id', $website_id)->get();
    }
    public function getWebsiteNewsletters($website_id){
        return $this->newsletter->where('organization_website_id', $website_id)->get();
    }
    public function getWebsiteTeam($website_id){
        return $this->team->where('organization_website_id', $website_id)->get();
    }


    public function validateContactFormData(Request $request){
        return $this->apiValidation($request, [
            'name' => 'required|min:3|max:100',
            'email' => 'required|email|max:100',
            'message' => 'required|min:5|max:200',
            ]);
    }

    public function sendContactForm(Request $request, $user_id){
//        $data = decodeUser($request->bearerToken());
        $message = '<p><strong>Name: '.$request->name.'</strong><br> email:'.$request->email.'</p><br>'.'message: <p>'.$request->message.'</p>';
        $headers = "Content-Type: text/html; charset=UTF-8\r\n";
//        dd($request);
            mail($this->getUseById($user_id)->email,"Seera - Contact Form", $message, $headers);
    }


    public function getUserById($user_id){
        return $this->user->where('id', $user_id)->first();
    }

}
