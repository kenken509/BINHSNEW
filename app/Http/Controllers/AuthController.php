<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function create(){ // presents a form that allows you to submit something

        
        return inertia('Auth/Login');
    }

    public function store(Request $request){ // create session if the data sent is valid which means there is a valid user name
        
       
       if(!Auth::attempt($request->validate([  //($request validation, remember me)
            'email' => 'required | string | email',
            'password' => 'required | string'
       ]),true)){
            throw ValidationException::withMessages([
                'email' => 'Authentication failed!'
            ]);
        }
        
        $user = User::where('email', $request->email)->first();
        

        //************************************************* */
        // if(!$user->email_verified_at){
        //     // send to verify-email view
        //     return redirect()->route('verify.show');
        // }else{
        //     $request->session()->regenerate(); // to avoid session fixation

        //     return redirect()->intended('/'); // redirect to intended page
        // }
        //********************************************************* */
        
        $request->session()->regenerate(); // to avoid session fixation

        return redirect()->intended('/')->with('success', 'Logged in successfully'); // redirect to intended page
    }

    public function showRegistration(){
        return inertia('Auth/Register');
    }

    public function storeGuest(Request $request){
        
        //dd($request);
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

        $user = User::make($request->validate([
            'email' => 'required|email|unique:users',
            'password' => $rules['password'],
            'role' => 'required',
            'isActive' => 'required',
        ]));
        
        
        $user->role = $request->role;
        $user->save();

        event(new Registered($user));
        return redirect()->route('login')->with('success', 'Registered Successfully');
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
            return redirect()->back()->with('error', 'Failed to change password');
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
