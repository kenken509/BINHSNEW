<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\SchoolYear;
use App\Models\WebAnalysis;
use App\Models\StudentGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserCollection;

class UserData {
    public $role;
    public $count;

    public function __construct($role, $count) {
        $this->role = $role;
        $this->count = $count;
    }
}

class AdminDashboardController extends Controller
{
    function showAdminPanel(Request $request){

        $currentSchoolYear = SchoolYear::first();
        
        
        $adminCount = User::where('role', '=', 'admin')->where('isActive','1')->count();
        $instructorCount = User::where('role', '=', 'instructor')->where('isActive','1')->count();
        $studentCount = User::where('role', '=', 'student')->where('isActive','1')->count();
        $guestCount = User::where('role', '=', 'guest')->where('isActive','1')->count();
        /************************************************ */

        
        $currentYear = Carbon::now()->year;
        // Extract start and end years from the predefined school year
        [$startYear, $endYear] = explode('-', $currentSchoolYear->year);

        // current school year
        $predefinedYearStart = Carbon::createFromDate($startYear, 8, 1);
        $predefinedYearEnd = Carbon::createFromDate($endYear, 7, 31);
        
        
        // previous school year
        $previousYearStart = $predefinedYearStart->copy()->subYear();
        $previousYearEnd = $predefinedYearEnd->copy()->subYear();
        
        // monthly web visits *****************************************
        $monthly = WebAnalysis::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total_visits')
        )
            ->where('type', '=', 'visit')
            ->whereBetween(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), [$predefinedYearStart, $predefinedYearEnd])
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->get();

        $monthNames = [
                    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
                ];
            
        
        $monthly = $monthly->map(function ($item) use ($monthNames) {
            $item->month_name = $monthNames[$item->month];
            return $item;
        });
        
        
        // monthly web visits *****************************************
        
        // users count ***********************************************
        $users = User::all()->groupBy('role')->map->count();
        
        $usersData = [];

        foreach ($users as $role => $count) {
            $usersData[] = (object)['role' => $role, 'count' => $count];
        }
        // users count *************************************

        // download attempt count..*********************************************
        $windowsMonthlyDownloads = WebAnalysis::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('type', '=', 'download_attempt')
            ->where('installerType','=', 'windows')
            ->whereBetween(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), [$predefinedYearStart, $predefinedYearEnd])
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->get();

        $androidMonthlyDownloads = WebAnalysis::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('type', '=', 'download_attempt')
            ->where('installerType','=', 'android')
            ->whereBetween(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), [$predefinedYearStart, $predefinedYearEnd])
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->get();

        
        $instructorSubject = Auth::user()->subject_id;
            
      
        $instructorTopTen = StudentGrade::whereHas('student', function ($query) use ($instructorSubject) {
            $query->where('subject_id', $instructorSubject);
        })
        ->with('student.subject') // Eager load the "student" and its "subject" relationship
        ->orderBy('final_grade', 'desc')
        ->take(10) // Limit the results to 10
        ->get();

        
        
        
        

        $adminPrevYearCount         = User::whereBetween('created_at', [$previousYearStart, $previousYearEnd])->where('role','admin')->where('isActive','1')->count();
        $instructorPrevYearCount    = User::whereBetween('created_at', [$previousYearStart, $previousYearEnd])->where('role','instructor')->where('isActive','1')->count();
        $studentPrevYearCount       = User::whereBetween('created_at', [$previousYearStart, $previousYearEnd])->where('role','student')->count();
        $guestPrevYearCount         = User::whereBetween('created_at', [$previousYearStart, $previousYearEnd])->where('role','guest')->count();
        
        
        // download attempt count..*********************************************
        //****************************************** */
        return inertia('AdminDashboard/AdminPages/Dashboard',[
            'adminPrevYearCount'        => $adminPrevYearCount,
            'studentPrevYearCount'      => $studentPrevYearCount,
            'instructorPrevYearCount'   => $instructorPrevYearCount,
            'guestPrevYearCount'        => $guestPrevYearCount,
            'adminCount'                => $adminCount,            
            'instructorCount'           => $instructorCount,            
            'studentCount'              => $studentCount,
            'guestCount'                => $guestCount,
            'currentSchoolYear'         => $currentSchoolYear->year,
            'monthlyVisit'              => $monthly,
            'usersData'                 => $usersData,
            'windowsMonthlyDownloads'   => $windowsMonthlyDownloads,
            'androidMonthlyDownloads'   => $androidMonthlyDownloads,
            'instructorTopTen'          => $instructorTopTen,
        ]); 
     }
 
}
