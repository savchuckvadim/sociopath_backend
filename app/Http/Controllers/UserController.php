<?php

namespace App\Http\Controllers;

use App\Http\Resources\DialogResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserRecource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public static function getAuthUser()
    {
        $resultCode = 0;
        $authUser = Auth::user();
        $userResource = null;

        if ($authUser) {
            $resultCode = 1;
            $userResource = new UserRecource($authUser);
            return response([
                'resultCode' => $resultCode,
                'authUser' => $userResource
            ]);
        } else {
            return response([
                'resultCode' => $resultCode,
                'message' => 'auth user is nod defined !'
            ]);
        }
    }

    public static function getUsers($request)
    {
        $resultCode = 0;
        $authUser = Auth::user();

        if ($authUser) {
            $resultCode = 1;
            $itemsCount = $request->query('count');
            $paginate = User::paginate($itemsCount);
            $collection = new UserCollection($paginate);
            return  $collection;
        } else {
            return response([
                'resultCode' => $resultCode,
                'message' => 'auth user is nod defined !'
            ]);
        }
    }

    public static function getUser($id)
    {
        $user = User::findOrFail($id);
        $resultCode = 0;
        if ($user) {
            $resultCode = 1;
            $userResource = new UserRecource($user);
            return response([
                'resultCode' => $resultCode,
                'user' => $userResource
            ]);
        } else {
            return response([
                'resultCode' => $resultCode,
                'message' => 'user not found!'
            ]);
        }
    }

    public static function getDialogs()
    {
        $user = Auth::user();
        $touchUser = User::find($user->id);
        $touchUser->touch();
        $dialogs = $user->dialogs;
        $resultDialogs = [];


        foreach ($dialogs as $dialog) {


                $resultDialog = new DialogResource($dialog);
                array_push($resultDialogs, $resultDialog);

        }
        return response([
            'resultCode' => 1,
            'dialogs' => array_reverse($resultDialogs),
            '$user->dialogs;'=> $user->dialogs
            // 'groupDialogs' => array_reverse($resultGroupDialogs),


        ]);
    }
}
