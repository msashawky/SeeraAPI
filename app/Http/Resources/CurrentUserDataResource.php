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
            'username' => $this->username,
            'gender' => $this->gender,

        ];
    }

}
