<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function followeds()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'followed_id');

    }
    public function followers()
    {

        return $this->belongsToMany(User::class, 'followers', 'followed_id', 'user_id');

    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }



    protected static function booted()
    {
        static::created(function ($user) {
            $profile = new Profile;
            $profile->user_id = $user->id;
            $profile->name = $user->name;
            $profile->surname = $user->surname;
            $profile->email = $user->email;

            $profile->save();
            return $profile;
        });
    }
}
