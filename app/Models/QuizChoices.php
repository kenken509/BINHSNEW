<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizChoices extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function quizQuestion(){
        return $this->belongsTo(QuizQuestion::class,'quiz_question_id', 'id');
    }
}
