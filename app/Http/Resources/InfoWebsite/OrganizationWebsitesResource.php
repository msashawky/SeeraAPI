<?php

namespace App\Http\Resources\InfoWebsite;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationWebsitesResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'website_name_ar' => $this->website_name_ar,
            'website_name_en' => $this->website_name_en,
            'domain' => $this->domain,
            'domain_type' => $this->domain_type,
            'background_image' => $this->background_image,
            'website_email' => $this->email,
            'number_of_visits' => $this->number_of_visits,
            'about_us_ar' => $this->about_us_ar,
            'about_us_en' => $this->about_us_en,
            'address_ar' => $this->address_ar,
            'address_en' => $this->address_en,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'linkedin' => $this->linkedin,
            'youtube' => $this->youtube,
            'google_plus' => $this->google_plus,
            'behance' => $this->behance,
            'instagram' => $this->instagram,
            'pinterest' => $this->pinterest,
            'vimeo' => $this->vimeo,
            'owner_name_ar' => $this->user->name_ar,
            'owner_name_en' => $this->user->name_en,
            'owner_email' => $this->user->email,
        ];
    }

}
