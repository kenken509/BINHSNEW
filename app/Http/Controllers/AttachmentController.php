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
       
        // store the file to public/videos with new name 
        $path = $file[0]->storeAs('images', $newName, 'public');

        $attachmentToUpdate->filename = $path;
        $attachmentToUpdate->save();

        Storage::disk('public')->delete($request->existingFilename);

        return redirect()->back()->with('success', true);
        
    }
}
