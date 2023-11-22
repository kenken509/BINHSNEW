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
                ->with(['attachments',
                        'author',
                        'reactions' => function ($query){
                            $query->with('reactingUser');
                        } ])
                ->withCount('reactions')
                ->orderBy('created_at', 'desc')->get();
        
               

         // Check if the user has reacted to each post
        foreach ($posts as $post) {
            $userReaction = $post->reactions->where('user_id', $user->id)->first();
            //$post->userHasReacted = $post->userHasReacted($user);
            $post->userHasReacted = !is_null($userReaction);

            // Include the type of reaction in the post data
            $post->userReactionType = $post->userHasReacted ? $userReaction->type : null;

            // Count the number of reactions of type 'heart' and 'like'
            $post->heartReactionsCount = $post->reactions->where('type', 'heart')->count();
            $post->likeReactionsCount = $post->reactions->where('type', 'like')->count();
            
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
        // $request: {"web_post_id":3,"type":"like or heart"}
        //dd($request);
        $userId = Auth::user()->id;
        $webPostId = $request->web_post_id;

        // Check if the user has already reacted to the post
        $existingReaction = PostReaction::where('web_post_id', $webPostId)
                        ->where('user_id', $userId)
                        ->first();

        
        if ($existingReaction) {
            // User has already liked the post, so unlike it
            
            $existingReaction->delete();
            
        } else {
            
            // User has not liked the post, so create a new reaction
            $postReaction = new PostReaction();
            $postReaction->web_post_id = $webPostId;
            $postReaction->user_id = $userId;
            $postReaction->type = $request->type;
            $postReaction->save();
            
        }

        return redirect()->back();

    }

   
}
