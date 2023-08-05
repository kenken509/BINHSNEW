<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\AdminPost;
use Illuminate\Support\Str;
use App\Models\NewsPagePost;
use Illuminate\Http\Request;
use App\Models\AboutPagePost;
use App\Models\ContactPagePost;

class AdminPostController extends Controller
{
    public function showAllPost()
    {

        return inertia('AdminDashboard/AdminPages/WebsiteManagement/Admin/PostsAll',[
            'posts' => AdminPost::all(),
            'about' => AboutPagePost::with('author')->get(),
            'contacts' => ContactPagePost::with('author')->get(),
            'news' => NewsPagePost::with('author')->get(),
        ]);
    }

    public function showAddPost()
    {
        return inertia('AdminDashboard/AdminPages/WebsiteManagement/Admin/PostAdd');
    }
    public function storePost(Request $request)
    {
       if($request->page == 'About')
       {
            $validated = $request->validate([
                'title'     => 'required',
                'content'   => 'required|max:50000',
            ]);

            if($validated)
            {
                $post = new AboutPagePost();

                $post->title        = $request->title;
                $post->content      = $request->content;
                $post->created_by   = Auth::user()->id;
                $post->save();

                return redirect()->route('admin.post.all')->with('success', 'Successfully added new post on About Page!');
            }
       }

       if($request->page == 'Contacts')
       {
            $post = new ContactPagePost();

            $post->name = $request->name;
            $post->phoneNumber = $request->phoneNumber;
            $post->email = $request->email;
            $post->created_by = Auth::user()->id;
            $post->save();

            return redirect()->route('admin.post.all')->with('success', 'Successfully added new post on Contact Page!');
       }

       if($request->page == 'News')
       {
            if($request->hasFile('image'))
            {
                
                $validated = $request->validate([
                    'title'     => 'required|max:50',
                    'content'   => 'required|max:50000',
                    'image'     => 'mimes:jpg,jpeg,png|max:3000'
                ]);

                if($validated)
                {
                    $file = $request->file('image');
                    $originalName = $file->getClientOriginalName();
                    $randomString = Str::random(10);
                    $newName = $randomString . '_' . $originalName;

                    $path = $file->storeAs('images', $newName, 'public');

                    $post = new NewsPagePost();
                    $post->title    = $request->title;
                    $post->filename = $path;
                    $post->content  = $request->content;
                    $post->created_by = Auth::user()->id;
                    $post->save();

                    return redirect()->route('admin.post.all')->with('success', 'Successfully added new post on News Page!');
                }
                

                // $newAttachment              = new WebPostAttachment();
                // $newAttachment->type        = 'Image';
                // $newAttachment->web_post_id = $newPost->id;
                // $newAttachment->filename    = $path;
                // $newAttachment->created_at  = Carbon::now();

                // $newAttachment->save();
            }
            else
            {
                
                $post = new NewsPagePost();
                
                $post->title    = $request->title;
                $post->content  = $request->content;
                $post->created_by = Auth::user()->id;
                $post->save();

                return redirect()->route('admin.post.all')->with('success', 'Successfully added new post on News Page!');
            }
       }

       if($request->page == 'Downloads')
       {
        
            $validated = $request->validate([
                'title'     => 'required|max:30',
                'content'   => 'required|max:50000',
                'installer.*' => 'required|mimes:application/x-msdownload',
            ]);

            if($validated)
            {
                dd('save mo na');
            }
       }
    }
}
