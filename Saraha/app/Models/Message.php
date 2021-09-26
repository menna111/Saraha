<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'content', 'user_id',
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }
}
