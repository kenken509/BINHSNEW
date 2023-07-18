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
            ->orderBy('created_at','desc')
            ->get();

            return inertia('AdminDashboard/AdminPages/WebsiteManagement/Instructor/PostAll',[
                'posts' => $instructorPost,
                'comments' => $comments
            ]);
        }
    }

    public function showAddPost()
    {
        dd('ayusin mo to');
        //return inertia('AdminDashboard/AdminPages/WebsiteManagement/Instructor/PostAdd');
    }

    public function storePost(Request $request)
    {
        dd('admin web post button');
    }

    //instructor
    public function showInstructorAddPost()
    {
        return inertia('AdminDashboard/AdminPages/WebsiteManagement/Instructor/PostAdd');
    }

    public function instructorStorePost(Request $request)
    {
        
        if(!$request->attachment){
            //{"author_id":4,"attachment":null,"subject_id":3,"title":null,"content":null,"status":"public","images":[],"video":null,"created_by":4}
            //dd('andito ako');
            $post =  $request->validate([
                'title'     => 'required',
                'content'   => 'required|max:50000',
            ]);

            //dd($request);
            if($post){
                $newPost = new WebPost();
                $newPost->author_id = $request->author_id;
                $newPost->subject_id = $request->subject_id;
                $newPost->title = $request->title;
                $newPost->content = $request->content;
                $newPost->status = $request->status;
                $newPost->created_by = $request->author_id;

                $newPost->save();

                return redirect()->route('webPosts.all')->with('success', 'Successfully added new post');
            }
        }
        else
        {
            $attachment = $request->attachment['name'];
        }
        
        if($attachment == 'None' ){
            dd('walang attachment');
        }
        else if($attachment == 'Image')
        {
            dd('i save ang image');
        }
        else if($attachment == 'Video')
        {
            dd(' isave ang video');
        }


        if ($request->hasFile('images') || $request->hasFile('video')) {
            // At least one file is present
            if ($request->hasFile('images')) {
                
                if ($request->hasFile('video')) {
                    dd('may picture at video');
                    
                }
                dd('may picture walang video');
                
            }
        
            if ($request->hasFile('video')) {
                dd('may video pero walang picture');
                
            }
        } else {
            dd('Walang picture at walang video');
            
        }
    }
    
}
