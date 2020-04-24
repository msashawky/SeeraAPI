<?php

namespace App\Http\Resources\InfoWebsite;

use Illuminate\Http\Resources\Json\JsonResource;

class WebsitesCountResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'count' => $this->getWebsitesCount(),
        ];
    }

}
