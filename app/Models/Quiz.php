<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function question(){
        return $this->hasMany(QuizQuestion::class,'quiz_id','id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function activeQuiz()
    {
        return $this->hasMany(StudentActiveQuiz::class, 'quiz_id', 'id');
    }

    public function sentQuiz()
    {
        return $this->hasMany(SentQuiz::class, 'quiz_id', 'id');
    }
    
}
