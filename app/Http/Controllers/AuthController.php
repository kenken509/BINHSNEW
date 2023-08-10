<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        
        
        
        $request->session()->regenerate(); // to avoid session fixation

        return redirect()->intended('/')->with('success', 'Logged in successfully'); // redirect to intended page
        

        
        
        
            
        
        //************************************************* */
        // if(!$user->email_verified_at){
        //     // send to verify-email view
        //     return redirect()->route('verify.show');
        // }else{
        //     $request->session()->regenerate(); // to avoid session fixation

        //     return redirect()->intended('/'); // redirect to intended page
        // }
        //********************************************************* */
        
        
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
            $newUser->subject_id        = $request->subject;
            $newUser->section_id        = $request->section;
            $newUser->isActive          = $request->isActive;
            $newUser->save();
            event(new Registered($newUser));

            return redirect()->route('login')->with('success', 'Successfully registered! ');
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

            return redirect()->route('login')->with('success', 'Successfully registered!');
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

        return redirect()->route('index')->with('success', 'Logged out successfully');
    }

    public function showChangePassword()
    {
        return inertia('Auth/ChangePassword');
    }

    public function showForgotPassword()
    {
        return inertia('Auth/ForgotPassword');
    }

    
}
