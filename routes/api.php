<?php

use App\Events\LoginEvent;
use App\Http\Controllers\FollowersController;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;


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


Broadcast ::routes(['middleware' => ['auth:sanctum']]);

Route::get('/user/auth', function () {
    return UserController::getAuthUser();
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/users', function (Request $request) {
        return UserController::getUsers($request);
    });

    Route::get('/users/{id}', function ($id) {
        return UserController::getUser($id);
    });

    // Route::get('/profile/{userId}', function ($userId) {
    //     return ProfileController::getProfile($userId);
    // });





    Route::get('/testingevent', function () {
        $user = Auth::user();
        LoginEvent::dispatch($user);
        return response([
            'результат' => 'задиспатчилось'
        ]);
    });
});


// Route::get('/user/auth', function () {
//   // if (Auth::user()->data) {
//   //   return Auth::user()->data;
//   // } else {
//   //   return false;
//   // }
//   return Auth::user();
// });






//Follow Unfollow

// Route::get('/follow/{id}', function ($id) {
//   // $currentUserId =  Auth::user()->id;
//   return FollowersController::follow(1, $id);
// });


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









///////////////POSTS
Route::post('/post', function (Request $request) {
    return PostController::newPost($request);
});
Route::get('/post/{profileId}', function ($profileId) {
    // return PostController::getPosts($profileId);

    $posts = Post::where('profile_id', $profileId)->get();
    $paginate = Post::paginate(5);
    $collection = new PostCollection($posts);

    return $collection->values();
});

Route::put('/post', function (Request $request) {
    return PostController::updatePost($request);
});

Route::post('/like', function (Request $request) {
    $like = new Like;
    $like->post_id = $request->postId;
    $like->author_id = Auth::user()->id;
    $like->save();

    return response(([
        'like' => $like,
        'resultCode' => 1
    ]
    ));
});

Route::delete('/like/{postId}', function ($postId) {
    $authUserId = Auth::user()->id;
    $postsLikes = Like::where('post_id', $postId);
    $like = $postsLikes->where('author_id', $authUserId);
    $like->delete();
    $result = Like::where('post_id', $postId);

    return response(([
        'removedLike' => $like,
        'resultCode' => 1
    ]
    ));
});
////////////////////






Route::post('/sanctum/token', TokenController::class);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});
