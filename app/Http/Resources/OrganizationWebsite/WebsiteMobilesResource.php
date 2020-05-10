<?php

namespace App\Http\Resources\OrganizationWebsite;

use Illuminate\Http\Resources\Json\JsonResource;

class WebsiteMobilesResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'mobile_number' => $this->mobile_number,
            'user_id' => $this->user_id,

        ];
    }

}
