<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Comment;
use App\Models\WebPost;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\WebPostAttachment;

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
        
        if(!$request->attachment || $request->attachment['name'] == 'None'){
            //{"author_id":4,"attachment":null,"subject_id":3,"title":null,"content":null,"status":"public","images":[],"video":null,"created_by":4}
            
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
        else if($request->attachment['name'] == 'Image')
        {
            //dd($request);
            $validated = $request->validate([
                'title'     => 'required|max:100',
                'content'   => 'required|max:50000',
                'images.*'  => 'required|mimes:jpg,jpeg,png|max:3000'
            ]);

            if($validated)
            {     
                $newPost = new WebPost();

                $newPost->author_id     = $request->author_id;
                $newPost->subject_id    = $request->subject_id;
                $newPost->title         = $request->title;
                $newPost->content       = $request->content;
                $newPost->status        = 'active';
                $newPost->created_by    = Auth::user()->id;
                $newPost->created_at    = Carbon::now();
                $newPost->save();

                foreach($request->file('images') as $file)
                {
                    
                    $path = $file->store('images', 'public');

                    $newAttachment              = new WebPostAttachment();
                    $newAttachment->type        = 'Image';
                    $newAttachment->web_post_id = $newPost->id;
                    $newAttachment->filename    = $path;
                    $newAttachment->created_at  = Carbon::now();

                    $newAttachment->save();
                }
                
                return redirect()->route('webPosts.all')->with('success', 'Successfully added new post');
            }
        }
        else if($request->attachment['name'] == 'Video')
        {
            //dd($request);
            // "author_id" => "4"
            // "attachment" => array:1 [▼
            //     "name" => "Video"
            // ]
            // "subject_id" => "3"
            // "title" => "asdf"
            // "content" => "asdfasdf"
            // "status" => "active"
            // "created_by" => "4"

            $validate = $request->validate([
                'title' => 'required|max:100',
                'content' => 'required|max:50000',
                'video'     => 'required|mimetypes:video/mp4|max:35000',
            ]);

            if($validate)
            {
                $newPost = new WebPost();
                $newPost->author_id     = $request->author_id;
                $newPost->subject_id    = $request->subject_id;
                $newPost->title         = $request->title;
                $newPost->content       = $request->content;
                $newPost->status        = 'active';
                $newPost->created_by    = Auth::user()->id;
                $newPost->created_at    = Carbon::now();
                $newPost->save();

                // add random string to the video filename
                $file = $request->file('video');
                $originalName = $file->getClientOriginalName();
                $randomString = Str::random(10);
                $newName = $randomString . '_' . $originalName;

                // store the file to public/videos with new name 
                $path = $file->storeAs('videos', $newName, 'public');

                $newAttachment              = new WebPostAttachment();
                $newAttachment->type        = 'Video';
                $newAttachment->web_post_id = $newPost->id;
                $newAttachment->filename    = $path;
                $newAttachment->created_at  = Carbon::now();

                $newAttachment->save();

                return redirect()->route('webPosts.all')->with('success', 'Successfully added new post');
            }
        }

        
        
    }
    
    public function delete($id)
    {
        dd('delete this:'.$id);
    }
}
