<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebPost;
use App\Models\Comment;

class WebContentsController extends Controller
{
    public function show()
    {
        $posts = WebPost::with(['comments' => function ($query) {
            $query->orderBy('approved_at', 'desc');
        }])
        ->with('author')
        ->get();

        //dd($posts);
        $comments = Comment::with('commenter')->orderBy('approved_at', 'desc')->get();
        //dd($comments);
        // admin user
        return inertia('AdminDashboard/AdminPages/WebsiteManagement/Admin/PostsAll',[
            'posts' => $posts,
            'comments' => $comments,
        ]);
    }
}
