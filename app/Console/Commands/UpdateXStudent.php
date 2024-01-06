<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\SchoolYear;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateXStudent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-x-student';

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
        
        $currentSchoolYear = SchoolYear::first();

        $students = User::where('role','student')->where('school_year','!=',$currentSchoolYear->year)->get();

        foreach($students as $student)
        {
            $student->role = 'xStudent';
            $student->save(); 
        }

        Log::info('Current Student Updated!');
    }
}
