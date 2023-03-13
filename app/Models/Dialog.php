<?php

namespace App\Models;

use App\Http\Resources\DialogResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Dialog extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_dialogs', 'dialog_id', 'user_id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public static function createDialog($userId)
    {

        $authUser = Auth::user();
        $authUserId = $authUser->id;
        $dialog = Dialog::create();
        // $dialog->isGroup = $request->isGroup;
        $userDialogRelations = UserDialog::create([
            'user_id' => $authUserId,
            'dialog_id' => $dialog->id
        ]);
        $contactDialogRelations = UserDialog::create([
            'user_id' => $userId,
            'dialog_id' => $dialog->id
        ]);
        $dialog->save();
        $userDialogRelations->save();
        $contactDialogRelations->save();
        $dialogResource = new DialogResource($dialog);
        return $dialogResource;
    }
}
