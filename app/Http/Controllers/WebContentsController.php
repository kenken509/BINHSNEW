<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebPost;
use App\Models\Comment;
use Auth;

class WebContentsController extends Controller
{
    public function show()
    {
        $currentlyLoggedUser = Auth::user()->role;
        $instructorSubject = Auth::user()->subject_id;
        
        $posts = WebPost::with(['comments' => function ($query) {
            $query->orderBy('approved_at', 'desc');
        }])
        ->with('author')
        ->get();

        
        $comments = Comment::with('commenter')->orderBy('approved_at', 'desc')->get();
       

        if($currentlyLoggedUser == 'admin')
        {
            return inertia('AdminDashboard/AdminPages/WebsiteManagement/Admin/PostsAll',[
                'posts' => $posts,
                'comments' => $comments,
            ]);
        }
        
        if($currentlyLoggedUser == 'instructor')
        {
            $instructorPost = WebPost::with(['comments' => function ($query) {
                $query->orderBy('approved_at', 'desc');
            }])
            ->with('author')
            ->where('subject_id', '=', $instructorSubject)
            ->get();
            
            return inertia('AdminDashboard/AdminPages/WebsiteManagement/Instructor/PostAll',[
                'posts' => $instructorPost,
                'comments' => $comments
            ]);
        }
    }

    public function showAddPost()
    {
        return inertia('AdminDashboard/AdminPages/WebsiteManagement/Instructor/PostAdd');
    }

    public function storePost(Request $request)
    {
        dd($request);
    }
}
