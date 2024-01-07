<?php

namespace App\Http\Controllers;

use App\Models\WebPost;
use App\Models\WebAnalysis;
use Illuminate\Support\Str;
use App\Models\NewsPagePost;
use Illuminate\Http\Request;
use App\Models\AboutPagePost;
use App\Models\ContactPagePost;
use App\Models\DownloadsPagePost;
use App\Models\CarouselImageModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function index(){
        
        $posts = NewsPagePost::orderBy('created_at','desc')->first();

        // $newVisitor = new WebAnalysis();
        // record new visit upon loading this page;
        // $newVisitor->type = 'visit';
        // $newVisitor->save();
        
        return inertia('Index/Index',[
            'carouselImages' => CarouselImageModel::latest()->get(),
            'newsPost' => $posts,
        ]);
    }
    
    public function show(){
        $carouselImage = CarouselImageModel::all();
        return inertia('Index/Show',[
            'currentUrl' => 'home',
            'carouselImage' => $carouselImage,
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
        if($page == 'ict')
        {
            
            $post = WebPost::with(['attachments','author'])->where('id',$id)->first();
            
            
            return inertia('Index/WebPages/FullPostViews/TracksFullViewCard',[
                'post' => $post,
            ]);
        }
    }

    public function carouselReplaceImageStore(Request $request)
    {
        
        $imageToUpdate = CarouselImageModel::findOrFail($request->id);
        
        Storage::disk('public')->delete($imageToUpdate->filename);

        $imageFile = $request->file('filename');
        $originalName = $imageFile->getClientOriginalName();
        $randomString = Str::random(10);
        $newName = $randomString.'_'.$originalName;
        $path = $imageFile->storeAs('Images', $newName, 'public');

        $imageToUpdate->filename = $path;
        $imageToUpdate->updated_by = $request->user;
        $imageToUpdate->save();

        
        return redirect()->back()->with('success', 'Image replaced successfully!' );

    }

    public function carouselDeleteImage($id)
    {
        $imageToDelete = CarouselImageModel::findOrFail($id);

        
        Storage::delete($imageToDelete->filename);

        $imageToDelete->delete();

        return redirect()->back()->with('success', 'Deleted successfully!' ); 

    }

    public function carouselAddImage(Request $request)
    {
        if($request->file('filename')){
            $imageFile = $request->file('filename');
            $originalName = $imageFile->getClientOriginalName();
            $randomString = Str::random(10);
            $newName = $randomString.'_'.$originalName;
            $path = $imageFile->storeAs('Images', $newName, 'public');

            $newImage = new CarouselImageModel();
            $newImage->filename = $path;
            $newImage->save();

            return redirect()->back()->with('success', 'Successfully Added New Image!' );

        }
        else
        {
            return redirect()->back()->with('error', 'Failed to Add Image' ); 
        }
        
        
    }
}
