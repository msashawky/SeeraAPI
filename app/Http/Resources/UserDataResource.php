<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDataResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'user_id' => $this->id,
            'userType' => $this->userType,
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'website_name_ar' => $this->website->name_ar,
            'website_name_en' => $this->website->name_en,
            'domain' => $this->website->domain,
            'domain_type' => $this->website->domain_type,
            'number_of_visits' => $this->website->number_of_visits,
            'email' => $this->email,
            'username' => $this->username,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'martial_status' => $this->martial_status,
            'job_title_ar' => $this->job_title_ar,
            'job_title_en' => $this->job_title_en,
            'biography_ar' => $this->biography_ar,
            'biography_en' => $this->biography_en,
            'career_started_at' => $this->career_started_at,
            'country_en' => $this->country->name_en,
            'country_ar' => $this->country->name_ar,
            'city' => $this->city,
            'facebook' => $this->website->facebook,
            'twitter' => $this->website->twitter,
            'linkedin' => $this->website->linkedin,
            'youtube' => $this->website->youtube,
            'google_plus' => $this->website->google_plus,
            'behance' => $this->website->behance,
            'instagram' => $this->website->instagram,
            'pinterest' => $this->website->pinterest,
            'vimeo' => $this->website->vimeo,
//            'photo' =>isset($this->photo) ? dashboardUrl() . 'upload_images/activities/'. $this->photo  : null,
        ];
    }

}
