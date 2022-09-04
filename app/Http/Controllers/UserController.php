<?php
namespace App\Http\Controllers;
use App\Http\Resources\UserRecource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public static function getAuthUser(){
        $resultCode = 0;
        $authUser = Auth::user();
        $userResource = null;

        if ($authUser) {
            $resultCode = 1;
          $userResource = new UserRecource($authUser);


          return response([
            'resultCode'=> $resultCode,
            'authUser' => $userResource
          ]);
        }else{
            return response([
                'resultCode'=> $resultCode,
                'message' => 'auth user is nod defined !'
              ]);

        }

    }
}
