<?php

namespace App\Http\Middleware;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // $jsonData = $request->json()->all();
        // if($jsonData == null )
        // {
        //     return redirect('/login');
        // }
        
        

        return $request->expectsJson()
        ? null
        : dd(' Aries: routing bug must be fixed');
        
        

        // if ($request->expectsJson())  {
        //     return null;
        // }
        
        // return redirect()->route('index')->with('success', 'Email was verified')->getTargetUrl();;
    }
}
