<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\SentQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\StudentQuizResult;
use Illuminate\Support\Facades\Auth;

class TestRouteController extends Controller
{
    public function showTestRoute(){
         
        return view('testViews/OtpMail');
    }

    public function showTakeQuiz()
    {
        $quizzes = SentQuiz::with(['quiz','section'])->latest()->get();

        return inertia('Index/TestPages/TakeQuizAll',[
            'quizzes' => $quizzes,
        ]);
    }

    public function showActiveQuiz()
    {
        $userId = Auth::user()->id;
       
        // $quizzes = SentQuiz::with(['quiz','section'])->latest()->get();
        $currentUser = User::with('section')->where('id', '=', $userId)->first();
        $userSection = $currentUser['section']['id'];
        
        $currentDate = Carbon::now(); // Get the current date
        $studentFinishedQuizzes = StudentQuizResult::all();

        $quizzes = SentQuiz::with(['quiz' => function ($query) {
            $query->with(['question' => function ($query) {
                $query->inRandomOrder();
            }]);
        }, 'section'])->whereDate('end_date', '>=', $currentDate)->where('section_id', '=', $userSection)->latest()->get();
        
        return inertia('Index/TestPages/StudentActiveQuiz',[
            'quizzes'                   => $quizzes,
            'currentUser'               => $currentUser,
            'studentFinishedQuizzes'    => $studentFinishedQuizzes,
        ]);
    }

    public function showBeginQuiz($id)
    {
        $quiz = Quiz::with(['question' => function ($query) {
            $query->with('choices')->inRandomOrder();
        }])->where('id', '=', $id)->first();

        
        // Paginate the questions.
        

        return inertia('Index/TestPages/StudentTakeQuiz', [
            'quiz' => $quiz,
        ]);
    }

    public function submitQuizResult(Request $request)
    {
       

        $quizResults = new StudentQuizResult();

        $quizResults->student_id        = $request->studentId;
        $quizResults->quiz_id           = $request->quizId;
        $quizResults->grading_period    = $request->gradingPeriod;
        $quizResults->quiz_score        = $request->studentScore;
        $quizResults->quiz_grade        = $request->quizGrade;
        $quizResults->status            = $request->status;
        $quizResults->save();

        return redirect()->route('quiz.result')->with('success', 'Quiz Submitted Successfully!');
    }

    public function showQuizResults()
    {
        $studentQuizzes = StudentQuizResult::with('quiz')->latest()->get();
        return inertia('Index/TestPages/StudentQuizResult',[
            'quizResults' => $studentQuizzes,
        ]);
    }
}
