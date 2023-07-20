<?php

namespace App\Http\Controllers;

use App\Models\WebPost;
use Illuminate\Http\Request;

class StrandsController extends Controller
{
    public function showHE(){
        return inertia('Index/WebPages/Strands/HomeEconomics');
    }

    public function showICT(){

        $posts = WebPost::where('subject_id','=',3)->with('attachments')->orderBy('created_at', 'desc')->get();
        
        return inertia('Index/WebPages/Strands/ICT', [
            'posts' => $posts,
        ]);
    }

    public function showIA(){
        return inertia('Index/WebPages/Strands/IndustrialArts');
    }

    public function showAgriFisheryArts(){
        return inertia('Index/WebPages/Strands/AgriFisheryArts');
    }
}
