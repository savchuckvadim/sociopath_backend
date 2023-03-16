<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/


Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    // return (int) $user->id === (int) $id;
    return true;
});
// Broadcast::channel('channel', function () {
//     // ...
// }, ['guards' => ['web']]);

// Broadcast ::routes(['middleware' => ['auth:sanctum']]);
Broadcast::channel('test-chanel.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Broadcast::channel('send-post', function () {
//     return true;
// }, ['guards' => ['web']]);
Broadcast::channel('send-post', function () {
    return true;
});

Broadcast::channel('socio-chat', function ($user) {
    return $user->id;
});

Broadcast::channel('new-message.{userId}', function ($user) {

    $authUser = Auth::user();
    $authUserId = $authUser->id;

    return (int) $authUserId === (int) $user->id;
});
