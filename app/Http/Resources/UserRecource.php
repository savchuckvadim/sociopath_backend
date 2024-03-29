<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserRecource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    protected $followed = 0;
    public function toArray($request)
    {


        $isAuthUser = false;
        $currentUser = Auth::user();
        $id = $currentUser->id;

        if ($id === $this->id) {
            $isAuthUser = true;
        }

        for ($i = 0; $i < $this->followers->count(); $i++) {
            if ($this->followers[$i]->id == $id) {
                $this->followed = 1;
            };
        };
        return [
            'id' => $this->id,
            'email' => $this->email,
            'followeds' => $this->followeds,
            'followers' => $this->followers,
            'followed' =>  $this->followed,
            'profile' => $this->profile,
            'postsCount' => $this->posts->count(),
            'isAuthUser' => $isAuthUser
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }

    public function with($request)
    {
        return [
            'resultCode' => 1,

        ];
    }
}
