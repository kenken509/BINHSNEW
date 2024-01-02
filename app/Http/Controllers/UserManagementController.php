<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Section;
use App\Models\Subject;
use App\Models\TestModel;
use App\Models\SchoolYear;
use App\Models\TestSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;

class UserManagementController extends Controller
{
    public function showAllUsers(Request $request){
        //dd(User::orderByDesc('created_at')->paginate(10));
        //dd(User::with(['subject','section','instructorSection'])->latest()->get());    
        $filters = $request->role;
        
        $userRole = Auth::user()->role;
        
        $userSubjectId = Auth::user()->subject_id;
       
        $allUsers = User::where('isActive','1')->with(['subject','section','instructorSections'])->get();//User::orderBy('id','desc')->get(); 'instructorSection'
        
        
        $query = User::with(['subject','section','instructorSections'])->latest(); //'instructorSection'
        
        //dd($allUsers);
        if($userRole == 'admin'){
           
            return inertia('AdminDashboard/AdminPages/UserManagement/UsersAll',[
                'users'     => $query->filteredData($filters)->where('isActive','1')->paginate(10),
                'allUsers'  => $allUsers,
            ]);
        }

        if($userRole == 'instructor'){
            $query = User::with(['subject','section'])->where('subject_id','=', $userSubjectId)->where('role','=','student')->latest();
            return inertia('AdminDashboard/AdminPages/UserManagement/UsersAll',[
                'users' =>$query->paginate(10),
            ]);
        }
       
    }

    public function showAddUser(){
        //dd(Subject::with('section')->get());
        $currentlyLoggedUser = Auth::user()->role;


        if($currentlyLoggedUser == 'admin'){
            return inertia('AdminDashboard/AdminPages/UserManagement/UserAdd', [
                'subjects' => Subject::with('section')->get(),
            ]);
        }

        if($currentlyLoggedUser == 'instructor'){
            return inertia('AdminDashboard/AdminPages/UserManagement/InstructorRolePages/UserAdd', [
                'subjects' => Subject::with('section')->get(),
            ]);
        }
    }

    public function showApproveUser()
    {
        $currentSchoolYear = SchoolYear::first();

        
        return inertia('AdminDashboard/AdminPages/UserManagement/UserApprove', [
            'students' => User::with(['subject','section'])
                            ->where('role','student')
                            ->where('school_year',$currentSchoolYear->year)
                            ->where('isActive', '0')
                            ->get(),
        ]);
    }

    public function rejectUser($id)
    {
        
        $user = User::findOrFail($id);
        if($user->image){
            Storage::disk('public')->delete($user->image);
        }
            
        $user->delete();
        return redirect()->route('admin.showAllUsers')->with('success', 'Rejected Successfully!');
    }

