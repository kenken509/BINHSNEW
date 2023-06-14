<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;

class QuizManagementController extends Controller
{
    public function show(){

        //dd(Quiz::with(['question','subject'])->latest()->get());
        return inertia('AdminDashboard/AdminPages/ExaminationManagement/QuizManagement/QuizAll', [
            'quizzes' => Quiz::with(['question','subject'])->latest()->get(),
        ]);

    }

    public function create(){
        return inertia('AdminDashboard/AdminPages/ExaminationManagement/QuizManagement/QuizAdd');
    }
}
