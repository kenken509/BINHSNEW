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

    public function testerFunction()
    {
        date_default_timezone_set('Asia/Manila');
        $currentDate        = date('Y-m-d'); 
        $currentMonth       = date('n');
        $currentYear        = date('Y');
        
        $currentSchoolYear  = "";

        if($currentMonth >= 8) // if current month is august onwards.
        {
            $currentSchoolYear = $currentYear."-".($currentYear+1); // current school year will be the current year- current year + 1
        }

        if($currentMonth < 8) //
        {
            $currentSchoolYear = ($currentYear-1)."-".($currentYear);
        }

        
        $existing = SchoolYear::first();
        
        // if no data save the currentSchoolyear;
        if($existing == null)
        {
            $schooYear = new SchoolYear();

            $schooYear->year = $currentSchoolYear;
            $schooYear->save();
        }

        if($existing)
        {
            $existing->update([
                'year' => $$currentSchoolYear,
            ]);
        }
        
    }
}
