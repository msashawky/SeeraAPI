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
use App\Models\Skill;
use App\Models\UserLanguage;
use App\Models\Project;
use App\Models\Mobile;
use App\Models\Website;
use App\Models\Country;
use App\Models\Payment;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\ExpiredException;
use Exception;
use Illuminate\Support\Str;

class UserRepository implements UserRepositoryInterface
{

    use ApiResponseTrait;


    private $user;
    private $career;
    private $userEducation;
    private $skill;
    private $userLanguage;
    private $project;
    private $mobile;
    private $website;
    private $country;
    private $payment;


    public function __construct(User $user, Career $career, UserEducation $userEducation, Skill $skill, UserLanguage $userLanguage,
Project $project, Mobile $mobile, Website $website, Country $country, Payment $payment)
    {
        $this->user = $user;
        $this->career = $career;
        $this->userEducation = $userEducation;
        $this->skill = $skill;
        $this->userLanguage = $userLanguage;
        $this->project = $project;
        $this->mobile = $mobile;
        $this->website = $website;
        $this->country = $country;
        $this->payment = $payment;
    }

    public function getUserData($domain){
        return $this->user->where('username','LIKE', $domain)->with(['country', 'website'])->first();
    }
    public function getUserMobiles($user_id){
        return $this->mobile->where('user_id', $user_id)->get();
    }
    public function getUserCareers($user_id){
        return $this->career->where('user_id', $user_id)->get();
    }

    public function getUserEducations($user_id){
        return $this->userEducation->where('user_id', $user_id)->with('educationDegree')->get();
    }

    public function getUserSkills($user_id){
        return $this->skill->where('user_id', $user_id)->get();
    }

