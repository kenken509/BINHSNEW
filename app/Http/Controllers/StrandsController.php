<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\WebPost;
use App\Models\PostReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StrandsController extends Controller
{
    public function showAgriFisheryArts(){
        $agriFisheryArtsPosts = WebPost::where('subject_id','=',1)->with(['attachments','author'])->orderBy('created_at', 'desc')->get();
        return inertia('Index/WebPages/Strands/AgriFisheryArts',[
            'posts' => $agriFisheryArtsPosts,
        ]);
    }

    public function showHE(){

        $homeEconomicsPosts = WebPost::where('subject_id','=',2)->with(['attachments','author'])->orderBy('created_at', 'desc')->get();
        
        return inertia('Index/WebPages/Strands/HomeEconomics', [
            'posts' => $homeEconomicsPosts,
        ]);
    }

    public function showICT(){

        $user = Auth::user();
        
        $posts = WebPost::where('subject_id','=',3)
                ->with(['attachments','author'])
                ->withCount('reactions')
                ->orderBy('created_at', 'desc')->get();
        
         // Check if the user has reacted to each post
        foreach ($posts as $post) {
            $post->userHasReacted = $post->userHasReacted($user);
        }

       
        return inertia('Index/WebPages/Strands/ICT', [
            'posts' => $posts,
        ]);
    }

    public function showIA(){
        $posts = WebPost::where('subject_id','=',4)->with(['attachments','author'])->orderBy('created_at', 'desc')->get();

        return inertia('Index/WebPages/Strands/IndustrialArts', [
            'posts' => $posts,
        ]);
    }

    public function toggleLike(Request $request)
    {
        // $request: {"web_post_id":3,"type":"like"}
        $userId = Auth::user()->id;
        $webPostId = $request->web_post_id;

        // Check if the user has already liked the post
        $existingReaction = PostReaction::where('web_post_id', $webPostId)
                        ->where('user_id', $userId)
                        ->first();

        
        if ($existingReaction) {
            // User has already liked the post, so unlike it
            
            $existingReaction->delete();
            $liked = false;
        } else {
            
            // User has not liked the post, so create a new reaction
            $postReaction = new PostReaction();
            $postReaction->web_post_id = $webPostId;
            $postReaction->user_id = $userId;
            $postReaction->type = $request->type;
            $postReaction->save();
            $liked = true;
        }

        return redirect()->back()->with('liked', $liked);

    }

   
}
