<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentActiveQuiz extends Model
{
    use HasFactory;

    public function quiz()
    {
        return $this->belongsTo(Quiz::class,'quiz_id','id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }
}
