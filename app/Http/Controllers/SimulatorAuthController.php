<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SchoolYear;
use Illuminate\Support\Str;
use App\Models\StudentGrade;
use Illuminate\Http\Request;
use App\Mail\OtpVerification;
use App\Models\StudentActiveQuiz;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
                            // ->where('status', '=', 'pending')
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
        //dd($request);

        
       
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
                    DB::beginTransaction();

                    $QuizToUpdate->quiz_score = $request->quiz_score;
                    $QuizToUpdate->quiz_grade = $request->quiz_grade;

                    if($request->quiz_grade >= 75.00)
                    {
                        $QuizToUpdate->status = "passed";
                    }
                    else
                    {
                        $QuizToUpdate->status = "failed";
                    }
                    
                    $QuizToUpdate->save();
                    
                    //['First Grading','Second Grading','Third Grading', 'Fifth Grading']
                    if($QuizToUpdate->grading_period == 'First Grading'){

                        try{
                            //get all the student quizzes and get the average grade
                            $studentFistGradingAverage = StudentActiveQuiz::where('student_id', '=', $request->id)
                                    ->where('grading_period','=', 'First Grading')
                                    ->get()->avg('quiz_grade');
                            
                            

                            $studentGrades = StudentGrade::where('student_id', $request->id)->first();
                            
                            if($studentGrades)
                            {
                                $studentGrades->first_grading = $studentFistGradingAverage;
                                $studentGrades->save();
                            }
                            else
                            {
                                $newStudentGrades = new StudentGrade();
                                $newStudentGrades->student_id = $request->id;
                                $newStudentGrades->first_grading = $studentFistGradingAverage;
                                $newStudentGrades->save();
                            }                           
                        }
                        catch(\Exception $e){
                            return response()->json(["status:" => 'FAILED TO UPDATE  STUDENT 1ST GRADING PEROID']);
                        }
                    }

                    if($QuizToUpdate->grading_period == 'Second Grading'){

                        try{

                            $studentSecondGradingAverage = StudentActiveQuiz::where('student_id', '=', $request->id)
                                    ->where('grading_period','=', 'Second Grading')
                                    ->get()->avg('quiz_grade');
                            
                            

                            $studentGrades = StudentGrade::where('student_id', $request->id)->first();
                            
                            if($studentGrades)
                            {
                                $studentGrades->second_grading = $studentSecondGradingAverage;
                                $studentGrades->save();
                            }
                            else
                            {
                                $newStudentGrades = new StudentGrade();
                                $newStudentGrades->student_id = $request->id;
                                $newStudentGrades->second_grading = $studentSecondGradingAverage;
                                $newStudentGrades->save();
                            }                           
                        }
                        catch(\Exception $e){
                            return response()->json(["status:" => 'FAILED TO UPDATE  STUDENT 2ND GRADING PEROID']);
                        }
                        

                    }

                    if($QuizToUpdate->grading_period == 'Third Grading'){

                        try{

                            $studentThirdGradingAverage = StudentActiveQuiz::where('student_id', '=', $request->id)
                                    ->where('grading_period','=', 'Third Grading')
                                    ->get()->avg('quiz_grade');
                            
                            

                            $studentGrades = StudentGrade::where('student_id', $request->id)->first();
                            
                            if($studentGrades)
                            {
                                $studentGrades->third_grading = $studentThirdGradingAverage;
                                $studentGrades->save();
                            }
                            else
                            {
                                $newStudentGrades = new StudentGrade();
                                $newStudentGrades->student_id = $request->id;
                                $newStudentGrades->third_grading = $studentThirdGradingAverage;
                                $newStudentGrades->save();
                            }                           
                        }
                        catch(\Exception $e){
                            return response()->json(["status:" => 'FAILED TO UPDATE  STUDENT 3RD GRADING PEROID']);
                        }
                        

                    }

                    if($QuizToUpdate->grading_period == 'Fourth Grading'){

                        try{

                            $studentFourthGradingAverage = StudentActiveQuiz::where('student_id', '=', $request->id)
                                    ->where('grading_period','=', 'Fourth Grading')
                                    ->get()->avg('quiz_grade');
                            
                            

                            $studentGrades = StudentGrade::where('student_id', $request->id)->first();
                            
                            if($studentGrades)
                            {
                                $studentGrades->fourth_grading = $studentFourthGradingAverage;
                                $studentGrades->save();
                            }
                            else
                            {
                                $newStudentGrades = new StudentGrade();
                                $newStudentGrades->student_id = $request->id;
                                $newStudentGrades->fourth_grading = $studentFourthGradingAverage;
                                $newStudentGrades->save();
                            }                           
                        }
                        catch(\Exception $e){
                            return response()->json(["status:" => 'FAILED TO UPDATE  STUDENT 3RD GRADING PEROID']);
                        }
                        

                    }
                    
                    DB::commit();
                    return response()->json(["status" => "Graded Successfully!"]);
                }catch(\Exception $e){
                    return response()->json(["status" => "ERROR : FAILED TO SUBMIT GRADES!!"]);
                }
                
            }
        }
        else
        {
            DB::rollBack();
            return responso()->json(["status" => "Error: FAILED TO SUBMIT GRADES!!"]);
        }
        
    
    }

    // sanctum test controllers ***********************************************

    public function simulatorAppLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Check if the authenticated user is active
            
            $user = Auth::user();
            if ($user->isActive == '1') {
                $token = $user->createToken('authToken')->plainTextToken;
                
                
                
                $mailData = [
                    'otpCode' => Str::random(6),
                ];
        
                
                Mail::to($user->email)->send(new OtpVerification($mailData));
                date_default_timezone_set('Asia/Manila');
        
                $user->otp = $mailData['otpCode'];
                $user->expires_at = now()->addMinutes(10);
                $user->save();
                
                //Auth::login();
                Auth::logout(); // to log out the user;
                
                //$request->session()->invalidate(); //invalidate the session
                //$request->session()->regenerateToken();

                
                $otpExpiration = 10;
                


                return response()->json(['token' => $token, 'user' => $user, 'message' => 'verify OTP', 'otpExpiration' => $otpExpiration], 200);
            } else {
                // User is not active
                Auth::logout(); // Logout the user if they are not active
                return response()->json(['message' => 'Authentication Failed! user not active']);
            }
        }

        // Authentication failed
        return response()->json(['message' => 'Authentication Failed!']);
    }

    public function simAuthOtp(Request $request)
    {
       
        //parameter 
        //opt, userId
        $otp = $request->otp;
        
        
        $user               = User::findOrFail($request->userId);
        $currentSchooYear   = SchoolYear::first();
        
        if($user->expires_at && now()->lessThan($user->expires_at))
        {
            if($user->otp == $otp)
            {
                //Auth::login($user);
                
                $user->otp = null;
                $user->expires_at = null;
                $user->save();


                //$request->session()->regenerate();
                
                // $token = $user->createToken('authToken')->plainTextToken;
                
                return response()->json(['user' => $user, 'message' => 'OTP verified successfully!', 'currentSchooYear' => $currentSchooYear->year], 200);
            }
            else
            {
                return response()->json(['message' => 'OTP does not match! Or OTP has expireddddd', 'otp' => $request->otp , 'userOtp' => $user->otp]);
            }
        }
        else
        {
            return response()->json(['error' => 'OTP does not match! Or OTP has expired ']);
        }
    }

    public function simResendOtp($id)
    {
        $user = User::findOrFail($id);
        

        $mailData = [
            'otpCode' => Str::random(6),
        ];

        
        Mail::to($user->email)->send(new OtpVerification($mailData));
        date_default_timezone_set('Asia/Manila');

        $user->otp = $mailData['otpCode'];
        $user->expires_at = now()->addMinutes(10);
        $user->save();

        return response()->json(['message' => 'OTP sent successfully! ' ]);
    }

    public function simLogout(Request $request)
    {
        $user = User::findOrFail($request->userId);

        if($user)
        {
            $user->tokens()->delete();

            return response()->json(['message' => 'Logged out successfully!']);
        }

        
    }
}
