<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function showEditProfile($id)
    {
        $userToEdit = User::findOrFail($id);
        
        return inertia('Index/WebPages/UserProfileEdit',[
            'userToEdit' => $userToEdit,
        ]);
    }

    public function userProfileImageUpdate(Request $request)
    {   
        $user = User::findOrFail(Auth::user()->id);
        $request->validate([
            'image' => 'required|mimes:jpg,jpeg,png|max:3000'
        ]);

        if(!$user->image)
        {
            $file = $request->file('image');
            $originalName = $file->getClientOriginalName();
            $randomString = Str::random(10);
            $newName = $randomString.'_'.$originalName;
            $path = $file->storeAs('Images', $newName, 'public');

            $user->image = $path;
            $user->save();

            
            return redirect()->back()->with('success', 'Successfully Updated!');
        }

        if($user->image)
        {
            $file = $request->file('image');
            $originalName = $file->getClientOriginalName();
            $randomString = Str::random(10);
            $newName = $randomString.'_'.$originalName;
            $path = $file->storeAs('Images', $newName, 'public');

            Storage::disk('public')->delete($user->image);

            $user->image = $path;
            $user->save();

            return redirect()->back()->with('success', 'Successfully Updated!');
        }
    }

    public function userProfileInfoUpdate(Request $request)
    {
        $role = Auth::user()->role;
        if($role)
        {
            //dd($request->birthDate);
            $data = $request->validate([
                'fName'         => 'required|max:50',
                'mName'         => 'required:max:50',
                'lName'         => 'required:max:50',
                'gender'        => 'required',
                'civilStatus'   => 'required',
                //'email'         => [ 'required', 'email', Rule::unique('users')->ignore(Auth::user()->id), ],
                'birthDate'     => 'required|date|before_or_equal:'.($role == 'student' || $role === 'guest' ? now()->subYears(11) : now()->subYears(18))->toDateString(),
                'phoneNumber'   => 'required|min:11|max:12',
                'region'        => 'required',
                'province'      => 'required',
                'city'          => 'required',
                'barangay'      => 'required',
            ],[
                'fName'                     => 'The first name field is required',
                'mName'                     => 'The middle name field is required',
                'lName'                     => 'The last name field is required',
                'birthDate.before_or_equal' => $role == 'student' || $role == 'guest' ? 'Must be at least 11 years old' : 'Must be at least 18 years old ',
                'gender.required'           => 'Gender is required',
                'civilStatus.required'      => 'Status is required',
                'region.required'           => 'Region is required',
                'province.required'         => 'Province is required',
                'city.required'             => 'City is required',
                'barangay.required'         => 'Baranggay is required',
                'role'                      => 'Role is required',
                'subject_id'                => 'Subject is required',
            ]);

            $user = User::findOrFail(Auth::user()->id);
            $date = date_create($request->birthDate);
            $age = Carbon::parse($request->birthDate)->age;
            

            // if($user->email != $request->email)
            // {
            //     $user->email = $request->email;
            //     $user->email_verified_at = null;
            // }
            
            
            $user->fName        = $request->fName;
            $user->mName        = $request->mName;
            $user->lName        = $request->lName;
            $user->gender       = $request->gender;
            $user->gender       = $request->gender;
            $user->civilStatus  = $request->civilStatus;
            $user->phoneNumber  = $request->phoneNumber;
            $user->birthDate    = $date;
            $user->age          = $age;
            $user->region       = $request->region;
            $user->province     = $request->province;
            $user->city         = $request->city;
            $user->barangay     = $request->barangay;
            $user->save();

            return redirect()->back()->with('success', 'Successfully Updated!');

            
        }
        
        // if($role == 'student')
        // {
        //     dd($role);
        // }

        
    }
}
