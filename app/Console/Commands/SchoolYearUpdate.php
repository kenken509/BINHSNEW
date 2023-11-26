<?php

namespace App\Console\Commands;

use App\Models\SchoolYear;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SchoolYearUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:school-year-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
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
                'year' => $currentSchoolYear,
            ]);
        }
        
        Log::info('School Year successfully updated!');
        Log::info('Current Schoolyear: '.$existing->year);
    }
}
