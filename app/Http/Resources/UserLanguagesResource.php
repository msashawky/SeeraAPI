<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserLanguagesResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'user_language_id' => $this->id,
            'language_ar' => $this->language->name_ar,
            'language_en' => $this->language->name_en,
            'language_level_ar' => $this->languageLevel->name_ar,
            'language_level_en' => $this->languageLevel->name_en
        ];
    }

}