    public function ApproveUser($id)
    {
        
        $studentToApprove = User::findOrFail($id);
        
        $studentToApprove->isActive = '1';
        $studentToApprove->save();

        return redirect()->route('admin.showAllUsers')->with('success', 'Successfully Approved new student!');
    }
    public function userStore(Request $request){
        
        //dd(Auth::user()->role);
        //if currently logged in user role is admin ***********************************************
        $date = date_create($request->birthDate);
        $age = Carbon::parse($request->birthDate)->age;
        

        //$defaultPassword = $request->lName;
        //$request->password = $defaultPassword;
        
        //dd($request);
        if($request->hasFile('image')){
        
            $request->validate([
                'image.*'       => 'mimes:jpg,png|max:3000',
            ],[
                'image.*'       => 'this image'
            ]); //Image file type must be in jpg,png,jpeg format. Maximum size: 3mb]);
            
            if($request->role == 'instructor'){ // if instructor with Image
                $file           = $request->file('image')[0];
                $originalName   = $file->getClientOriginalName();
                $email          = $request->email;
                $cleanedString  = str_replace(".", "_", $email);
                $newName        = $cleanedString.$originalName;
                $path           = $file->storeAs('images',$newName, 'public');
                $request->image = $path;
                $storeName      = $request->image = $path;
                //dd($request->image);
                
                    //dd('im here @ under path');
                $user = User::make($request->validate([ //  "make" function creates a new instance of the model but not stored yet
                    'fName'         => 'required',
                    'mName'         => 'required',
                    'lName'         => 'required',
                    'gender'        => 'required',
                    'civilStatus'   => 'required',
                    'email'         => 'required|email|unique:users', //unique:user means email field should be unique in the users table
                    'phoneNumber'   => 'required|min:11|max:12',
                    'birthDate'     => 'required|date|before:'.now()->subYears(18)->toDateString(),
                    'image'         =>  'nullable',
                    'region'        => 'required',
                    'province'      => 'required',
                    'city'          => 'required',
                    'barangay'      => 'required',
                    'role'          => 'required',
                    'subject_id'    => 'required',
                    'age'           => 'nullable',
        
                ],[
                    'fName'                     => 'The first name field is required',
                    'mName'                     => 'The middle name field is required',
                    'lName'                     => 'The last name field is required',
                    'birthDate.before'          =>'Must be at least 17 years old',
                    'gender.required'           => 'Gender is required',
                    'civilStatus.required'      => 'Status is required',
                    'region.required'           => 'Region is required',
                    'province.required'         => 'Province is required',
                    'city.required'             => 'City is required',
                    'barangay.required'         => 'Baranggay is required',
                    'role'                      => 'Role is required',
                    'subject_id'                => 'Subject is required',
                    
                ]));
                
                $user->age          = $age;
                $user->password     = $request->lName; // hashed using accessor mutator in User model
                $user->birthDate    = $date;
                $user->image        = $storeName;
                $user->isActive     = 1;
                $user->created_by   = Auth::user()->id;
                $user->save();

                event(new Registered($user));
                return redirect()->route('admin.showAllUsers')->with('success', 'Successfully Added new User!');
            }
            elseif($request->role == 'student'){ //student with image
                // ITO LANG ANG GAGALAWIN MO NGAYON >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
                $file               = $request->file('image')[0];
                $originalName       = $file->getClientOriginalName();
                $email              = $request->email;
                $cleanedString      = str_replace(".", "_", $email);
                $newName            = $cleanedString.$originalName;
                $path               = $file->storeAs('images',$newName, 'public');
                //$request->image     = $path;
                
                //dd($request->image);
                
                    //dd('im here @ under path');
                $user = User::make($request->validate([ //  "make" function creates a new instance of the model but not stored yet
                    'fName'         => 'required',
                    'mName'         => 'required',
                    'lName'         => 'required',
                    'gender'        => 'required',
                    'civilStatus'   => 'required',
                    'email'         => 'required|email|unique:users', //unique:user means email field should be unique in the users table
                    'phoneNumber'   => 'required|min:11|max:12',
                    'birthDate'     => 'required|date|before:'.now()->subYears(11)->toDateString(),
                    'image'         =>  'nullable',
                    'region'        => 'required',
                    'province'      => 'required',
                    'city'          => 'required',
                    'barangay'      => 'required',
                    'role'          => 'required',
                    'subject_id'    => 'required',
                    'section_id'    => 'required',
                    'fatherName'    => 'required',
                    'motherName'    => 'required',
                    'age'           => 'nullable',
        
                ],[
                    'fName'                     => 'The first name field is required',
                    'mName'                     => 'The middle name field is required',
                    'lName'                     => 'The last name field is required',
                    'birthDate.before'          =>'Must be at least 12 years old',
                    'gender.required'           => 'Gender is required',
                    'civilStatus.required'      => 'Status is required',
                    'region.required'           => 'Region is required',
                    'province.required'         => 'Province is required',
                    'city.required'             => 'City is required',
                    'barangay.required'         => 'Baranggay is required',
                    'role'                      => 'Role is required',
                    'subject_id'                => 'Subject is required',
                    'section_id'                => 'Section is required',
                    'fatherName'                => "The father's name field is required",
                    'motherName'                => "The mother's name field is required",
                    
                ]));
                $user->age          = $age;
                $user->password     = $request->lName; // hashed using accessor mutator in User model
                $user->birthDate    = $date;
                $user->isActive     = 1;
                $user->created_by   = Auth::user()->id;
                $user->image        = $path;
                $user->save();

                event(new Registered($user));
                return redirect()->route('admin.showAllUsers')->with('success', 'Successfully Added new User!');
            }
            else{ // if role is admin
                $file = $request->file('image')[0];
                $originalName = $file->getClientOriginalName();
                $email = $request->email;
                $cleanedString = str_replace(".", "_", $email);
                $newName = $cleanedString.$originalName;
                $path = $file->storeAs('images',$newName, 'public');
                $request->image = $path;
                
                    //dd('im here @ under path');
                $user = User::make($request->validate([ //  "make" function creates a new instance of the model but not stored yet
                    'fName'         => 'required',
                    'mName'         => 'required',
                    'lName'         => 'required',
                    'gender'        => 'required',
                    'civilStatus'   => 'required',
                    'email'         => 'required|email|unique:users', //unique:user means email field should be unique in the users table
                    'phoneNumber'   => 'required|min:11|max:12',
                    'birthDate'     => 'required|date|before:'.now()->subYears(18)->toDateString(),
                    'region'        => 'required',
                    'province'      => 'required',
                    'city'          => 'required',
                    'barangay'      => 'required',
                    'role'          => 'required',
                    'age'           => 'nullable',
                    
                ],[
                    'fName'                     => 'The first name field is required',
                    'mName'                     => 'The middle name field is required',
                    'lName'                     => 'The last name field is required',
                    'birthDate.before'          =>'Must be at least 17 years old',
                    'gender.required'           => 'Gender is required',
                    'civilStatus.required'      => 'Status is required',
                    'region.required'           => 'Region is required',
                    'province.required'         => 'Province is required',
                    'city.required'             => 'City is required',
                    'barangay.required'         => 'Baranggay is required',
                    'role'                      => 'Role is required',
                    
                ]));
                $user->age          = $age;
                $user->password     = $request->lName; // hashed using accessor mutator in User model tolowercase
                $user->birthDate    = $date;
                $user->isActive     = 1;
                $user->image        = $path;
                $user->created_by   = Auth::user()->id;
                $user->save();

                event(new Registered($user));
                return redirect()->route('admin.showAllUsers')->with('success', 'Successfully Added new User!');
            }
           
        }else{ // if no image file
            
            if($request->role == 'instructor'){ //instructor no image
               
                $user = User::make($request->validate([ //  "make" function creates a new instance of the model but not stored yet
                    'fName'         => 'required',
                    'mName'         => 'required',
                    'lName'         => 'required',
                    'gender'        => 'required',
                    'civilStatus'   => 'required',
                    'email'         => 'required|email|unique:users', //unique:user means email field should be unique in the users table
                    'phoneNumber'   => 'required|min:11|max:12',
                    'birthDate'     => 'required|date|before:'.now()->subYears(18)->toDateString(),
                    'region'        => 'required',
                    'province'      => 'required',
                    'city'          => 'required',
                    'barangay'      => 'required',
                    'role'          => 'required',
                    'subject_id'    => 'required',
        
                ],[
                    'birthDate.before'          =>'Must be at least 17 years old',
                    'gender.required'           => 'Gender is required',
                    'civilStatus.required'      => 'Status is required',
                    'region.required'           => 'Region is required',
                    'province.required'         => 'Province is required',
                    'city.required'             => 'City is required',
                    'barangay.required'         => 'Baranggay is required',
                    'role'                      => 'Role is required',
                    'subject_id'                => 'Subject is required',
                    'fName'                     => 'The first name field is required',
                    'mName'                     => 'The middle name field is required',
                    'lName'                     => 'The last name field is required',
                ]));
                $user->age          = $age;
                $user->password     = $request->lName; // hashed using accessor mutator in User model
                $user->birthDate    = $date;
                $user->isActive     = 1;
                $user->created_by   = Auth::user()->id;
                $user->save();

                event(new Registered($user));
                return redirect()->route('admin.showAllUsers')->with('success', 'Successfully Added new User!');
            }
            elseif($request->role == 'student'){ // student without image
                // ITO LANG ANG GAGALAWIN MO NGAYON >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
                $user = User::make($request->validate([ //  "make" function creates a new instance of the model but not stored yet
                    'fName'         => 'required',
                    'mName'         => 'required',
                    'lName'         => 'required',
                    'gender'        => 'required',
                    'civilStatus'   => 'required',
                    'email'         => 'required|email|unique:users', //unique:user means email field should be unique in the users table
                    'phoneNumber'   => 'required|min:11|max:12',
                    'birthDate'     => 'required|date|before:'.now()->subYears(11)->toDateString(),
                    'region'        => 'required',
                    'province'      => 'required',
                    'city'          => 'required',
                    'barangay'      => 'required',
                    'role'          => 'required',
                    'subject_id'    => 'required',
                    'section_id'    => 'required',
                    'fatherName'    => 'required',
                    'motherName'    => 'required',
                    'age'           => 'nullable',
        
                ],[
                    'fName'                     => 'The first name field is required',
                    'mName'                     => 'The middle name field is required',
                    'lName'                     => 'The last name field is required',
                    'birthDate.before'          =>'Must be at least 12 years old',
                    'gender.required'           => 'Gender is required',
                    'civilStatus.required'      => 'Status is required',
                    'region.required'           => 'Region is required',
                    'province.required'         => 'Province is required',
                    'city.required'             => 'City is required',
                    'barangay.required'         => 'Baranggay is required',
                    'subject_id'                => 'Subject is required',
                    'section_id'                => 'Section is required',
                    'role'                      => 'Role is required',
                    'subject_id'                => 'Subject is required',
                ]));
                $user->age          = $age;
                $user->password     = $request->lName; // hashed using accessor mutator in User model
                $user->birthDate    = $date;
                $user->isActive     = 1;
                $user->created_by   = Auth::user()->id;
                $user->save();

                event(new Registered($user)); //event listner @Providers EventServiceProvider
                return redirect()->route('admin.showAllUsers')->with('success', 'Successfully Added new User!');
            }
            else{ //if admin
                $user = User::make($request->validate([ //  "make" function creates a new instance of the model but not stored yet
                    'fName'         => 'required',
                    'mName'         => 'required',
                    'lName'         => 'required',
                    'gender'        => 'required',
                    'civilStatus'   => 'required',
                    'email'         => 'required|email|unique:users', //unique:user means email field should be unique in the users table
                    'phoneNumber'   => 'required|min:11|max:12',
                    'birthDate'     => 'required|date|before:'.now()->subYears(17)->toDateString(),
                    'region'        => 'required',
                    'province'      => 'required',
                    'city'          => 'required',
                    'barangay'      => 'required',
                    'role'          => 'required',
                    'age'           => 'nullable',
                    
                ],[
                    'fName'                     => 'The first name field is required',
                    'mName'                     => 'The middle name field is required',
                    'lName'                     => 'The last name field is required',
                    'birthDate.before'          =>'Must be at least 18 years old',
                    'gender.required'           => 'Gender is required',
                    'civilStatus.required'      => 'Status is required',
                    'region.required'           => 'Region is required',
                    'province.required'         => 'Province is required',
                    'city.required'             => 'City is required',
                    'barangay.required'         => 'Baranggay is required',
                    'role'                      => 'Role is required',
                    
                ]));
                
                $user->age          = $age;
                $user->password     = $request->lName; // hashed using accessor mutator in User model
                $user->birthDate    = $date;
                $user->isActive     = 1;
                $user->created_by   = Auth::user()->id;
                $user->save();

                event(new Registered($user));
                return redirect()->route('admin.showAllUsers')->with('success', 'Successfully Added new User!');
            }
        }
       //if currently logged in user role is admin ***********************************************
    }


