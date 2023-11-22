<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebPost extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function author(){
        return $this->belongsTo(User::class,'author_id', 'id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'web_post_id', 'id');
    }
    
    public function attachments()
    {
        return $this->hasMany(WebPostAttachment::class,'web_post_id','id');
    }

    public function reactions()
    {
        return $this->hasMany(PostReaction::class, 'web_post_id', 'id');
    }

    public function userHasReacted(User $user)
    {
        return $this->reactions()->where('user_id', $user->id)->exists();
    }

    
}
