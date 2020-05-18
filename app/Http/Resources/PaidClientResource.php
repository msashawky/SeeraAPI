<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaidClientResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            'user_id' => $this->user_id,
            'amount_of_money' => $this->amount_of_money,
            'paid' => $this->paid,
            'paid_at' => $this->paid_at,
            'name_en' => $this->user->name_en,
            'name_ar' => $this->user->name_ar,
            'domain' => $this->domain,
            'userType' => $this->user->userType,
        ];
    }

}
