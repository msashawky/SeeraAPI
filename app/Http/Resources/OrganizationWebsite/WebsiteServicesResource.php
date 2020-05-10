<?php

namespace App\Http\Resources\OrganizationWebsite;

use Illuminate\Http\Resources\Json\JsonResource;

class WebsiteServicesResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'organization_website_id' => $this->organization_website_id,
            'service_name_ar' => $this->name_ar,
            'service_name_en' => $this->name_en,
            'service_description_ar' => $this->description_ar,
            'service_description_en' => $this->description_en,
        ];
    }

}
