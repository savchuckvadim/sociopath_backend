<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use App\Http\Resources\MessageCollection;
use App\Http\Resources\MessageResource;
use App\Models\Dialog;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public static function create($dialogId, $body, $isForwarded, $isEdited)
    {
        //dialogId, body, isForwarded, isEdited
        $author = Auth::user();
        $touchUser = User::find($author->id);
        $touchUser->touch();
        $message = new Message();
        $message->dialog_id = $dialogId;
        $message->body = $body;
        $message->author_id = $author->id;
        $message->isForwarded = $isForwarded;
        $message->isEdited = $isEdited;

        $message->save();


        //DISPATCH EVENT
        $recipients = $message->recipients();
        foreach ($recipients as $recipient) {
            SendMessage::dispatch($message, $recipient->id);
        }


        //SEND NOTIFICATION
        // $recipients = $message->recipients();
        // Notification::send($recipients, new NewMessage($message));

        $message->isAuthorIsAuth = true;
        return response([
            'resultCode' => 1,
            'createdMessage' => new MessageResource($message),

        ]);
    }

    public static function getMessages($request)
    // $request=>dialogId
    // currentPage
    // pageSize
    {
        $resultCode = 0;
        $authUser = Auth::user();

        if ($authUser) {
            $resultCode = 1;

            $itemsCount = $request->query('count');
            $dialogId = $request->query('dialogId');
            $paginate =  Message::where('dialog_id', $dialogId)->orderBy('created_at', 'desc')->paginate($itemsCount);
            $collection = new MessageCollection($paginate);
            return response([
                'resultCode' => $resultCode,
                'messages' => $collection,
            ]);

        } else {
            return response([
                'resultCode' => $resultCode,
                'message' => 'auth user is nod defined !'
            ]);
        }
    }
}
