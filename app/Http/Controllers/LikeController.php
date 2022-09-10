<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public static function setLike($postId)
    {
        $authorId = Auth::user()->id;
        $like = new Like();
        $like->post_id = $postId;
        $like->author_id = $authorId;
        $like->save();

        return response(([
            // 'like' => $like,
            'resultCode' => 1
        ]
        ));
    }
    public static function deleteLike($postId)
    {
        $authorId = Auth::user()->id;
        $like = Like::where('post_id', $postId)->where('author_id', $authorId)->first();
        

        if ($like) {
            $like->delete();
            return response(([
                // 'removedLike' => $like,
                'resultCode' => 1
            ]
            ));
        } else {
            return response(([
                'message' => 'not found',
                'resultCode' => 0
            ]
            ));
        }
    }
}
