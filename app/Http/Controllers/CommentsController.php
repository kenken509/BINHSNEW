<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    public function approveComment(Request $request)
    {
        //#content: "{"comment_id":1,"job":"approve"}"
        $comment = Comment::findOrFail($request->comment_id);
       
        
        if($request->job == 'delete'){
            $comment->delete();

            return redirect()->back()->with('success', 'Deleted Successfully');
        }
        else
        {
            
            $comment->update([
                'status' => 'public',
            ]);
            
            return redirect()->back()->with('success', 'Approved Successfully');
        }
    }
}
