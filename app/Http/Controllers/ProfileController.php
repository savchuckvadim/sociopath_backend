<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function create($user)
    {
        $profile = Profile::create([
            'name' => $user->name,
            'surname' => $user->surname,
            'email' => $user->email,
            'user_id' => $user,
            'hero' => 'url//hero'

        ]);

        $profile->save();
        return $profile;
    }

    public static function getProfile($user_id)
    {
        return Profile::where('user_id', $user_id)->first();
    }

    public static function getAboutMe($user_id)
    {
        return Profile::where('user_id', $user_id)->first()->about_me;
    }
    public static function updateAboutMe($aboutMe)
    {
        if( Auth::user()){
            $authUserId = Auth::user()->id;
        }else{
            $authUserId = 21;
        }
       
        $profile = Profile::where('user_id', $authUserId)->first();
        $profile->about_me = $aboutMe;
        $profile->save();
        return $aboutMe;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
