<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Section;
use App\Models\User;
use App\Models\StudentGrade;
use Illuminate\Http\Request;


class StudentGradesController extends Controller
{
    public function show()
    {
        
        
        $instructorSections = User::where('id',Auth::user()->id)->with('instructorSections')->first();
           
        $studentGrades = StudentGrade::with(['student' => function ($query) {
            $query->where('role', '=', 'student')
                ->with(['studentActiveQuiz' => function ($query) {
                    $query->whereIn('status', ['passed', 'failed'])
                        ->with(['quiz' => function ($query){
                            $query->with('question');
                        }]);
                }])->with('section');
        }])->get();
        
        
        return inertia('AdminDashboard/AdminPages/StudentGrades/InstructorPage/StudentGradesAll',[
            'studentGrades' => $studentGrades,
        ]);
        
    }
}
