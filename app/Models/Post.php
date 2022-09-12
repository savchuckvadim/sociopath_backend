<?php

namespace App\Models;

use App\Http\Resources\UserRecource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'body',
        'image',
        'author_id',
        'profile_id',
        // 'isAuthLikes',



    ];

    public function getAuthor()
    {
        $authorId = $this->author();
        return new UserRecource ($authorId);
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id');
    }
    public function isAuthLikes()
    {
        $isLike = false;
        $authUserId = Auth::user()->id;
        $likes = $this->likes;
        $authLikes = $likes->where('author_id', $authUserId);

            if (count($authLikes) > 0) {
                $isLike = true;
            }
     

        return $isLike;
    }
}
