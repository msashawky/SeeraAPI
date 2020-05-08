<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProjectsResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'user_project_id' => $this->id,
            'project_title' => $this->project_title,
            'project_description' => $this->project_description,
        ];
    }

}
