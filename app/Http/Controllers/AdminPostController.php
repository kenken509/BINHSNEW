<?php

namespace App\Http\Controllers;

use App\Models\AdminPost;
use Illuminate\Http\Request;
use App\Models\AboutPagePost;
use App\Models\ContactPagePost;
use Auth;

class AdminPostController extends Controller
{
    public function showAllPost()
    {

        return inertia('AdminDashboard/AdminPages/WebsiteManagement/Admin/PostsAll',[
            'posts' => AdminPost::all(),
            'about' => AboutPagePost::with('author')->get(),
            'contacts' => ContactPagePost::with('author')->get(),
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
            dd($request);
       }
    }
}
