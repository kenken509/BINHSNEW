<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function showEditProfile($id)
    {
        $userToEdit = User::findOrFail($id);
        dd($userToEdit);
    }
}
