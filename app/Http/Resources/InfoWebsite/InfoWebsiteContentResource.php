<?php

namespace App\Http\Resources\InfoWebsite;

use Illuminate\Http\Resources\Json\JsonResource;

class InfoWebsiteContentResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'info_website_name_ar' => $this->info_website_name_ar,
            'info_website_name_en' => $this->info_website_name_en,
            'info_website_url' => $this->info_website_url,
            'logo' => $this->logo,
            'favicon' => $this->favicon,
            'about_us_ar' => $this->about_us_ar,
            'about_us_en' => $this->about_us_en,
            'terms_and_conditions_ar' => $this->terms_and_conditions_ar,
            'terms_and_conditions_en' => $this->terms_and_conditions_en,
            'privacy_policy_en' => $this->privacy_policy_en,
            'privacy_policy_ar' => $this->privacy_policy_ar,
            'address_en' => $this->address_en,
            'address_ar' => $this->address_ar,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'youtube' => $this->youtube,
        ];
    }

}
