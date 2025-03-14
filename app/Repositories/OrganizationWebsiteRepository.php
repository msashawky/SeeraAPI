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

    public function getWebsiteTeam($website_id){
        return $this->team->where('organization_website_id', $website_id)->get();
    }

    //Dashboard Methods

    public function getWebsiteId($user_id){
        return $this->organizationWebsite->where('user_id', $user_id)->value('id');
    }

    public function validateCreateWebsite(Request $request){
        return $this->apiValidation($request, [
            'website_name_ar' => 'nullable|min:3|max:100',
            'website_name_en' => 'nullable|min:3|max:100',
            'email' => 'nullable|email',
            'domain' => 'nullable',
            'domain_type' => 'nullable',
            'about_us_ar' => 'nullable|min:5|max:200',
            'about_us_en' => 'nullable|min:5|max:200',
            'address_ar' => 'nullable|min:5|max:200',
            'address_en' => 'nullable|min:5|max:200',
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
    public function updateWebsiteData(Request $request){
        $currentUser = $request->auth;
        $website_id = $this->getWebsiteId($currentUser->id);
        if($request->file('image')){
            $photo =  upload_single_photo($request->file('image'),'images/upload_images/organization_website/backgrounds/');
            $request['background_image'] = 'public/images/upload_images/organization_website/backgrounds/'.$photo;
        }


        return $this->organizationWebsite->where('id', $website_id)
            ->update(['website_name_ar' =>$request['website_name_ar'], 'website_name_en' =>$request['website_name_en'],
                'domain' =>$request['domain'],'domain_type' =>$request['domain_type'],'about_us_ar' =>$request['about_us_ar'],
                'about_us_en' =>$request['about_us_en'],'address_en' =>$request['address_en'],'address_ar' =>$request['address_ar'],
                'email'=>$request['email'],'facebook'=>$request['facebook'],'twitter'=>$request['twitter'],'linkedin'=>$request['linkedin'],
                'youtube'=>$request['youtube'], 'google_plus'=>$request['google_plus'],'behance'=>$request['behance'], 'instagram'=>$request['instagram'],
                'pinterest'=>$request['pinterest'],'vimeo'=>$request['vimeo'],'background_image' =>$request['background_image']]);
    }

    //Services

    public function createWebsiteService(Request $request){
        $currentUser = $request->auth;
        $website_id = $this->getWebsiteId($currentUser->id);//dd($website_id);
        $request['organization_website_id']= $website_id;
        return $this->service->create($request->all());
    }
    public function validateCreateWebsiteService(Request $request){
        return $this->apiValidation($request, [
            'name_ar' => 'required|min:2|max:200',
            'name_en' => 'required|min:2|max:200',
            'description_ar' => 'required|min:2|max:200',
            'description_en' => 'required|min:2|max:200',
        ]);
    }
    public function updateWebsiteService(Request $request){
        return $this->service->where('id', $request->id)->update($request->all());
    }
    public function deleteWebsiteService(Request $request){
        $this->service->where('id', $request->id)->delete();
    }


    //Team

    public function createTeamMember(Request $request){
        $currentUser = $request->auth;
        $website_id = $this->getWebsiteId($currentUser->id);
        $request['organization_website_id']= $website_id;
        $photo =  upload_single_photo($request->file('image'),'images/upload_images/organization_website/team/');
        $request['photo'] = 'public/images/upload_images/organization_website/team/'.$photo;
        return $this->team->create($request->all());
    }
    public function validateCreateTeamMember(Request $request){
        return $this->apiValidation($request, [
            'name_ar' => 'required|min:2|max:200',
            'name_en' => 'required|min:2|max:200',
            'job_title_ar' => 'required|min:2|max:200',
            'job_title_en' => 'required|min:2|max:200',
            'image' => 'required',
            'facebook' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)facebook\.com\/([a-zA-Z0-9_]*)$/',
            'twitter' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)twitter\.com\/([a-zA-Z0-9_]*)$/',
            'linkedin' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)linkedin\.com\/([a-zA-Z0-9_]*)$/',
        ]);
    }
    public function validateUpdateTeamMember(Request $request){
        return $this->apiValidation($request, [
            'name_ar' => 'required|min:2|max:200',
            'name_en' => 'required|min:2|max:200',
            'job_title_ar' => 'required|min:2|max:200',
            'job_title_en' => 'required|min:2|max:200',
            'facebook' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)facebook\.com\/([a-zA-Z0-9_]*)$/',
            'twitter' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)twitter\.com\/([a-zA-Z0-9_]*)$/',
            'linkedin' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)linkedin\.com\/([a-zA-Z0-9_]*)$/',
        ]);
    }
    public function updateTeamMember(Request $request){
        if($request->file('image')){
            $photo =  upload_single_photo($request->file('image'),'images/upload_images/organization_website/portfolio/');
            $request['photo'] = 'public/images/upload_images/organization_website/portfolio/'.$photo;
            return $this->team->where('id', $request->id)->update(['name_ar' => $request['name_ar'], 'name_en'=>$request['name_en'],
                'job_title_ar' => $request['job_title_ar'],'job_title_en' => $request['job_title_en'],'photo'=> $request['photo']]);
        }
        return $this->team->where('id', $request->id)->update(['name_ar' => $request['name_ar'],
            'name_en'=>$request['name_en'], 'job_title_ar' => $request['job_title_ar'],'job_title_en' => $request['job_title_en']]);
    }
    public function deleteTeamMember(Request $request){
        $this->team->where('id', $request->id)->delete();
    }

    //Portfolio

    public function createWebsitePortfolio(Request $request){
        $currentUser = $request->auth;
        $website_id = $this->getWebsiteId($currentUser->id);
        $request['organization_website_id']= $website_id;
        $photo =  upload_single_photo($request->file('photo'),'images/upload_images/organization_website/portfolio/');
        $request['image'] = 'public/images/upload_images/organization_website/portfolio/'.$photo;
        return $this->portfolio->create($request->all());
    }
    public function validateCreateWebsitePortfolio(Request $request){
        return $this->apiValidation($request, [
            'name_ar' => 'required|min:2|max:200',
            'name_en' => 'required|min:2|max:200',
            'photo' => 'required',
        ]);
    }
    public function validateUpdateWebsitePortfolio(Request $request){
        return $this->apiValidation($request, [
            'name_ar' => 'required|min:2|max:200',
            'name_en' => 'required|min:2|max:200',
        ]);
    }
    public function updateWebsitePortfolio(Request $request){
        if($request->file('photo')){
            $photo =  upload_single_photo($request->file('photo'),'images/upload_images/organization_website/portfolio/');
            $request['image'] = 'public/images/upload_images/organization_website/portfolio/'.$photo;
            return $this->portfolio->where('id', $request->id)->update(['name_ar' => $request['name_ar'], 'name_en'=>$request['name_en'],
                'image'=> $request['image']]);
        }
        return $this->portfolio->where('id', $request->id)->update(['name_ar' => $request['name_ar'],
            'name_en'=>$request['name_en']]);
    }
    public function deleteWebsitePortfolio(Request $request){
        $this->portfolio->where('id', $request->id)->delete();
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



}
