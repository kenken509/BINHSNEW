<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\SchoolYear;
use App\Models\WebAnalysis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserCollection;

class AdminDashboardController extends Controller
{
    function showAdminPanel(){

        $currentSchoolYear = SchoolYear::first();
        
        $adminCount = User::where('role', '=', 'admin')->count();
        $instructorCount = User::where('role', '=', 'instructor')->count();
        $studentCount = User::where('role', '=', 'student')->count();
        $guestCount = User::where('role', '=', 'guest')->count();
        /************************************************ */
        
        $currentYear = Carbon::now()->year;

        $monthly = WebAnalysis::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total_visits')
        )
            ->where('type', '=', 'visit')
            ->whereYear('created_at', '=', $currentYear)
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->get();

        $monthNames = [
                    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
                ];

        // Convert numeric month to month name
        $monthly = $monthly->map(function ($item) use ($monthNames) {
            $item->month_name = $monthNames[$item->month];
            return $item;
        });
        
        //dd($monthly);
        

        //****************************************** */
        return inertia('AdminDashboard/AdminPages/Dashboard',[
            'adminCount' => $adminCount,
            'instructorCount' => $instructorCount,
            'studentCount' =>  $studentCount,
            'guestCount' => $guestCount,
            'currentSchoolYear' => $currentSchoolYear->year,
            'monthlyVisit' =>  $monthly
        ]); 
     }
 
}
