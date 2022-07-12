<?php

namespace App\Http\Controllers;

use App\Models\Followers;
use App\Models\User;
use Illuminate\Http\Request;

class FollowersController extends Controller
{
    public static function follow($auth_user_id, $followed_id)
    {

        $connect = new Followers;
        $connect->follower_id = $auth_user_id;
        $connect->followed_id = $followed_id;
        $connect->save();
        $followed_user = User::where('id', $followed_id)->first();
        $followed_user->followed = 1;
      

        return  $followed_user;
    }

    public function unfolllow($user_id, $followed)
    {

        Followers::where('followed', $user_id)->where('follower', $followed)->destroy();
    }
}
