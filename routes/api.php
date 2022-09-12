<?php

use App\Events\LoginEvent;
use App\Http\Controllers\FollowersController;
use App\Http\Controllers\LikeController;
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
    Route::post('/tokens/create', function (Request $request) {
        $token = $request->user()->createToken($request->token_name);
    
        return ['token' => $token->plainTextToken];
    });
    Route::post('/sanctum/token', TokenController::class);

    Route::get('/users', function (Request $request) {
        return UserController::getUsers($request);
    });

    Route::get('/users/{id}', function ($id) {
        return UserController::getUser($id);
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



    Route::get('/testingevent', function () {
        $user = Auth::user();
        LoginEvent::dispatch($user);
        return response([
            'результат' => 'задиспатчилось'
        ]);
    });
});


//Follow Unfollow


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


Route::put('/profile/aboutme', function (Request $request) {
    $aboutMe = $request->aboutMe;

    return ProfileController::updateAboutMe($aboutMe);
});
Route::get('/profile/aboutme/{userId}', function ($userId) {
    // $user_id = $request->data->userId;

    return ProfileController::getAboutMe($userId);
});


Route::get('garavatar/{userId}', function ($userId) {
    $user = User::find($userId)->first();
    return $user->getAvatarUrl();
});










////////////////////









Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


