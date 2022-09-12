<?php

namespace App\Http\Controllers;

use App\Events\SendPost;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public static function newPost(Request $request)
    {
        $post = new Post;
        $post->body = $request->body;
        $post->profile_id = $request->profileId;
        $post->author_id = Auth::user()->id;

        if ($request->image) {
            $post->image = $request->image;
        }
        $post->save();
        $result = new PostResource($post);
//DISPATCH EVENT
        SendPost::dispatch($post);

        return $result;
    }

    public static function getPosts($profileId)
    {
        $posts = Post::where('profile_id', $profileId)->get();
        $collection = new PostCollection($posts);

      
        return response([
            'resultCode' => 1,
            'posts' => $collection->values()
        ]);
    }

    // TODO at frontend
    public static function updatePost(Request $request)
    {
        $post = Post::where('id', $request->postId);
        $post->body = $request->body;

        if ($request->image) {
            $post->image = $request->image;
        }
        $post->save();
        return $post;
    }
}
