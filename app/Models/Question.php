<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function choices(){
        return $this->hasOne(Choice::class,'question_id','id');
    }

    public function subjects(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
