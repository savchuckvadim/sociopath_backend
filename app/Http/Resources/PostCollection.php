<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)

    {
        $id = $request->profileId;
        $filtered = $this->collection->where('profile_id', $id);


        $posts = $filtered->each(function ($item) {
            $author = $item->author;
            $authUserId = Auth::user()->id;

            // $currentLike = $item->likes()->where('author_id', $authUserId)->first();
            // $isAthLikes = false;
            // if ($currentLike) {
            //     $isAthLikes = true;
            // }

            return [$author];
        });
        return [
            // 'totalCount' =>  $this->collection->count(),
            'data' => $posts->values(),


        ];
    }
}
