<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LanguageLevelsResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'language_level_id' => $this->id
        ];
    }

}
