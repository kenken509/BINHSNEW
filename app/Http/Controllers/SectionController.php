<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;

class SectionController extends Controller
{
    public function show(){
        
        //dd(Section::with('subject')->latest()->get());
        return inertia('AdminDashboard/AdminPages/SectionManagement/SectionAll', [
            'sections' => Section::with('subject')->latest()->get(),
        ]);
    }
}
