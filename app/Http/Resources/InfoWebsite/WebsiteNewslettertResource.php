<?php

namespace App\Http\Resources\InfoWebsite;

use Illuminate\Http\Resources\Json\JsonResource;

class WebsiteNewslettertResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'email' => $this->email,
        ];
    }

}
