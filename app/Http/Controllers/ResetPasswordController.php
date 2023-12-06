<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\ResetPassword;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    public function showForgotPassword()
    {
        return inertia('Auth/ForgotPassword');
    }

    public function sendEmailResetPassword(Request $request)
    {
       
        $userToSendEmail = User::where('email','=',$request->email)->first();
        
        if($userToSendEmail)
        {
            $userId = $userToSendEmail->id;
            $resetToken = Str::random(30);

            
            $mailData = [
                'url' => env('APP_URL').'/pasword-reset/verify/'.$resetToken,
            ];
            
            
            Mail::to($userToSendEmail->email)->send(new ResetPassword($mailData));
            date_default_timezone_set('Asia/Manila');

            // save reset token to user 
            $userToSendEmail->reset_token = $resetToken;
            $userToSendEmail->reset_expires_at = now()->addMinutes(10);
            $userToSendEmail->save();
            
            return redirect()->route('index')->with('success', 'Please check your email for the password reset link.');
        }
        else
        {
            return redirect()->route('forgot.password.show')->with('error', 'Email not found');
        }
    }

    public function resetLinkVerify($resetToken)
    {
        
        $user = User::where('reset_token','=',$resetToken)->first();
        
        if($user)
        {
            //dd('andito dapat ako');
            if($user->reset_expires_at && now()->lessThan($user->reset_expires_at))
            {
                
                return redirect()->route('change.password.show')->with('temp', $user->id);
            }
            else
            {
                return redirect()->route('login')->with('error', 'Reset password link was expired');
                // return redirect()->route('change.password.show')->with(['error' => 'Reset Link has expired', 'temp' => $user->id]);
            };
        }
        else
        {
            abort(401, 'Unauthorized');
            
        }
        $expiration = $user->reset_expires_at;

        date_default_timezone_set('Asia/Manila');
        
        
        
        
        
    }

    public function showChangePassword()
    {
        return inertia('Auth/ChangePassword');
    }

    public function storeNewPassword(Request $request)
    {
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

        $request->validate([
            'password' => $rules['password'],
        ]);
        

        $user = User::findOrFail($request->userId);

        if($user)
        {
            $user->password         = $request->password;
            $user->reset_token      = null;
            $user->reset_expires_at = null;

            $user->save();

            Auth::login($user);

            return redirect()->route('index')->with('success', 'Successfully Changed Password');
        }
        else
        {
            abort(401, 'Unauthorized');
        }
    }
}
