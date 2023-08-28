<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestRouteController extends Controller
{
    public function showTestRoute(){
        return inertia('Index/TestPage');
    }
}
