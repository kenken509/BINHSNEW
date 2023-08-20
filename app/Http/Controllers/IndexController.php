<?php

namespace App\Http\Controllers;

use App\Models\WebPost;
use App\Models\NewsPagePost;
use Illuminate\Http\Request;
use App\Models\AboutPagePost;
use App\Models\ContactPagePost;
use App\Models\DownloadsPagePost;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(){
        //dd(Auth::user());
        return inertia('Index/Index');
    }
    
    public function show(){
        return inertia('Index/Show',[
            'currentUrl' => 'home'
        ]);
    }

    public function showAbout(){
        $posts = AboutPagePost::all();
        

        return inertia('Index/WebPages/About', [
            'posts' => $posts,
        ]);
    }

    public function showContact(){

        $posts = ContactPagePost::all();
        return inertia('Index/WebPages/Contact',[
            'posts' => $posts,
        ]);
    }

    public function showDownloads(){
        $posts = DownloadsPagePost::with('author')->get();
        return inertia('Index/WebPages/Downloads',[
            'posts' => $posts,
        ]);
    }

    public function showNews(){

        $posts = NewsPagePost::orderBy('created_at','desc')->get();
        
        return inertia('Index/WebPages/News',[
            'posts' => $posts,
        ]);
    }

    // full post controller
    public function showFullPost($page, $id)
    {
        
        if($page == 'news')
        {
            $post = NewsPagePost::findOrFail($id);

            return inertia('Index/WebPages/FullPostViews/PostFullView',[
                'post' => $post,
            ]);
        }

        if($page == 'afa')
        {
            
            
            $post = WebPost::with(['attachments','author'])->where('id',$id)->first();
            
            return inertia('Index/WebPages/FullPostViews/TracksFullViewCard',[
                'post' => $post,
            ]);
        }

        if($page == 'downloads')
        {
            
            $post = DownloadsPagePost::with(['author'])->where('id',$id)->first();
            
            return inertia('Index/WebPages/FullPostViews/DownloadsFullPostView',[
                'post' => $post,
            ]);
        }

        if($page == 'ia')
        {
            
            $post = WebPost::with(['attachments','author'])->where('id',$id)->first();
            
            
            return inertia('Index/WebPages/FullPostViews/TracksFullViewCard',[
                'post' => $post,
            ]);
        }
    }
}
