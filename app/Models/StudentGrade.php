<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGrade extends Model
{
    use HasFactory;

    // public function scopeFilteredData(Builder $query, $filters): Builder  //<< return type
    // {
    //     return $query->when($filters) 
    //             ->when($filters == 'admin', fn ($query) => $query->where('role','admin'))
    //             ->when($filters == 'instructor', fn ($query) => $query->where('role','instructor'))
    //             ->when($filters == 'student', fn ($query) => $query->where('role','student'));
    // }

    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(User::class,'student_id','id');
    }
}
