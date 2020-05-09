<?php

namespace App\Http\Resources\OrganizationWebsite;

use Illuminate\Http\Resources\Json\JsonResource;

class WebsitePortfolioResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'organization_website_id' => $this->organization_website_id,
            'portfolio_name_ar' => $this->name_ar,
            'portfolio_name_en' => $this->name_en,
            'portfolio_image' => $this->image,
        ];
    }

}
