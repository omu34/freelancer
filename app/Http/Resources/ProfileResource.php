<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>$this->id,
            'firstname' =>$this->firstname,
            'lastname' => $this->lastname,
            'profilename' => $this->profilename,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'user_id'=>$this->user_id,
            'phone' => $this->phone,
            'email' => $this->email,
            'location'=>$this->location
        ];
    }
}
