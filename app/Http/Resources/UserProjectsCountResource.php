<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProjectsCountResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'projects_count' => $this,
        ];
    }

}
