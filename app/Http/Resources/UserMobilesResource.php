<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserMobilesResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
                        'mobile_number' => $this->mobile_number,
        ];
    }

}
