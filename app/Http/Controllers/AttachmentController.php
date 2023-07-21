<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebPostAttachment;

class AttachmentController extends Controller
{
    public function delete($id)
    {
        $attachmentToDelete = WebPostAttachment::where('id','=', $id)->first();
        
        
        if($attachmentToDelete->attachments)
        {
                Storage::disk('public')->delete($file->filename);
        }
        
        $attachmentToDelete->delete();

        
        return redirect()->back()->with('success', true);
    }
}