    public function userUpdate(Request $request){
        //dd($request);
        //$user = User::findOrFail($request->id);
        $date = date_create($request->birthDate);
        $age = Carbon::parse($request->birthDate)->age;

        if($request->role == 'instructor'){ 
               
            $user = $request->validate([ 
                'fName'         => 'required',
                'mName'         => 'required',
                'lName'         => 'required',
                'gender'        => 'required',
                'civilStatus'   => 'required',
                'phoneNumber'   => 'required|min:11|max:12',
                'birthDate'     => 'required|date|before:'.now()->subYears(17)->toDateString(),
                'image'         =>  'nullable',
                'region'        => 'required',
                'province'      => 'required',
                'city'          => 'required',
                'barangay'      => 'required',
                'role'          => 'required',
                'subject_id'    => 'required',
                'age'           => 'nullable',
    
            ],[
                'fName'                     => 'The first name field is required',
                'mName'                     => 'The middle name field is required',
                'lName'                     => 'The last name field is required',
                'birthDate.before'          =>'Must be at least 18 years old',
                'gender.required'           => 'Gender is required',
                'civilStatus.required'      => 'Status is required',
                'region.required'           => 'Region is required',
                'province.required'         => 'Province is required',
                'city.required'             => 'City is required',
                'barangay.required'         => 'Baranggay is required',
                'role'                      => 'Role is required',
                'subject_id'                => 'Subject is required',
            ]);
            
            if($user){
                $updatedUser = User::findOrFail($request->id)->update([
                    'fName'         => $request->fName,
                    'mName'         => $request->mName,
                    'lName'         => $request->lName,
                    'gender'        => $request->gender,
                    'civilStatus'   => $request->civilStatus,
                    'image'         => $request->image,
                    'email'         => $request->email,
                    'phoneNumber'   => $request->phoneNumber,
                    'birthDate'     => $date,
                    'age'           => $age,
                    'password'      => strtolower($request->lName),
                    'region'        => $request->region,
                    'province'      => $request->province,
                    'city'          => $request->city,
                    'barangay'      => $request->barangay,
                    'role'          => $request->role,
                    'subject_id'    => $request->subject_id,
                    'fatherName'    => null,
                    'motherName'    => null,
                    'updated_by'    => Auth::user()->id,
                ]);
            }
           
            
            return redirect()->route('admin.showAllUsers', ['id' => $user->id])->with('success', 'Updated Successfully!');
        }elseif($request->role == 'student'){ // ito lang gagalawin ko ngayon
            
            $user = $request->validate([
                'fName'         => 'required',
                'mName'         => 'required',
                'lName'         => 'required',
                'gender'        => 'required',
                'civilStatus'   => 'required',
                'phoneNumber'   => 'required|min:11|max:12',
                'birthDate'     => 'required|date|before:'.now()->subYears(11)->toDateString(),
                'image'         =>  'nullable',
                'region'        => 'required',
                'province'      => 'required',
                'city'          => 'required',
                'barangay'      => 'required',
                'role'          => 'required',
                'subject_id'    => 'required',
                'section_id'    => 'required',
                'fatherName'    => 'required',
                'motherName'    => 'required',


                ],[
                'fName'                     => 'The first name field is required',
                'mName'                     => 'The middle name field is required',
                'lName'                     => 'The last name field is required',
                'birthDate.before'          =>'Must be at least 12 years old',
                'gender.required'           => 'Gender is required',
                'civilStatus.required'      => 'Status is required',
                'region.required'           => 'Region is required',
                'province.required'         => 'Province is required',
                'city.required'             => 'City is required',
                'barangay.required'         => 'Baranggay is required',
                'role'                      => 'Role is required',
                'subject_id'                => 'Subject is required',
                'section_id'                => 'Section is required',
           ]);

            if($user){
                $updateUser = User::findOrFail($request->id)->update([
                    'fName'                 => $request->fName,
                    'mName'                 => $request->mName,
                    'lName'                 => $request->lName,
                    'gender'                => $request->gender,
                    'civilStatus'           => $request->civilStatus,
                    'image'                 => $request->image,
                    'email'                 => $request->email,
                    'phoneNumber'           => $request->phoneNumber,
                    'birthDate'             => $date,
                    'age'                   => $age,
                    'password'              => strtolower($request->lName),
                    'fatherName'            => $request->fatherName,
                    'motherName'            => $request->motherName,
                    'region'                => $request->region,
                    'province'              => $request->province,
                    'city'                  => $request->city,
                    'barangay'              => $request->barangay,
                    'role'                  => $request->role,
                    'subject_id'            => $request->subject_id,
                    'section_id'            => $request->section_id,
                    'updated_by'            => Auth::user()->id,

                ]);
            }
            return redirect()->route('admin.showAllUsers')->with('success', 'Updated Successfully!');
        }else{ // is admin
            $user = $request->validate([
                'fName'         => 'required',
                'mName'         => 'required',
                'lName'         => 'required',
                'gender'        => 'required',
                'civilStatus'   => 'required',
                'phoneNumber'   => 'required|min:11|max:12',
                'birthDate'     => 'required|date|before:'.now()->subYears(17)->toDateString(),
                'image'         =>  'nullable',
                'region'        => 'required',
                'province'      => 'required',
                'city'          => 'required',
                'barangay'      => 'required',
                'role'          => 'required',

                ],[
                'fName'                     => 'The first name field is required',
                'mName'                     => 'The middle name field is required',
                'lName'                     => 'The last name field is required',
                'birthDate.before'          =>'Must be at least 18 years old',
                'gender.required'           => 'Gender is required',
                'civilStatus.required'      => 'Status is required',
                'region.required'           => 'Region is required',
                'province.required'         => 'Province is required',
                'city.required'             => 'City is required',
                'barangay.required'         => 'Baranggay is required',
                'role'                      => 'Role is required',
           ]);

            if($user){
                $updateUser = User::findOrFail($request->id)->update([
                    'fName'                 => $request->fName,
                    'mName'                 => $request->mName,
                    'lName'                 => $request->lName,
                    'gender'                => $request->gender,
                    'civilStatus'           => $request->civilStatus,
                    'image'                 => $request->image,
                    'email'                 => $request->email,
                    'phoneNumber'           => $request->phoneNumber,
                    'birthDate'             => $date,
                    'age'                   => $age,
                    'password'              => strtolower($request->lName),
                    'region'                => $request->region,
                    'province'              => $request->province,
                    'city'                  => $request->city,
                    'barangay'              => $request->barangay,
                    'role'                  => $request->role,
                    'fatherName'            => null,
                    'motherName'            => null,
                    'updated_by'            => Auth::user()->id,

                ]);
            }
            return redirect()->route('admin.showAllUsers')->with('success', 'Updated Successfully!');

            
        }
        
    }


