<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EducationDegreeResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'degree_id' => $this->id,
        ];
    }

}
