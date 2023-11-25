<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SchoolYear;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\OtpVerification;
use App\Models\StudentActiveQuiz;
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
