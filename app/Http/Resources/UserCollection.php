<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $this->except('updated_at', 'name', 'surname');
       

        return [
            'resultCode' => 0,
            'totalCount' =>  $this->collection->count(),
           
            // 'data' => $result_collection,
            'data' => $this->collection,

            
            // 'links' => [
            //     'self' => 'link-value',
            // ]
        ];
    }
}
