<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    
}
