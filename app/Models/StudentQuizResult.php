<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentQuizResult extends Model
{
    use HasFactory;

    public function quiz()
    {
        return $this->belongsTo(Quiz::class,'quiz_id','id');
    }

    public function scopeFilteredData(Builder $query, $filters): Builder  //<< return type
    {
        return $query->when($filters, fn ($query) => $query->where('section_id','=',$filters));
    }
}
