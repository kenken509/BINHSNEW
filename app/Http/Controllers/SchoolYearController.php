<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
    public function store(Request $request)
    {
        $existing = SchoolYear::first();

        //dd($existing);
        if($existing == null)
        {
            $schooYear = new SchoolYear();

            $schooYear->year = $request->year;
            $schooYear->save();
        }
        if($existing)
        {
            $existing->update([
                'year' => $request->year,
            ]);
        }
        
    }
}
