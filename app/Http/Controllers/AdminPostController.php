<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\AdminPost;
use Illuminate\Support\Str;
use App\Models\NewsPagePost;
use Illuminate\Http\Request;
use App\Models\AboutPagePost;
use App\Models\ContactPagePost;
use App\Models\DownloadsPagePost;
use Illuminate\Support\Facades\Validator;

class AdminPostController extends Controller
{
    public function showAllPost()
    {

        return inertia('AdminDashboard/AdminPages/WebsiteManagement/Admin/PostsAll',[
            'posts' => AdminPost::all(),
            'about' => AboutPagePost::with('author')->get(),
            'contacts' => ContactPagePost::with('author')->get(),
            'news' => NewsPagePost::with('author')->get(),
            'downloads' => DownloadsPagePost::with('author')->get(),
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
            
            if($request->media == 'image')
            {
                $imageFile = $request->file('image');
                $originalName = $imageFile->getClientOriginalName();
                $randomString = Str::random(10);
                $newName = $randomString.'_'.$originalName;
                $imagePath = $imageFile->storeAs('Images', $newName, 'public');

                $installerFile = $request->file('installer');
                $installerOriginalName  = $installerFile->getClientOriginalName();
                $randString = Str::random(10);
                $newInstallerName = $randString.'_'.$installerOriginalName;
                $installerPath = $installerFile->storeAs('Installer', $newInstallerName, 'public');

                $post = new DownloadsPagePost();
                $post->title = $request->title;
                $post->mediaType = $request->media;
                $post->mediaFileName = $imagePath;
                $post->installerFileName = $installerPath;
                $post->content = $request->content;
                $post->created_by = Auth::user()->id;
                $post->save();

                return redirect()->route('admin.post.all')->with('success', 'Successfully added new post on News Page!');

            }

            if($request->media == 'video')
            {
                $videoFile = $request->file('video');
                $originalName = $videoFile->getClientOriginalName();
                $randomString = Str::random(10);
                $newName = $randomString.'_'.$originalName;
                $videoPath = $videoFile->storeAs('videos', $newName,'public');

                $installerFile = $request->file('installer');
                $installerOriginalName  = $installerFile->getClientOriginalName();
                $randString = Str::random(10);
                $newInstallerName = $randString.'_'.$installerOriginalName;
                $installerPath = $installerFile->storeAs('Installer', $newInstallerName, 'public');

                $post = new DownloadsPagePost();
                $post->title = $request->title;
                $post->mediaType = $request->media;
                $post->mediaFileName = $videoPath;
                $post->installerFileName = $installerPath;
                $post->content = $request->content;
                $post->created_by = Auth::user()->id;
                $post->save();

                return redirect()->route('admin.post.all')->with('success', 'Successfully added new post on News Page!');
            }

            if($request->media == null)
            {
                    $file = $request->file('installer');
                    $originalName = $file->getClientOriginalName();
                    $randomString = Str::random(10);
                    $newName = $randomString . '_' . $originalName;

                    $path = $file->storeAs('Installer', $newName, 'public');

                    $post = new DownloadsPagePost();
                    $post->title    = $request->title;
                    $post->installerFileName = $path;
                    $post->content  = $request->content;
                    $post->created_by = Auth::user()->id;
                    $post->save();

                    return redirect()->route('admin.post.all')->with('success', 'Successfully added new post on News Page!');
            }
        } 
    }

    
    // delete functions

    public function aboutPostDelete($id)
    {
        $postToDelete = AboutPagePost::findOrFail($id);

        $postToDelete->delete();

        return redirect()->back()->with('success', 'Successfully Deleted!');
    }

    public function contactPostDelete($id)
    {
        $postToDelete = ContactPagePost::findOrFail($id);

        $postToDelete->delete();

        return redirect()->back()->with('success', 'Successfully Deleted!');
    }

    public function newsPostDelete($id)
    {
        $postToDelete = NewsPagePost::findOrFail($id);

        $postToDelete->delete();

        return redirect()->back()->with('success', 'Successfully Deleted!');
    }
    
}
