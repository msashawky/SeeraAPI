<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrentUserDataResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'user_id' => $this->id,
            'userType' => $this->userType,
            'email' => $this->email,
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'username' => $this->username,
            'gender' => $this->gender,

        ];
    }

}
