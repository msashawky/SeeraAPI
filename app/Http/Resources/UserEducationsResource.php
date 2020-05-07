<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserEducationsResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'user_education_id' => $this->id,
            'user_id' => $this->user_id,
            'degree_ar' => $this->educationDegree->name_ar,
            'degree_en' => $this->educationDegree->name_en,
            'school' => $this->school,
            'started_year' => $this->started_year,
            'graduation_year' => $this->graduation_year,
            'education_status' => $this->education_status,
        ];
    }

}
