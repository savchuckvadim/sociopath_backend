<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDialog extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'user_id',
        'dialog_id'
    ];
}
