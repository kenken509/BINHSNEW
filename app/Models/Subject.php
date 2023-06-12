<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->hasMany(User::class,'subject_id', 'id');
    }

    public function question(){
        return $this->hasMany(Question::class,'subject_id','id');
    }
}
