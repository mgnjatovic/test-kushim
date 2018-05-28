<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar' => $this->avatar,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'city' => $this->city,
            'zip' => $this->zip,
            'country' => $this->country,
            'email' => $this->email,
            'phone' => $this->phone,
            'note' => $this->note,
            'groups' => GroupResource::collection($this->groups),
        ];
    }
}
