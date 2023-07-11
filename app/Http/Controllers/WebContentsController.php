<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebPost;

class WebContentsController extends Controller
{
    public function show()
    {
        $posts = WebPost::with(['comments','author'])->get();
        // dd($posts);
        // admin user
        return inertia('AdminDashboard/AdminPages/WebsiteManagement/Admin/PostsAll',[
            'posts' => $posts,
        ]);
    }
}
