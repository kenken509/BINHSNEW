<?php

namespace App\Http\Middleware;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): Response
    {
       
       
        
        

        if ($request->expectsJson()) {
            return null;
        } else {
            //dd('fix me');
            // dd($request);
            // Throw an unauthorized error
            abort(401, 'Unauthorized');
        }
        
        return redirect()->route('login')->with('success', 'Email was verified')->getTargetUrl();
    }
}