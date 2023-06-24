<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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

        $exist = User::where('email', $request->email)->first();
        
        if ($exist && Hash::check($request->password, $exist->password) ) {
            // Authentication successful
            $user = $exist;

            return response()->json(['message' => 'Login successful', 'user' => $user], 200);
        } else {
            // Authentication failed
            return response()->json(['message' => 'Invalid credentials'],401);
        }
    }
}
