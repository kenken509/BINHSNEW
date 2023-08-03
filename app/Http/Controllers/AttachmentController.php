<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\WebPostAttachment;
use Illuminate\Support\Facades\Storage;

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

    public function updateImage(Request $request)
    {

        // "imageId" => "46"
        // "existingFilename" => "images/W58ZNi2eV1817RVZCFkJ723IbRrLT0RdeHdUU9Ua.png"
        $attachmentToUpdate = WebPostAttachment::findOrFail($request->imageId);
        $request->validate([
            'image/*' => 'required|mimes:jpg,jpeg,png|max:3000'
        ]);
        
        $file = $request->file('image');
        
        
        // add random string to the video filename
        $originalName = $file[0]->getClientOriginalName();
        $randomString = Str::random(10);
        $newName = $randomString . '_' . $originalName;
       
        //delete old filename
        Storage::disk('public')->delete($attachmentToUpdate->filename);

        // store the file to public/videos with new name 
        $path = $file[0]->storeAs('images', $newName, 'public');

        $attachmentToUpdate->filename = $path;
        $attachmentToUpdate->save();

         

        return redirect()->back()->with('success', true);
        
    }

    public function updateAddNewImage(Request $request)
    {
        
        
        $request->validate([
            'image/*' => 'required|mimes:jpg,jpeg,png|max:3000'
        ]);

        $file = $request->file('image');

        // add random string
        $originalName = $file[0]->getClientOriginalName();
        $randomString = Str::random(10);
        $newName = $randomString.' '.$originalName;

        $path = $file[0]->storeAs('images', $newName , 'public');

        $newImage = new WebPostAttachment();
        $newImage->type = $request->type;
        $newImage->web_post_id  = $request->web_post_id;
        $newImage->filename = $path;
        $newImage->save();
        

        return redirect()->back()->with('success', true);

    }

    // video controllers ********************************************

    public function updateVideo(Request $request)
    {
        $attachmentToUpdate = WebPostAttachment::findOrFail($request->id);

        $request->validate([
            'video' => 'required|mimes:mp4|max:35000'
        ]);
        
        $file = $request->file('video');
        
        
        //add random string
        $originalName = $file->getClientOriginalName();
        $randomString = Str::random(10);
        $newName      = $randomString.' '.$originalName;  

        $path = $file->storeAs('videos', $newName, 'public');
        //delete old filename
        Storage::disk('public')->delete($attachmentToUpdate->filename);
        $attachmentToUpdate->filename = $path;
        $attachmentToUpdate->save();
        
        return redirect()->back()->with('success', true);

    }
}
