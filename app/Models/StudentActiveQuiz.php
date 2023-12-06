<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    public function scopeFilteredData(Builder $query, $filters): Builder
    {
        return $query->when($filters, function ($query) use ($filters) {
            return $query->where('section_id', '=', $filters);
        });
    }


    public function sentQuiz()
    {
        return $this->belongsTo(SentQuiz::class, 'sent_quizzes_id ', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id ', 'id');
    }

}
