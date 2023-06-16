<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
    
    public function user(){
        return $this->hasMany(User::class, 'section_id', 'id');
    }
}
