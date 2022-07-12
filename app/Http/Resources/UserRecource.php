<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserRecource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }

    public function with($request)
    {
        return [
            'resultCode' => 0,

            'links' => [
                'self' => 'link-value',
            ]
        ];
    }
}
