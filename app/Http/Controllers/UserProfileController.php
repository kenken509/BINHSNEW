<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
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

            
            return redirect()->back()->with('success', true);
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

            return redirect()->back()->with('success', true);
        }
    }
}
