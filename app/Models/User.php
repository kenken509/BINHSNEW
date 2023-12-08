<?php

namespace App\Models;

use App\Models\Section;
use App\Models\Subject;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    // Change date format
    protected $casts = [
        'birthDate' => 'datetime:m/d/Y', 
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $guarded = [];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    

    // camelCase kebab_case
    protected function password(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value,
            set: fn (string $value) => Hash::make($value),
        );
    }

    // local scope queries
    public function scopeDescendingQuery($query){
        return $this->orderByDesc('created_at');
    }

    public function scopeAscendingQuery($query){
        return $this->orderBy('created_at','asc');
    }

    public function scopeFilteredData(Builder $query, $filters): Builder  //<< return type
    {
        return $query->when($filters) 
                ->when($filters == 'admin', fn ($query) => $query->where('role','admin'))
                ->when($filters == 'instructor', fn ($query) => $query->where('role','instructor'))
                ->when($filters == 'student', fn ($query) => $query->where('role','student'));
    }

    //relations

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id', 'id'); //fist param model , second is the foreignkey in the model table, 3rd is the local key in the user's table)
    }
    
    public function section(){
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function instructorSections()
    {
        return $this->belongsToMany(Section::class, 'instructor_sections', 'instructor_id', 'section_id');
    }
    

    public function posts(){
        return $this->belongsTo(WebPost::class,'author_id', 'id');
    }

    public function aboutPagePost()
    {
        return $this->hasMany(aboutPagePost::class,'created_by','id');
    }

    public function studentActiveQuiz()
    {
        return $this->hasMany(StudentActiveQuiz::class, 'student_id', 'id');
    }

    public function reactions()
    {
        return $this->hasMany(PostReactions::class, 'user_id', 'id');
    }

    public function grade()
    {
        return $this->hasOne(StudentGrade::class,'student_id', 'id');
    }
}