    public function showEditUser($id){
        //dd(Subject::all());
       
        $currentlyLoggedUser = Auth::user()->role;
        
        if($currentlyLoggedUser == 'admin'){
            return inertia('AdminDashboard/AdminPages/UserManagement/UserEdit',[
                'userToEdit' => User::with(['subject','section'])->findOrFail($id),
                'userSubject' => User::with('section')->findOrFail($id),
                'studentSubjects' => Subject::with('section')->latest()->get(),
                'instructorSubjects' => Subject::all(),
            ]);
        }

        if($currentlyLoggedUser == 'instructor'){
            //dd(User::with(['subject','section'])->findOrFail($id));
            return inertia('AdminDashboard/AdminPages/UserManagement/InstructorRolePages/UserEdit',[
                'userToEdit' => User::with(['subject','section'])->findOrFail($id),
                'subjects' => User::with('section')->findOrFail($id),
                'studentSubjects' => Subject::with('section')->latest()->get(),
                'instructorSubjects' => Subject::all(),
            ]);
        }
        
    }


    public function userDelete(User $user){
        //dd(Auth::user()->id);
        //delete image if there's one
        //dd($user->id);
        if($user->id == Auth::user()->id){
            return redirect()->back()->with('error', 'Deletion Failed!');
        }else{
            if($user->image){
                Storage::disk('public')->delete($user->image);
            }
                
            $user->delete();
            return redirect()->back()->with('success', 'Deleted Successfully');
        }
        
        
    }

    
}
