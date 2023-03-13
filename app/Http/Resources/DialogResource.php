<?php

namespace App\Http\Resources;

use App\Models\UserDialog;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class DialogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $user = Auth::user();
        $dialogsUsers = $this->users;
        $dialogsMessages = $this->messages;
        $isSound = false;
        $dialogsUser = null;
        $relation = UserDialog::where('user_id', $user->id)->where('dialog_id', $this->id)->first();
        $isSound = $relation->isSound;
        // if (count($relations) > 0) {
        //     $isSound = $relations[0]->isSound;
        // }
        // $userId = null;
        foreach ($dialogsUsers as $dialogsUser) {
            if ($dialogsUser->id !== $user->id) {
                // $userId = $dialogsUser->id;
                $dialogsUser = new UserRecource($dialogsUser);
            }
        }


        return [
            'id' => $this->id,
            // 'userId'=> $userId,
            // 'dialogName' => $this->name,
            // 'isGroup' => $this->isGroup,
            'isSound' => $isSound,
            'participant' => $dialogsUser,
            'messages' => new MessageCollection($dialogsMessages),
            // '$relation' => $relation,
            // '$request' => $request

        ];
    }
}
