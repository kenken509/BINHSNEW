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
use Illuminate\Support\Facades\Storage;
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
        return inertia('AdminDashboard/AdminPages/WebsiteManagement/Admin/AdminPostAdd');
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

                    $path = $file->storeAs('Images', $newName, 'public');

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
            $request->validate([
                'installerType' => 'required',
            ],[
                'installerType' => 'File type is required',
            ]);
            //dd($request->installerType);
            #parameters: array:11 [▼
            // "name" => null
            // "phoneNumber" => null
            // "email" => null
            // "title" => "asdf"
            // "content" => "asdf"
            // "page" => "Downloads"
            // "media" => null
            // "image" => null
            // "video" => null
            // "installer" => null
            // "installerLink" => "https://drive.google.com/your-download-link"
            // ]
            if($request->media == 'image')
            {
                $imageFile = $request->file('image');
                $originalName = $imageFile->getClientOriginalName();
                $randomString = Str::random(10);
                $newName = $randomString.'_'.$originalName;
                $imagePath = $imageFile->storeAs('Images', $newName, 'public');

                // $installerFile = $request->file('installer');
                // $installerOriginalName  = $installerFile->getClientOriginalName();
                // $randString = Str::random(10);
                // $newInstallerName = $randString.'_'.$installerOriginalName;
                // $installerPath = $installerFile->storeAs('Installer', $newInstallerName, 'public');

                $post = new DownloadsPagePost();
                $post->title = $request->title;
                $post->mediaType = $request->media;
                $post->mediaFileName = $imagePath;
                $post->installerLink = $request->installerLink;
                $post->installerType = $request->installerType;
                $post->content = $request->content;
                $post->created_by = Auth::user()->id;
                $post->save();

                return redirect()->route('admin.post.all')->with('success', 'Successfully added new post on Downloads Page!');

            }

            if($request->media == 'video')
            {
                
                $videoFile = $request->file('video');
                $originalName = $videoFile->getClientOriginalName();
                $randomString = Str::random(10);
                $newName = $randomString.'_'.$originalName;
                $videoPath = $videoFile->storeAs('videos', $newName,'public');

                // $installerFile = $request->file('installer');
                // $installerOriginalName  = $installerFile->getClientOriginalName();
                // $randString = Str::random(10);
                // $newInstallerName = $randString.'_'.$installerOriginalName;
                // $installerPath = $installerFile->storeAs('Installer', $newInstallerName, 'public');

                $post = new DownloadsPagePost();
                $post->title = $request->title;
                $post->mediaType = $request->media;
                $post->mediaFileName = $videoPath;
                $post->installerLink = $request->installerLink;
                $post->installerType = $request->installerType;
                $post->content = $request->content;
                $post->created_by = Auth::user()->id;
                $post->save();

                return redirect()->route('admin.post.all')->with('success', 'Successfully added new post on Downloads Page!');
            }

            if($request->media == null)
            {
                    // $file = $request->file('installer');
                    // $originalName = $file->getClientOriginalName();
                    // $randomString = Str::random(10);
                    // $newName = $randomString . '_' . $originalName;

                    // $path = $file->storeAs('Installer', $newName, 'public');

                    $post = new DownloadsPagePost();
                    $post->title    = $request->title;
                    $post->installerLink = $request->installerLink;
                    $post->installerType = $request->installerType;
                    $post->content  = $request->content;
                    $post->created_by = Auth::user()->id;
                    $post->save();

                    return redirect()->route('admin.post.all')->with('success', 'Successfully added new post on Downloads Page!');
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
        //this post could have an image
        $postToDelete = NewsPagePost::findOrFail($id);
        
        if($postToDelete->filename)
        {
            Storage::disk('public')->delete($postToDelete->filename);

            $postToDelete->delete();

            return redirect()->back()->with('success', 'Successfully Deleted!');
        }
        else
        {
            $postToDelete->delete();

            return redirect()->back()->with('success', 'Successfully Deleted!');
        }
        
    }
    
    public function downloadsPostDelete($id)
    {
        $postToDelete = DownloadsPagePost::findOrFail($id);

        if($postToDelete->mediaFileName)
        {
            Storage::disk('public')->delete($postToDelete->mediaFileName);
            //Storage::disk('public')->delete($postToDelete->installerFileName);

            $postToDelete->delete();

            return redirect()->back()->with('success', 'Successfully Deleted!');
        }
        else
        {
            //Storage::disk('public')->delete($postToDelete->installerFileName);

            $postToDelete->delete();

            return redirect()->back()->with('success', 'Successfully Deleted!');
        }
    }

    //update functions
   
    public function showEditPost($id, $page)
    {
        
        if($page == 'About')
        {
            $postToEdit = AboutPagePost::findOrFail($id);

            return inertia('AdminDashboard/AdminPages/WebsiteManagement/Admin/PostEdit',[
                'post' => $postToEdit,
                'webPage' => $page,
            ]);
        }

        if($page == 'Contacts')
        {
            $postToEdit = ContactPagePost::findOrFail($id);
            return inertia('AdminDashboard/AdminPages/WebsiteManagement/Admin/PostEdit',[
                'post' => $postToEdit,
                'webPage' => $page,
            ]);
        }

        if($page == 'News')
        {
            $postToEdit = NewsPagePost::findOrFail($id);
            return inertia('AdminDashboard/AdminPages/WebsiteManagement/Admin/PostEdit',[
                'post' => $postToEdit,
                'webPage' => $page,
            ]);
        }
        
        if($page == 'Downloads')
        {
            $postToEdit = DownloadsPagePost::findOrFail($id);

            return inertia('AdminDashboard/AdminPages/WebsiteManagement/Admin/PostEdit',[
                'post' => $postToEdit,
                'webPage' => $page,
            ]);
        }
    }

    public function storeEditPost(Request $request)
    {
        //dd($request);

        #parameters: array:11 [▼
        //     "id" => "3"
        //     "page" => "Downloads"
        //     "title" => "aaaaaaaaaaaaaaa"
        //     "content" => "aaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
        //     "name" => null
        //     "phoneNumber" => null
        //     "email" => null
        //     "mediaType" => "video"
        //     "image" => null
        //     "installer" => null
        //     "installerLink" => "https://drive.google.com/file/d/1Nw1Dect8dlw-JkRatXqYKsuWqBuqwNmn/view?usp=drive_link"
        // ]
        if($request->page == 'About')
        {
            $postToUpdate = AboutPagePost::findOrFail($request->id);

            $postToUpdate->title = $request->title;
            $postToUpdate->content = $request->content;
            $postToUpdate->updated_by = Auth::user()->id;
            $postToUpdate->save();

            return redirect()->route('admin.post.all')->with('success', 'Successfully Updated!');
        }

        if($request->page == 'Contacts')
        {
            $postToUpdate = ContactPagePost::findOrFail($request->id);

            $postToUpdate->name = $request->name;
            $postToUpdate->phoneNumber = $request->phoneNumber;
            $postToUpdate->email = $request->email;
            $postToUpdate->updated_by = Auth::user()->id;
            $postToUpdate->save();

            return redirect()->route('admin.post.all')->with('success', 'Successfully Updated!');
        }
        
        if($request->page == 'News')
        {
            //id,page,title content,
            if($request->hasFile('image'))
            {
                // dd('merong bagong image');
                $file = $request->file('image');
                $originalName = $file->getClientOriginalName();
                $randomString = Str::random(10);
                $newName = $randomString.'_'.$originalName;

                $path = $file->storeAs('Images', $newName, 'public');

                $postToUpdate = NewsPagePost::findOrFail($request->id);
                $postToUpdate->title = $request->title;
                $postToUpdate->content = $request->content;
                $postToUpdate->filename = $path;
                $postToUpdate->updated_by = Auth::user()->id;
                $postToUpdate->save();

                return redirect()->route('admin.post.all')->with('success', 'Successfully Updated!');

            }
            
            if($request->image == null)
            {
                //dd('tinanggal ang image');
                $postToUpdate = NewsPagePost::findOrFail($request->id);

                
                $imageToDelete = $postToUpdate->filename;

                if($imageToDelete)
                {
                    Storage::disk('public')->delete($imageToDelete);
                }
                

                $postToUpdate->title = $request->title;
                $postToUpdate->content = $request->content;
                $postToUpdate->filename = null;
                $postToUpdate->updated_by = Auth::user()->id;
                $postToUpdate->save();

                return redirect()->route('admin.post.all')->with('success', 'Successfully Updated!');
            }

            if($request->image)
            {
                //dd('dating image pa din');
                $postToUpdate = NewsPagePost::findOrFail($request->id);

                $postToUpdate->title = $request->title;
                $postToUpdate->content = $request->content;
                $postToUpdate->updated_by = Auth::user()->id;
                $postToUpdate->save();

                return redirect()->route('admin.post.all')->with('success', 'Successfully Updated!');
            }
        }

        if($request->page == 'Downloads')
        {
               
            $postToUpdate = DownloadsPagePost::findOrFail($request->id);
            $existingMediaFileName = $postToUpdate->mediaFileName;
            $existingInstallerFileName = $postToUpdate->installerFileName;
            $mediaType = $request->mediaType;
            
            if($mediaType == null)
            {
                if($existingMediaFileName) // if previously has an image file
                {
                        Storage::disk('public')->delete($existingMediaFileName);

                        // $installerFile = $request->file('installer');
                        // $installerOriginalName = $installerFile->getClientOriginalName();
                        // $installerRandomString = Str::random(10);
                        // $installerNewName = $installerRandomString.'_'.$installerOriginalName;
                        // $installerPath = $installerFile->storeAs('Installer', $installerNewName, 'public');

                        $postToUpdate->title = $request->title;
                        $postToUpdate->content = $request->content;
                        $postToUpdate->mediaType = $mediaType;
                        $postToUpdate->mediaFileName = $mediaType;
                        $postToUpdate->installerLink = $request->installerLink;
                        $postToUpdate->updated_by = Auth::user()->id;
                        $postToUpdate->save();

                        return redirect()->route('admin.post.all')->with('success', 'Successfully Updated!');
                }
                else // if no existing media file
                {

                    $postToUpdate->title = $request->title;
                    $postToUpdate->content = $request->content;
                    $postToUpdate->mediaType = $mediaType;
                    $postToUpdate->mediaFileName = $mediaType;
                    $postToUpdate->installerLink = $request->installerLink;
                    $postToUpdate->updated_by = Auth::user()->id;
                    $postToUpdate->save();

                    return redirect()->route('admin.post.all')->with('success', 'Successfully Updated!');                   

                }
                
            }
            
            if($mediaType == 'image')
            {
                if(!$existingMediaFileName) // if no existing media file
                {

                    $imageFile = $request->file('image');
                    $originalName = $imageFile->getClientOriginalName();
                    $randomString = Str::random(10);
                    $newName = $randomString.'_'.$originalName;
                    $imagePath = $imageFile->storeAs('Images',$newName,'public');


                    $postToUpdate->title = $request->title;
                    $postToUpdate->content = $request->content;
                    $postToUpdate->mediaType = 'image';
                    $postToUpdate->mediaFileName = $imagePath;
                    $postToUpdate->installerLink = $request->installerLink;
                    $postToUpdate->updated_by = Auth::user()->id;
                    $postToUpdate->save();

                    return redirect()->route('admin.post.all')->with('success', 'Successfully Updated!');
                    
                }


                if($request->image == $existingMediaFileName)
                {
                    $postToUpdate->title            = $request->title;
                    $postToUpdate->content          = $request->content;
                    $postToUpdate->mediaType        = 'image';
                    $postToUpdate->installerLink    = $request->installerLink;
                    $postToUpdate->updated_by       = Auth::user()->id;
                    $postToUpdate->save();

                    return redirect()->route('admin.post.all')->with('success', 'Successfully Updated!');
                }
                else // image replaced with new image file
                {
                    
                    $imageFile = $request->file('image');
                    $originalName = $imageFile->getClientOriginalName();
                    $randomString = Str::random(10);
                    $newName = $randomString.'_'.$originalName;
                    $imagePath = $imageFile->storeAs('Images',$newName,'public');

                    Storage::disk('public')->delete($existingMediaFileName);

                    $postToUpdate->title = $request->title;
                    $postToUpdate->content = $request->content;
                    $postToUpdate->mediaType = 'image';
                    $postToUpdate->mediaFileName = $imagePath;
                    $postToUpdate->installerLink    = $request->installerLink;
                    $postToUpdate->updated_by = Auth::user()->id;
                    $postToUpdate->save();

                    return redirect()->route('admin.post.all')->with('success', 'Successfully Updated!');
                    
                };
            }
            
            if($mediaType == 'video')
            {
                if(!$existingMediaFileName) // if no existing video filename
                {
                    
                    $videoFile = $request->file('video');
                    $originalName = $videoFile->getClientOriginalName();
                    $randomString = Str::random(10);
                    $newName = $randomString.'_'.$originalName;
                    $videoPath = $videoFile->storeAs('videos',$newName,'public');

                    $postToUpdate->title = $request->title;
                    $postToUpdate->content = $request->content;
                    $postToUpdate->mediaType = 'video';
                    $postToUpdate->mediaFileName = $videoPath;
                    $postToUpdate->installerLink = $request->installerLink;
                    $postToUpdate->updated_by = Auth::user()->id;
                    $postToUpdate->save();

                    return redirect()->route('admin.post.all')->with('success', 'Successfully Updated!');
                    
                }
                
                if($request->video == $existingMediaFileName) //video was not changed
                {
                    
                    $postToUpdate->title = $request->title;
                    $postToUpdate->content = $request->content;
                    $postToUpdate->mediaType = 'video';
                    $postToUpdate->installerLink = $request->installerLink;
                    $postToUpdate->updated_by = Auth::user()->id;
                    $postToUpdate->save();

                    return redirect()->route('admin.post.all')->with('success', 'Successfully Updated!');
                }
                else // if has new video
                {
                    
                    $videoFile = $request->file('video');
                    $videoOriginalName = $videoFile->getClientOriginalName();
                    $videoRandomString = Str::random(10);
                    $videoNewName = $videoRandomString.'_'.$videoOriginalName;
                    $videoPath = $videoFile->storeAs('videos', $videoNewName, 'public');
                    Storage::disk('public')->delete($existingMediaFileName);

                    $postToUpdate->title = $request->title;
                    $postToUpdate->content = $request->content;
                    $postToUpdate->mediaType = 'video';
                    $postToUpdate->mediaFileName = $videoPath;
                    $postToUpdate->installerLink = $request->installerLink;
                    $postToUpdate->updated_by = Auth::user()->id;
                    $postToUpdate->save();
                    
                    return redirect()->route('admin.post.all')->with('success', 'Successfully Updated!');
                    
                }
                    
            }
            
        }
    }  
}


