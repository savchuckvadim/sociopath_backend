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
        $participant = null;
        $relation = UserDialog::where('user_id', $user->id)->where('dialog_id', $this->id)->first();
        $isSound = $relation->isSound;

        foreach ($dialogsUsers as $dialogsUser) {
            if ($dialogsUser->id !== $user->id) {
                // $userId = $dialogsUser->id;
                $participant = new UserRecource($dialogsUser);
            }
        }


        return [
            'id' => $this->id,
            'isSound' => $isSound,
            'participant' => $participant,
            'messages' => new MessageCollection($dialogsMessages),
  
        ];
    }
}
