<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    public function choices(){
        return $this->hasOne(Choice::class);
    }

    public function subjects(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
