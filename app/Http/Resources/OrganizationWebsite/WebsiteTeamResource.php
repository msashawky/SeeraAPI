<?php

namespace App\Http\Resources\OrganizationWebsite;

use Illuminate\Http\Resources\Json\JsonResource;

class WebsiteTeamResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'organization_website_id' => $this->organization_website_id,
            'team_member_name_ar' => $this->name_ar,
            'team_member_name_ar' => $this->name_en,
            'job_title_ar' => $this->job_title_ar,
            'job_title_en' => $this->job_title_en,
            'team_member_photo' => $this->photo,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'linkedin' => $this->linkedin,
        ];
    }

}
