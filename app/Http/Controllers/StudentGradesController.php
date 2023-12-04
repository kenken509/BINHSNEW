<?php

namespace App\Http\Controllers;

use App\Models\StudentGrade;
use Illuminate\Http\Request;

class StudentGradesController extends Controller
{
    public function show()
    {
        // $activeQuizzes = StudentActiveQuiz::where('student_id', '=', $id)
        //                     // ->where('status', '=', 'pending')
        //                     ->with(['quiz' => function ($query) {
        //                         $query->with(['question' => function  ($query) {
        //                             $query->with('choices')->inRandomOrder();
        //                         }]);
        //                     }])
        //                     ->latest()->get();


        $studentGrades = StudentGrade::with(['student' => function ($query) {
            $query->where('role', '=', 'student')
                ->with(['studentActiveQuiz' => function ($query) {
                    $query->whereIn('status', ['passed', 'failed']);
                }])->with('section');
        }])->get();

        
        return inertia('AdminDashboard/AdminPages/StudentGrades/InstructorPage/StudentGradesAll',[
            'studentGrades' => $studentGrades,
        ]);
        
    }
}
