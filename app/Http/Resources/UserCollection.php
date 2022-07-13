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
        // $currentUser = Auth::user();
        // if ($currentUser) {
           
        //     $followeds = $currentUser->followeds;
        //     $resultCollection = $this->collection->each(function ($item, $key, $followeds){

        //     });
        // }
$data = $this->collection->each(function($item){
    return [$item->followers, $item->followeds];
  });
        return [
            'resultCode' => 0,
            'totalCount' =>  $this->collection->count(),

            // 'data' => $result_collection,
            'data' => $data,


            // 'links' => [
            //     'self' => 'link-value',
            // ]
        ];
    }
}
