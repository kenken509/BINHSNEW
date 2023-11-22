<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostReaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(WebPost::class, 'web_post_id', 'id');
    }

    public function reactingUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
