<?php

use App\Http\Controllers\FollowersController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TokenController;
use App\Http\Resources\PostCollection;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserRecource;
use App\Models\Followers;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
use App\Models\User;
use Illuminate\Support\Facades\Auth;


Route::get('/testauth', function () {
  $result = Auth::user();
  return $result;
});





Route::middleware(['auth:sanctum'])->group(function () {
  Route::get('/users', function (Request $request) {

    $itemsCount = $request->query('count');
    $paginate = User::paginate($itemsCount);
    $collection = new UserCollection($paginate);

    return $collection;
  });
  Route::get('/profile/{userId}', function ($userId) {
    // $user_id = $request->data->userId;

    return ProfileController::getProfile($userId);
  });



  Route::get('/users/{id}', function ($id) {
    return new UserRecource(User::findOrFail($id));
  });

  Route::get('/profile/aboutme/{userId}', function ($userId) {
    // $user_id = $request->data->userId;

    return ProfileController::getAboutMe($userId);
  });
});

Route::get('/user/auth', function () {

  $authUser = Auth::user();
  // $id = $auth->id;
  $userResource = null;
  if ($authUser) {
    $userResource = new UserRecource($authUser);
  }


  return $userResource;
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












///////////////POSTS
Route::post('/post', function (Request $request) {
  return PostController::newPost($request);
});
Route::get('/post/{profileId}', function ($profileId) {
  // return PostController::getPosts($profileId);

  
  $paginate = Post::paginate(5);
  $collection = new PostCollection($paginate);

  return $collection;
});

Route::put('/post', function (Request $request) {
  return PostController::updatePost($request);
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
