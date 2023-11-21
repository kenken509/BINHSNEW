<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\StudentActiveQuiz;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SimulatorAuthController extends Controller
{
    public function simLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        
    //     if(!Auth::attempt($request->validate([  //($request validation, remember me)
    //         'email' => 'required | string | email',
    //         'password' => 'required | string'
    //    ])

        $exist = User::where('email', $request->email)->with('subject')->first();
        
        if ($exist && Hash::check($request->password, $exist->password) ) {
            // Authentication successful
            $user = $exist;
            
            $activeQuizzes = StudentActiveQuiz::where('student_id', '=', $user->id)
                            ->where('status', '=', 'pending')
                            ->with(['quiz' => function ($query) {
                                $query->with(['question' => function  ($query) {
                                    $query->with('choices')->inRandomOrder();
                                }]);
                            }])
                            ->latest()->get();
            // query student active quiz;

            return response()->json(['message' => 'Login successfully!!!', 'user' => $user, 'activeQuizzes' => $activeQuizzes], 200);
        } else {
            // Authentication failed
            return response()->json(['message' => 'Invalid credentials'],401);
        }
    }

    public function getActiveQuiz($id)
    {
        
        $activeQuizzes = StudentActiveQuiz::where('student_id', '=', $id)
                            ->where('status', '=', 'pending')
                            ->with(['quiz' => function ($query) {
                                $query->with(['question' => function  ($query) {
                                    $query->with('choices')->inRandomOrder();
                                }]);
                            }])
                            ->latest()->get();

        return response()->json(['activeQuizzes' => $activeQuizzes]);
    }

    public function activeQuizGrade(Request $request)
    {
        //dd($request);
        //id
        //quiz_id
        //quiz_score
        //quiz_grade
        return response()->json(["status" => $request]);
         $QuizToUpdate = StudentActiveQuiz::where('student_id', '=', $request->id)
                                             ->where('quiz_id', '=', $request->quiz_id)->first();
                                             
        
        
            
        
        if($QuizToUpdate != null)
        {
            
            if($QuizToUpdate->quiz_grade) // if graded
            {
                return response()->json(['status' => "Existing Grade Found!"]);
            }
            else
            {
                try{
                    
                    $QuizToUpdate->quiz_score = $request->quiz_score;
                    $QuizToUpdate->quiz_grade = $request->quiz_grade;
                    $QuizToUpdate->status = "done";
                    $QuizToUpdate->save();

                    return response()->json(["status" => "Graded Successfully!"]);
                }catch(\Exception $e){
                    return response()->json(["status" => "ERROR : FAILED TO SUBMIT GRADES!!"]);
                }
                
            }
        }
        
    
    }
}
