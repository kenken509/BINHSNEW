<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Comment;
use App\Models\WebPost;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\WebPostAttachment;
use Illuminate\Support\Facades\Storage;

class WebContentsController extends Controller
{
    public function show()
    {
        $currentlyLoggedUser = Auth::user()->role;
        $instructorSubject = Auth::user()->subject_id;
        
        $posts = WebPost::with(['author','attachments'])->get();

        //dd($posts);
        $comments = Comment::with('commenter')->orderBy('approved_at', 'desc')->get();
       

        if($currentlyLoggedUser == 'admin')
        {
            return inertia('AdminDashboard/AdminPages/WebsiteManagement/Admin/PostsAll',[
                'posts' => $posts,
                // 'comments' => $comments,
            ]);
        }
        
        if($currentlyLoggedUser == 'instructor')
        {
            
            
            $instructorPost = WebPost::with(['author','attachments'])
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
        return inertia('AdminDashboard/AdminPages/WebsiteManagement/Instructor/InstructorPostAdd');
    }

    public function instructorStorePost(Request $request)
    {
       
        
        if(!$request->attachment || $request->attachment['name'] == 'None'){
            //{"author_id":4,"attachment":null,"subject_id":3,"title":null,"content":null,"status":"public","images":[],"video":null,"created_by":4}
            //dd('wala nang image');
            $post =  $request->validate([
                'title'     => 'required|max:50',
                'content'   => 'required|max:50000',
            ]);

            
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
            
            $validated = $request->validate([
                'title'     => 'required|max:50',
                'content'   => 'required|max:50000',
                'image'  => 'required|mimes:jpg,jpeg,png|max:3000'
            ],[
                'image'     => 'The image file must ba a file of type: jpg, jpeg, png, with a max size of 3mb'
            ]);
            
            if(!$request->file('image'))
            {
                return redirect()->back()->with('error', 'The image file must ba a file of type: jpg, jpeg, png, with a max size of 3mb');
            };
            
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

                $imageFile = $request->file('image');
                $originalName = $imageFile->getClientOriginalName();
                $randomString = Str::random(10);
                $imageNewName = $randomString.'_'.$originalName;

                $path = $imageFile->storeAs('Images', $imageNewName,'public');

                $newAttachment              = new WebPostAttachment();
                $newAttachment->type        = 'Image';
                $newAttachment->web_post_id = $newPost->id;
                $newAttachment->filename    = $path;
                $newAttachment->created_at  = Carbon::now();

                $newAttachment->save();


                //multi media storing
                // foreach($request->file('images') as $file)
                // {
                    
                //     $path = $file->store('images', 'public');

                //     $newAttachment              = new WebPostAttachment();
                //     $newAttachment->type        = 'Image';
                //     $newAttachment->web_post_id = $newPost->id;
                //     $newAttachment->filename    = $path;
                //     $newAttachment->created_at  = Carbon::now();

                //     $newAttachment->save();
                // }


                
                return redirect()->route('webPosts.all')->with('success', 'Successfully added new post');
            }
        }
        else if($request->attachment['name'] == 'Video')
        {
            
            

            $validate = $request->validate([
                'title' => 'required|max:50',
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

    public function updatePost(Request $request)
    {
       
        $postToUpdate = WebPost::with('attachments')->where('id',$request->id)->first();
        //{"id":5,"author_id":5,"subject_id":4,"title":"test add image","content":"j;lakjsdflk","updated_by":5}

        if($request->attachment['name'] == 'None')
        {
            $request->validate([
                'title' => 'required|max:50',
                'content' => 'required|max:50000',
            ]);
            
            $attachments = $postToUpdate->attachments;

            if ($attachments->count() > 0) {
                // Delete attachments
                
                foreach ($attachments as $attachment) {
                    // Delete attachment file from storage or perform any other necessary cleanup
                    Storage::disk('public')->delete($attachment->filename);
                    $attachment->delete();
                }

                $postToUpdate->title = $request->title;
                $postToUpdate->content = $request->content;
                $postToUpdate->updated_by = Auth::user()->id;
                $postToUpdate->save();

                return redirect()->route('webPosts.all')->with('success', 'Successfully Updated');
            }
            else
            {
                $postToUpdate->title = $request->title;
                $postToUpdate->content = $request->content;
                $postToUpdate->updated_by = Auth::user()->id;
                $postToUpdate->save();

                return redirect()->route('webPosts.all')->with('success', 'Successfully Updated');
            }
                
            
        }

        if($request->attachment['name']=='Image')
        {
            
            $attachments = $postToUpdate->attachments;

            if ($attachments->count() > 0) // with existing attachment
            {
                
                //validation
                if($attachments[0]->filename == $request->image)
                {
                    $request->validate([
                        'title' => 'required|max:50',
                        'content' => 'required|max:50000',
                    ]);
                }
                else
                {
                    $validated = $request->validate([
                        'title'     => 'required|max:50',
                        'content'   => 'required|max:50000',
                        'image'  => 'required|mimes:jpg,jpeg,png|max:3000'
                    ],[
                        'image'     => 'The image file must ba a file of type: jpg, jpeg, png, with a max size of 3mb'
                    ]);
                };

                if($request->file('image'))
                {
                    // Delete attachments
                    foreach ($attachments as $attachment) {
                        // Delete attachment file from storage or perform any other necessary cleanup
                        Storage::disk('public')->delete($attachment->filename);
                        $attachment->delete();
                    }
    
                    $postToUpdate->title = $request->title;
                    $postToUpdate->content = $request->content;
                    $postToUpdate->updated_by = Auth::user()->id;
                    $postToUpdate->save();
    
    
                    $imageFile = $request->file('image');
                    $originalName = $imageFile->getClientOriginalName();
                    $randomString = Str::random(10);
                    $newName = $randomString.'_'.$originalName;
                    $path = $imageFile->storeAs('Image',$newName,'public');
    
                    $newAttachment = new WebPostAttachment();
                    $newAttachment->type = 'Image';
                    $newAttachment->web_post_id = $postToUpdate->id;
                    $newAttachment->filename = $path;
                    $newAttachment->save(); 
                }
                else
                {
                    $postToUpdate->title = $request->title;
                    $postToUpdate->content = $request->content;
                    $postToUpdate->updated_by = Auth::user()->id;
                    $postToUpdate->save();
                    
                };
                
                

                return redirect()->route('webPosts.all')->with('success', 'Successfully Updated');
            }
            else // no existing attachment
            {
                $validated = $request->validate([
                    'title'     => 'required|max:50',
                    'content'   => 'required|max:50000',
                    'image'  => 'required|mimes:jpg,jpeg,png|max:3000'
                ],[
                    'image'     => 'The image file must ba a file of type: jpg, jpeg, png, with a max size of 3mb'
                ]);

                $postToUpdate->title = $request->title;
                $postToUpdate->content = $request->content;
                $postToUpdate->updated_by = Auth::user()->id;
                $postToUpdate->save();

                $imageFile = $request->file('image');
                $originalName = $imageFile->getClientOriginalName();
                $randomString = Str::random(10);
                $newName = $randomString.'_'.$originalName;
                $path = $imageFile->storeAs('Image',$newName,'public');

                $newAttachment = new WebPostAttachment();
                $newAttachment->type = 'Image';
                $newAttachment->web_post_id = $postToUpdate->id;
                $newAttachment->filename = $path;
                $newAttachment->save();

                return redirect()->route('webPosts.all')->with('success', 'Successfully Updated');
            }
        }

        if($request->attachment['name']=='Video')
        {
            $attachments = $postToUpdate->attachments;
            if ($attachments->count() > 0) // with existing attachment
            {
                if($attachments[0]->filename == $request->video) //same with existing attachment
                {
                    $request->validate([
                        'title' => 'required|max:50',
                        'content' => 'required|max:50000',
                    ]);

                    $postToUpdate->title = $request->title;
                    $postToUpdate->content = $request->content;
                    $postToUpdate->updated_by = Auth::user()->id;
                    $postToUpdate->save();
                }
                else // new video attachment
                {
                    $validated = $request->validate([
                        'title'     => 'required|max:50',
                        'content'   => 'required|max:50000',
                        'video'     => 'required|mimetypes:video/mp4|max:35000',
                    ],[
                        'video'     => 'The video file must ba a file of type: mp4, with a max size of 35mb'
                    ]);


                    foreach ($attachments as $attachment) {
                        // Delete attachment file from storage or perform any other necessary cleanup
                        Storage::disk('public')->delete($attachment->filename);
                        $attachment->delete();
                    }
                    
                    $videoFile = $request->file('video');
                    $originalName = $videoFile->getClientOriginalName();
                    $randomString = Str::random(10);
                    $newName = $randomString.'_'.$originalName;
                    $path = $videoFile->storeAs('videos', $newName, 'public');

                    $postToUpdate->title = $request->title;
                    $postToUpdate->content = $request->content;
                    $postToUpdate->updated_by = Auth::user()->id;
                    $postToUpdate->save();

                    $newAttachment = new WebPostAttachment();
                    $newAttachment->type = 'Video';
                    $newAttachment->web_post_id = $postToUpdate->id;
                    $newAttachment->filename = $path;
                    $newAttachment->save();
                    
                };

                return redirect()->route('webPosts.all')->with('success', 'Successfully Updated');
            }
            else // without existing attachment
            {
                $validated = $request->validate([
                    'title'     => 'required|max:50',
                    'content'   => 'required|max:50000',
                    'video'     => 'required|mimetypes:video/mp4|max:35000',
                ],[
                    'video'     => 'The video file must ba a file of type: mp4, with a max size of 35mb'
                ]);

                $videoFile = $request->file('video');
                $originalName = $videoFile->getClientOriginalName();
                $randomString = Str::random(10);
                $newName = $randomString.'_'.$originalName;
                $path = $videoFile->storeAs('videos', $newName, 'public');

                $postToUpdate->title = $request->title;
                $postToUpdate->content = $request->content;
                $postToUpdate->updated_by = Auth::user()->id;
                $postToUpdate->save();

                $newAttachment = new WebPostAttachment();
                $newAttachment->type = 'Video';
                $newAttachment->web_post_id = $postToUpdate->id;
                $newAttachment->filename = $path;
                $newAttachment->save();

                return redirect()->route('webPosts.all')->with('success', 'Successfully Updated');
            }
        }


        
    }
    
    public function delete($id)
    {
        $postToDelete = WebPost::where('id','=', $id)->with('attachments')->first();
        

        if($postToDelete->attachments)
        {
            foreach($postToDelete->attachments as $file)
            {
                Storage::disk('public')->delete($file->filename);
            }
        }
        
        $postToDelete->delete();

        return redirect()->back()->with('success', 'Successfully deleted!');
    }

    public function showInstructorEditPost($id)
    {
        $postToEdit = WebPost::where('id','=',$id)->with(['attachments','author'])->first();

        //dd($postToEdit);
        return inertia('AdminDashboard/AdminPages/WebsiteManagement/Instructor/InstructorPostEdit', [
            'post' => $postToEdit,
        ]);
    }
}
