<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSkillsResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'user_skill_id' => $this->id,
            'skill' => $this->skill,
            'skill_percentage' => $this->skill_percentage
        ];
    }

}
