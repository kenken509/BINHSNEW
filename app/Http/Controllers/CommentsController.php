<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Carbon\Carbon;

class CommentsController extends Controller
{
    public function approveComment(Request $request)
    {
        //#content: "{"comment_id":1,"job":"approve"}"
        $comment = Comment::findOrFail($request->comment_id);
        //dd($request);
        
        if($request->job == 'delete'){
            $comment->delete();

            return redirect()->back()->with('success', 'Deleted Successfully');
        }
        else if($request->job == 'approve')
        {
            
            $comment->update([
                'status' => 'public',
                'approved_at' => Carbon::now(),
            ]);
            
            return redirect()->back()->with('success', 'Approved Successfully');
        }
        else if ($request->job == 'disapprove')
        {
            $comment->update([
                'status' => 'private',
                'approved_at' => null,
            ]);

            return redirect()->back()->with('success', 'Disapproved Successfully');
        }
    }

    
}
