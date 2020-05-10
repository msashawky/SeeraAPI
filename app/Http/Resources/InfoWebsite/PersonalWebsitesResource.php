<?php

namespace App\Http\Resources\InfoWebsite;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalWebsitesResource extends JsonResource
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
            'number_of_visits' => $this->number_of_visits,
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
