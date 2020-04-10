<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCareersResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'user_id' => $this->user_id,
            'title_ar' => $this->title_ar,
            'title_en' => $this->title_en,
            'employer' => $this->employer,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'employment_status' => $this->employment_status,
            'role' => $this->role,
            'description' => $this->description,
        ];
    }

}
