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
    
    // public function user(){
    //     return $this->hasMany(User::class, 'section_id', 'id');
    // }

    // has many relationship
    // public function instructor(){
    //     return $this->belongsTo(User::class, 'instructor_id', 'id');
    // }
    

    // many to many relationship
    public function instructors(){
        return $this->belongsToMany(User::class, 'instructor_sections', 'section_id', 'instructor_id'); 
    }
    
    public function student()
    {
        return $this->hasMany(User::class, 'section_id', 'id');
    }
}
