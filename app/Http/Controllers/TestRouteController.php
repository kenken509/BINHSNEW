<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SentQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

        $quizzes = SentQuiz::with(['quiz' => function ($query) {
            $query->with(['question' => function ($query) {
                $query->inRandomOrder();
            }]);
        }, 'section'])->whereDate('end_date', '>=', $currentDate)->where('section_id', '=', $userSection)->latest()->get();
        
        return inertia('Index/TestPages/StudentActiveQuiz',[
            'quizzes' => $quizzes,
            'currentUser' => $currentUser,
        ]);
    }
}