    public function getUserLanguages($user_id){
        return $this->userLanguage->where('user_id', $user_id)->with('languageLevel')->get();
    }
    public function getUserProjects($user_id){
        return $this->project->where('user_id', $user_id)->get();
    }
    public function getUserProjectsCount($user_id){
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


    public function getUseById($user_id){
        return $this->user->where('id', $user_id)->first();
    }

    public function validateEditUser(Request $request){
        return $this->apiValidation($request, [
            'name_ar' => 'required|min:3|max:100',
            'name_en' => 'required|min:3|max:100',
//            'email' =>'required|email|max:100',
//            'username' => 'required|min:3|max:100|unique:users,username',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'martial_status' => 'required',
            'job_title_ar' => 'required|min:3|max:100',
            'job_title_en' => 'required|min:3|max:100',
            'biography_ar' => 'required|min:3|max:220',
            'biography_en' => 'required|min:3|max:220',
            'career_started_at' => 'required',
            'country_id' => 'required',
            'city' => 'required',
        ]);
    }

    public function updateUserData(Request $request, $user_id){
        return $this->user->where('id', $user_id)->update($request->all());
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

    public function getAllCountries(){
        return $this->country->all();
    }



    public function getDonePaymentClients(){
        return $this->payment->where('paid', 1)->with(['user'])->get();
    }
    public function getNotDonePaymentClients(){
        return $this->payment->where('paid', 0)->with(['user'])->get();
    }

    public function isPaid($user_id){
        $payment = $this->payment->where('user_id', $user_id)->first();
        if($payment)
            return $payment->paid;
        return null;
    }

    public function tapPayment($request)
    {
        $amount = $request['amount'];
        $name = $request['name'];
        $order = $request['user_id'];
        $phone = null;
        $email = null;

        // $apiurl = 'https://www.gotapnow.com/webservice/paygatewayservice.svc';  // Production Url
        $apiurl = 'http://live.gotapnow.com/webservice/paygatewayservice.svc';  // Development Url

        //Merchant Details
        $ref = time();      //Your ReferenceID or Order ID
        $ReturnURL = url('/customer-payment-success/'.$order);  //After Payment success, customer will be redirected to this url
        $PostURL = url('/payment-success/'.$order);  //After Payment success, Payment Data's will be posted to this url

        $MerchantID = 1014; //Your ID provided by Tap
        $UserName = "test"; //Your Username under TAP.
        $APIKey = "1tap7"; //Your API Key Provided by Tap
        $password = "test"; //Your API Key Provided by Tap

        // $MerchantID = 2334088; //Your ID provided by Tap
        // $UserName = "Jk6f2@tap"; //Your Username under TAP.
        // $APIKey = "87tap23"; //Your API Key Provided by Tap
        // $password = "Jk6f2@q8"; //Your API Key Provided by Tap

        //Product Details
        $CurrencyCode = "SAR";      //Order Currency Code
        $Total = $amount;           //Total Order Amount

        //Generating the Hash string
        $str = 'X_MerchantID'.$MerchantID.'X_UserName'.$UserName.'X_ReferenceID'.$ref.'X_Mobile'.$phone.'X_CurrencyCode'.$CurrencyCode.'X_Total'.$Total.'';
        $hashstr = hash_hmac('sha256', $str, $APIKey);

        $action = "http://tempuri.org/IPayGatewayService/PaymentRequest";

        $soap_apirequest  ='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:tap="http://schemas.datacontract.org/2004/07/Tap.PayServiceContract">
            <soapenv:Header/>
                <soapenv:Body>
                    <tem:PaymentRequest>
                        <tem:PayRequest>
                            <tap:CustomerDC>
                            <tap:Email>'.$email.'</tap:Email>
                            <tap:Mobile>'.$phone.'</tap:Mobile>
                            <tap:Name>'.$name.'</tap:Name>
                            </tap:CustomerDC>
                            <tap:MerMastDC>
                                <tap:AutoReturn>Y</tap:AutoReturn>
                                <tap:ErrorURL>?</tap:ErrorURL>
                                <tap:MerchantID>'.$MerchantID.'</tap:MerchantID>
                                <tap:Password>'.$password.'</tap:Password>
                                <tap:ReferenceID>'.$ref.'</tap:ReferenceID>
                                <tap:ReturnURL>'.$ReturnURL.'</tap:ReturnURL>
                                <tap:UserName>'.$UserName.'</tap:UserName>
                                </tap:MerMastDC>
                            <tap:lstProductDC>
                            <tap:ProductDC>
                                <tap:CurrencyCode>Sar</tap:CurrencyCode>
                                <tap:Quantity>1</tap:Quantity>
                                <tap:TotalPrice>'.$Total.'</tap:TotalPrice>
                                <tap:UnitName>Gulf Fast</tap:UnitName>
                                <tap:UnitPrice>'.$Total.'</tap:UnitPrice>
                            </tap:ProductDC>
                            </tap:lstProductDC>
                        </tem:PayRequest>
                    </tem:PaymentRequest>
                </soapenv:Body>
            </soapenv:Envelope>';

        $apiheader = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: ".strlen($soap_apirequest),
        );

        // The HTTP headers for the request (based on image above)
        $apiheader = array(
            'Content-Type: text/xml; charset=utf-8',
            'Content-Length: '.strlen($soap_apirequest),
            'SOAPAction: '.$action
        );

        // Build the cURL session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiurl);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $apiheader);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $soap_apirequest);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        // Send the request and check the response
        if (($result = curl_exec($ch)) === FALSE) {
            die('cURL error: '.curl_error($ch)."<br />\n");
        } else {
            echo "Success!<br />\n";
        }
        curl_close($ch);

        $xmlobj = simplexml_load_string($result);
        $xmlobj->registerXPathNamespace('a', 'http://schemas.datacontract.org/2004/07/Tap.PayServiceContract');
        $xmlobj->registerXPathNamespace('i', 'http://www.w3.org/2001/XMLSchema-instance');

        $result = $xmlobj->xpath('//a:ReferenceID/text()');
        if (is_array($result)){
            foreach ($result as $temp) {
                echo "<br>ReferenceID : " . $temp;
            }
        }

        $result = $xmlobj->xpath('//a:ResponseCode/text()');
        if (is_array($result)){
            foreach ($result as $temp) {
                echo "<br>ResponseCode : " . $temp;
            }
        }

        $result = $xmlobj->xpath('//a:ResponseMessage/text()');
        if (is_array($result)){
            foreach ($result as $temp) {
                echo "<br>ResponseMessage : " . $temp;
            }
        }

        $result = $xmlobj->xpath('//a:PaymentURL/text()');
        if (is_array($result)){
            foreach ($result as $temp) {
                echo "<br>PaymentURL : " . $temp;
                header("Location:".$temp);
                //exit();
            }
        }

        die();
    }

}
