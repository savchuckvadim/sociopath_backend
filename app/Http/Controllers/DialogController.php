<?php

namespace App\Http\Controllers;

use App\Http\Resources\DialogResource;
use App\Models\Dialog;
use App\Models\User;
use App\Models\UserDialog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DialogController extends Controller
{
    public static function getOrCreateDialog($userId)
    {
        $authUser = Auth::user();
        $authUserId = $authUser->id;
        $authUserDialogs = $authUser->dialogs;
        $isDialogExist = false;

        $user = User::find($userId);

        $resultDialog = null;
        if (count($authUserDialogs) > 0 && $user) {
            $userDialogs = $user->dialogs;
            foreach ($authUserDialogs as $authDialog) {
                foreach ($userDialogs as $userDialog) {
                    if ($authDialog->id == $userDialog->id) {
                        $isDialogExist = true;
                        $foundDialog = Dialog::find($userDialog->id);
                        $resultDialog = new DialogResource($foundDialog);
                    }
                }
            }
        }
        if (!$isDialogExist) {
            $cratedDialog = Dialog::createDialog($userId);
            $resultDialog = new DialogResource($cratedDialog);
        }

        // $authUserDialogs = UserDialog::where('user_id', $authUserId)->all();
        return response([
            'resultCode' => 1,
            '$authUserDialogs' => $authUserDialogs,
            // TODO wrong response
            'dialog' => $resultDialog,
            '$userId' => $userId,
            '$isDialogExist' => $isDialogExist
        ]);
    }
}
