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
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
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
            'country_ar' => $this->country->name_ar
//            'photo' =>isset($this->photo) ? dashboardUrl() . 'upload_images/activities/'. $this->photo  : null,
        ];
    }

}
