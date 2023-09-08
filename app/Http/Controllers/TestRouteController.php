<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\SentQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\StudentActiveQuiz;
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
       

        $activeQuizzes = StudentActiveQuiz::where('student_id', '=', $userId)
                            ->where('status', '=', 'pending')
                            ->with(['quiz' => function ($query) {
                                $query->with(['question' => function  ($query) {
                                    $query->with('choices')->inRandomOrder();
                                }]);
                            }])
                            ->latest()->get();

        
        // $quizzes = SentQuiz::with(['quiz','section'])->latest()->get();
        // $currentUser = User::with('section')->where('id', '=', $userId)->first();
        // $userSection = $currentUser['section']['id'];
        
        // $currentDate = Carbon::now(); // Get the current date
        // $studentFinishedQuizzes = StudentQuizResult::all();

        // $quizzes = SentQuiz::with(['quiz' => function ($query) {
        //     $query->with(['question' => function ($query) {
        //         $query->inRandomOrder();
        //     }]);
        // }, 'section'])->whereDate('end_date', '>=', $currentDate)->where('section_id', '=', $userSection)->latest()->get();
        
        return inertia('Index/TestPages/StudentActiveQuiz',[
            'quizzes'   => $activeQuizzes,
        ]);
    }

    public function showBeginQuiz($activeId, $qId)
    {
        
        $quiz = Quiz::with(['question' => function ($query) {
            $query->with('choices')->inRandomOrder();
        }])->where('id', '=', $qId)->first();

        
        // Paginate the questions.
        

        return inertia('Index/TestPages/StudentTakeQuiz', [
            'quiz' => $quiz,
            'studentActiveQuizId' => $activeId,
        ]);
    }

    public function submitQuizResult(Request $request)
    {
        //{"studentId":8,"quizId":2,"gradingPeriod":"1st","studentScore":1,"quizGrade":"33.33","status":"done"}
        
        $studentQuiz = StudentActiveQuiz::findOrFail($request->studentActiveQuizId);

        $studentQuiz->quiz_score        = $request->studentScore;
        $studentQuiz->quiz_grade        = $request->quizGrade;
        $studentQuiz->status            = 'done';
        $studentQuiz->save();


        
        return redirect()->route('quiz.result')->with('success', 'Quiz Submitted Successfully!');
    }

    public function showQuizResults()
    {
        
        $loggedUser = Auth::user()->id;
        $studentQuizzes = StudentActiveQuiz::with(['quiz' => function ($query){
                            $query->with('question');
                        }])
                        ->where('student_id', '=', $loggedUser)
                        ->where(function ($query){
                            $query->where('status','=','done') 
                            ->orWhere('status', '=', 'lapse');
                        })
                        ->latest()
                        ->get();
       // dd($studentQuizzes);
        return inertia('Index/TestPages/StudentQuizResult',[
            'quizResults' => $studentQuizzes,
        ]);
    }
}
