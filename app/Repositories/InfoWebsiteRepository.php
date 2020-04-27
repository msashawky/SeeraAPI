<?php

namespace App\Repositories;

use App\Interfaces\InfoWebsiteRepositoryInterface;
use App\Models\InfoWebsiteContent;
use App\Models\NewsLetter;
use App\Models\Website;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\ExpiredException;
use Exception;
use Illuminate\Support\Str;

class InfoWebsiteRepository implements InfoWebsiteRepositoryInterface
{

    use ApiResponseTrait;
    //valid for one hour 60 * 60
    static $offset = ((10 * 24) * (60 * 60));
    private $infoWebsiteContent;
    private $newsletter;
    private $website;
    private $user;

    public function __construct(InfoWebsiteContent $infoWebsiteContent, NewsLetter $newsLetter, Website $website, User $user)
    {
        $this->infoWebsiteContent = $infoWebsiteContent;
        $this->newsletter = $newsLetter;
        $this->website = $website;
        $this->user = $user;
    }

    public function getInfoWebsiteContent(){
        return $this->infoWebsiteContent->first();
    }

    public function contentExisted(){
        return $this->infoWebsiteContent->first();
    }

    public function createContent(Request $request){
        $input = $request->all();
        return $this->infoWebsiteContent->create($input);
    }

    public function updateContent(Request $request){
//        $content = decodeUser($request->bearerToken());//dd($content);
        $data = $this->infoWebsiteContent->first();//dd($data);
        $data->where('id', 3)->update($request->all());
    }

    public function validatecreateContent(Request $request){
        return $this->apiValidation($request, [
            'info_website_name_ar' => 'required|min:3|max:100',
            'info_website_name_en' => 'required|min:3|max:100',
            'info_website_url' => 'required|min:3|max:100|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
//            'logo' => 'mimes:jpeg,jpg,png,gif|required|max:2000',
//            'favicon' => 'mimes:jpeg,jpg,png,gif,ico|required|max:2000',
            'about_us_ar' => 'required|min:10|max:3000',
            'about_us_en' => 'required|min:10|max:3000',
            'terms_and_conditions_ar' => 'required|min:10|max:3000',
            'terms_and_conditions_en' => 'required|min:10|max:3000',
            'privacy_policy_ar' => 'required|min:10|max:3000',
            'privacy_policy_en' => 'required|min:!0|max:3000',
            'facebook' => 'required|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)facebook\.com\/([a-zA-Z0-9_]*)$/',
            'twitter' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)twitter\.com\/([a-zA-Z0-9_]*)$/',
            'instagram' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)instagram\.com\/([a-zA-Z0-9_]*)$/',
            'youtube' => 'nullable|min:3|max:100|regex:/(https?:\/\/)?([\w\.]*)youtube\.com\/([a-zA-Z0-9_]*)$/',


        ]);
    }

    public function getWebsitesCount(){
        return $this->website->count();
    }

    public function newsLetterRegistered($email){
        return $this->newsletter->where('email', 'LIKE', $email)->first();
    }

    public function addToNewsletterList(Request $request){//dd($request);
        $input = $request->all();
        if($this->newsLetterRegistered($request->email))
            return null;
        return $this->newsletter->create($input);
    }
    public function validateCreateNewsletter(Request $request){
        return $this->apiValidation($request, [
            'email' => 'required|email|min:3|max:100|unique:news_letters,email',
        ]);
    }

    public function sendContactForm(Request $request){
        $message = '<p><strong>Name: '.$request->name.'</strong><br> email:'.$request->email.'</p><br>'.'message: <p>'.$request->message.'</p>';
        $headers = "Content-Type: text/html; charset=UTF-8\r\n";
        mail('msashawky@gmail.com',"Seera - Contact Form", $message, $headers);
    }
    public function validateContactFormData(Request $request){
        return $this->apiValidation($request, [
            'name' => 'required|min:3|max:100',
            'email' => 'required|email|max:100',
            'message' => 'required|min:5|max:200'
        ]);
    }

    public function checkForDomainAvailability(Request $request){
        return $this->user->where('username', 'LIKE', $request->domainName)->first();
    }

    public function validateCheckForNormalDomain(Request $request){
        return $this->apiValidation($request, [
            'domainName' => 'required|min:3|max:100|alpha_dash'
        ]);
    }


}
