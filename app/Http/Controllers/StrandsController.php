<?php

namespace App\Http\Controllers;

use App\Models\WebPost;
use Illuminate\Http\Request;

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

        $posts = WebPost::where('subject_id','=',3)->with(['attachments','author'])->orderBy('created_at', 'desc')->get();
        //dd($posts);
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

   
}
