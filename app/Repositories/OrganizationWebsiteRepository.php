<?php

namespace App\Repositories;


use App\Interfaces\implementsOrganizationWebsiteRepositoryInterface;

use App\Traits\ApiResponseTrait;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\OrganizationWebsite;
use App\Models\Project;
use App\Models\Mobile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\ExpiredException;
use Exception;
use Illuminate\Support\Str;

class OrganizationWebsiteRepository implements OrganizationWebsiteRepositoryInterface
{

    use ApiResponseTrait;
    //valid for one hour 60 * 60
    static $offset = ((10 * 24) * (60 * 60));

    private $user;
    private $project;
    private $mobile;
    private $organizationWebsite;


    public function __construct(User $user, Project $project, Mobile $mobile, OrganizationWebsite $organizationWebsite)
    {
        $this->user = $user;
        $this->project = $project;
        $this->mobile = $mobile;
        $this->organizationWebsite;
    }

    public function getWebsiteData($domain){
        return $this->user->where('username','LIKE', $domain)->with(['country', 'organizationWebsite'])->first();
    }
    public function getWebsiteMobiles($user_id){
        return $this->mobile->where('user_id', $user_id)->get();
    }

    public function getWebsiteProjects($user_id){
        return $this->project->where('user_id', $user_id)->get();
    }
    public function getWebsiteProjectsCount($user_id){
        return $this->project->where('user_id', $user_id)->count();
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
