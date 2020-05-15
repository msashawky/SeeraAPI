<?php

namespace App\Http\Resources\OrganizationWebsite;

use Illuminate\Http\Resources\Json\JsonResource;

class WebsiteDataResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'organization_website_id' => $this->organizationWebsite->id,
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'email' => $this->email,
            'username' => $this->username,
            'userType' => $this->userType,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'martial_status' => $this->martial_status,
            'country_ar' => $this->country->name_ar,
            'country_en' => $this->country->name_en,
            'city' => $this->city,
            'job_title_ar' => $this->job_title_ar,
            'job_title_en' => $this->job_title_en,
            'biography_ar' => $this->biography_ar,
            'biography_en' => $this->biography_en,
            'photo' => $this->photo,
            'career_started_at' => $this->career_started_at,
            'is_activated' => $this->is_activated,
            'website_name_ar' => $this->organizationWebsite->website_name_ar,
            'website_name_en' => $this->organizationWebsite->website_name_en,
            'domain' => $this->organizationWebsite->domain_type,
            'about_us_ar' => $this->organizationWebsite->about_us_ar,
            'about_us_en' => $this->organizationWebsite->about_us_en,
            'address_ar' => $this->organizationWebsite->address_ar,
            'address_en' => $this->organizationWebsite->address_en,
            'website_email' => $this->organizationWebsite->email,
            'background_image' => $this->organizationWebsite->background_image,
            'number_of_visits' => $this->organizationWebsite->number_of_visits,
            'status' => $this->organizationWebsite->status,
            'facebook' => $this->organizationWebsite->facebook,
            'twitter' => $this->organizationWebsite->twitter,
            'linkedin' => $this->organizationWebsite->linkedin,
            'youtube' => $this->organizationWebsite->youtube,
            'google_plus' => $this->organizationWebsite->google_plus,
            'behance' => $this->organizationWebsite->behance,
            'instagram' => $this->organizationWebsite->instagram,
            'pinterest' => $this->organizationWebsite->pinterest,
            'vimeo' => $this->organizationWebsite->vimeo,
            'website_registered_at' => $this->organizationWebsite->created_at,


        ];
    }

}
