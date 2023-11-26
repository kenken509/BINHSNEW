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
        // $jsonData = $request->json()->all();
        // if($jsonData == null )
        // {
        //     return redirect('/login');
        // }
        
        

        return $request->expectsJson()
        ? null
        : route('login');
        
        

        // if ($request->expectsJson())  {
        //     return null;
        // }
        
        // return redirect()->route('index')->with('success', 'Email was verified')->getTargetUrl();;
    }
}
