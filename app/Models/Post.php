<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'body',
        'image',
        'author_id',
        'profile_id'
        
    ];

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
        return $this->belongsToMany(Like::class, 'author_id');
    }
    
}
