<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\OtpVerification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function create(){ // presents a form that allows you to submit something
        return inertia('Auth/Login');
    }
    
    public function store(Request $request){ // create session if the data sent is valid which means there is a valid user name
        
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        
        $credentials['isActive'] = '1'; // Add the 'status' field to the credentials
        
        if (!Auth::attempt($credentials, $request->has('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Authentication failed or account not activated',
            ]);
        }
        
        $user = User::where('email', $request->email)
        ->where('isActive','1')
        ->first();
        
        $mailData = [
            'otpCode' => Str::random(6),
        ];

        
        Mail::to($user->email)->send(new OtpVerification($mailData));
        date_default_timezone_set('Asia/Manila');

        $user->otp = $mailData['otpCode'];
        $user->expires_at = now()->addMinutes(10);
        $user->save();

        Auth::logout(); // to log out the user;
        
        $request->session()->invalidate(); //invalidate the session
        $request->session()->regenerateToken(); // regenerate csrf token

        // $request->session()->regenerate(); // to avoid session fixation

        // return redirect()->intended('/')->with('success', 'Logged in successfully'); // redirect to intended page

        
        return redirect()->route('otpVerification.show', ['id' => $user->id] )->with('message', 'Check your email for OTP code.');
       
    }
    
    public function showRegistration(){

        $subjects = Subject::with('section')->get();
        return inertia('Auth/Register', [
            'subjects' => $subjects,
        ]);
    }

    public function storeGuest(Request $request){
        
        $request->validate([
            'role' => 'required',
        ]);

        $rules = [
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
                'confirmed'
            ]
        ];

        $customMessages = [
            'subject.required_if' => 'The subject field is required.',
            'section.required_if' => 'The section field is required.',
            'fName'               => 'First name field is required',
            'lName'               => 'Last name field is required',
            'student_number'      => 'Student number field is required',
        ];

        if($request->role == 'student')
        {
            
            $student = $request->validate([
                'fName'             => 'required',
                'lName'             => 'required',
                'student_number'    => 'required',
                'email'             => 'required|email|unique:users',
                'password'          => $rules['password'],
                'role'              => 'required',
                'isActive'          => 'required',
                'subject'           => 'required_if:role,student',
                'section'           => 'required_if:role,student',
            ],$customMessages);

            $newUser = new User();

            $newUser->fName             = $request->fName;
            $newUser->lName             = $request->lName;
            $newUser->student_number    = $request->student_number;
            $newUser->email             = $request->email;
            $newUser->password          = $request->password;
            $newUser->role              = $request->role;
            $newUser->school_year       = $request->currentSchoolYear;
            $newUser->subject_id        = $request->subject;
            $newUser->section_id        = $request->section;
            $newUser->isActive          = $request->isActive;
            $newUser->save();
            event(new Registered($newUser));

            return redirect()->route('login')->with('success', 'Successfully registered! Please check your email for verification! ');
        }

        if($request->role == 'guest')
        {
            
            $user = User::make($request->validate([
                'email' => 'required|email|unique:users',
                'password' => $rules['password'],
                'role' => 'required',
                'isActive' => 'required',
            ]));

            $user->save();
            event(new Registered($user));

            return redirect()->route('login')->with('success', 'Successfully registered! Please check your email for verification!');
        }

        
        // $user = User::make($request->validate([
        //     'email' => 'required|email|unique:users',
        //     'password' => $rules['password'],
        //     'role' => 'required',
        //     'isActive' => 'required',
        //     'subject' => 'required_if:role,student',
        //     'section' => 'required_if:role,student',
        // ],$customMessages));
        
        
        //$user->role = $request->role;
        

        
        
    }

    public function changePassword(Request $request)
    {
        $userEmail = Auth::user()->email;
        $request->validate([
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        $user = User::where('email', $userEmail)->first();
        
        if(!$user)
        {
            return redirect()->redirect('login')->with('error', 'Failed to change password');
        }
        
        $user->password = $request->password;
        $user->save();

        return redirect()->route('index')->with('success', 'Successfully changed password');

        
    }

    public function destroy(Request $request){ // destroy the current user session (log out)
        Auth::logout();

        $request->session()->invalidate(); //invalidate the session
        $request->session()->regenerateToken(); // regenerate csrf token

        return redirect()->route('index')->with('success', 'Signed out successfully');
    }

    public function showChangePassword()
    {
        return inertia('Auth/ChangePassword');
    }

    public function showForgotPassword()
    {
        return inertia('Auth/ForgotPassword');
    }

    public function showOtpVerification($id)
    {
        $attemptingUser = User::findOrFail($id);
        return inertia('Auth/OtpVerification',[
            'attemptingUser' => $attemptingUser,
        ]);
    }

    public function authOtp(Request $request)
    {
       
        $otp = $request->otp;
        $user = User::findOrFail($request->userId);

        
        if($user->expires_at && now()->lessThan($user->expires_at))
        {
            if($user->otp == $otp)
            {
                Auth::login($user);
                
                $user->otp = null;
                $user->expires_at = null;
                $user->save();

                $request->session()->regenerate();
                
                return redirect()->route('index')->with('success', 'Signed in successfully');
            }
            else
            {
                throw ValidationException::withMessages([
                    'otp' => 'OTP does not match! Or OTP has expired',
                ]);
            }
        }
        else
        {
            throw ValidationException::withMessages([
                'otp' => 'OTP does not match! Or OTP has expired',
            ]);
        }
        
        
    }

    public function resendOtp($id)
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

        return redirect()->route('otpVerification.show', ['id' => $user->id] )->with('message', 'OTP sent successfully!');
    }
}
