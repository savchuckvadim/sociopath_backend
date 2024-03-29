<?php

use App\Events\LoginEvent;
use App\Http\Controllers\DialogController;
use App\Http\Controllers\FollowersController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use App\Http\Resources\PostCollection;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/testauth', function () {
    $result = Auth::user();
    return $result;
});


Broadcast::routes(['middleware' => ['auth:sanctum']]);

// Route::post('/sanctum/token', function (Request $request) {
//     $request->validate([
//         'email' => 'required|email',
//         'password' => 'required',
//     ]);

//     $user = User::where('email', $request->email)->first();

//     if (! $user || ! Hash::check($request->password, $user->password)) {
//         throw ValidationException::withMessages([
//             'email' => ['The provided credentials are incorrect.'],
//         ]);
//     }

//     return $user->createToken($request->email)->plainTextToken;
// });


Route::get('/user/auth', function () {
    return UserController::getAuthUser();
});


Route::middleware(['auth:sanctum'])->group(function () {


    ///////////////TOKENS

    Route::post('/tokens/create', function (Request $request) {
        $token = $request->user()->createToken($request->token_name);
        return ['token' => $token->plainTextToken];
    });
    Route::post('/sanctum/token', TokenController::class);



    ///////////////USERS

    Route::get('/users', function (Request $request) {
        return UserController::getUsers($request);
    });

    Route::get('/users/{id}', function ($id) {
        return UserController::getUser($id);
    });

    Route::post('/follow', function (Request $request) {
        $currentUserId =  Auth::user()->id;
        $followedId = $request->userId;
        return FollowersController::follow($currentUserId, $followedId);
    });

    Route::delete('/follow/{userId}', function (Request $request) {
        $currentUserId =  Auth::user()->id;
        $followedId = $request->userId;
        return FollowersController::unfollow($currentUserId, $followedId);
    });



    ///////////////PROFILE

    Route::get('/profile/aboutme/{userId}', function ($userId) {
        return ProfileController::getAboutMe($userId);
    });

    Route::put('/profile/aboutme', function (Request $request) {
        $aboutMe = $request->aboutMe;
        return ProfileController::updateAboutMe($aboutMe);
    });




    ///////////////POSTS

    Route::post('/post', function (Request $request) {
        return PostController::newPost($request);
    });
    Route::get('/post/{profileId}', function ($profileId) {
        return PostController::getPosts($profileId);
    });

    Route::put('/post', function (Request $request) {
        return PostController::updatePost($request);
    });

    Route::post('/like', function (Request $request) {
        return LikeController::setLike($request->postId);
    });

    Route::delete('/like/{postId}', function ($postId) {
        return LikeController::deleteLike($postId);
    });



    //DIALOGS

    Route::get('dialogs', function () {
        //
        return UserController::getDialogs();
    });

    Route::get('dialog/{userId}', function ($userId) {
        //dialogId
        return DialogController::getOrCreateDialog($userId);
    });

    // Route::post('group-dialog', function (Request $request) {
    //     //$users, $dialogsName, $isGroup, id?=null if null->add else -> edit
    //     return DialogController::addGroupDialog($request, true);
    // });

    // Route::put('sound-dialog', function (Request $request) {
    //     //$dialogId, $isSound
    //     return DialogController::updateSound($request->dialogId, $request->isSound);
    // });

    // Route::delete('dialog/{dialogId}', function ($dialogId) {
    //     $dialog = Dialog::find($dialogId);
    //     if ($dialog) {
    //         $controller = new DialogController($dialog);
    //         return $controller->destroy($dialog);
    //     };
    //     return DialogController::getDialog($dialogId);
    // });



    //MESSAGES

    Route::get('/messages', function (Request $request) {
        return MessageController::getMessages($request);
    });

    Route::post('message', function (Request $request) {
        //dialogId, body, isForwarded, isEdited
        return MessageController::create($request->dialogId, $request->body, $request->isForwarded, $request->isEdited);
    });
    // Route::put('message', function (Request $request) {
    //     //dialogId, body, isForwarded, isEdited

    //     return MessageController::edit($request->messageId, $request->body);
    // });
    // Route::delete('message/{messageId}', function ($messageId) {
    //     //messageId

    //     return MessageController::destroy($messageId);
    // });


    // Route::get('messages/{dialogId}', function ($dialogId) {
    //     $dialog = Dialog::find($dialogId);
    //     $messages = null;
    //     if ($dialog) {
    //         $messages = DialogController::getMessages($dialog);
    //         return response([
    //             'resultCode' => 1,
    //             'messages' => $messages,

    //         ]);
    //     } else {
    //         return response([
    //             'resultCode' => 1,
    //             'messages' => []
    //         ]);
    //     }
    // });

    Route::get('/testingevent', function () {
        $user = Auth::user();
        LoginEvent::dispatch($user);
        return response([
            'результат' => 'задиспатчилось'
        ]);
    });
});


//Follow Unfollow





Route::get('garavatar/{userId}', function ($userId) {
    $user = User::find($userId)->first();
    return $user->getAvatarUrl();
});










////////////////////









Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
