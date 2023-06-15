<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SectionController extends Controller
{
    public function show(){
        
        //dd(Section::with('subject')->latest()->get());
        return inertia('AdminDashboard/AdminPages/SectionManagement/SectionAll', [
            'sections' => Section::with('subject')->latest()->get(),
        ]);
    }

    public function create(){
        return inertia('AdminDashboard/AdminPages/SectionManagement/SectionAdd', [
            'subjects' => Subject::latest()->get(),
        ]);
    }

    public function store(Request $request){

        //{"name":"32A1","subject_id":1}
        $section = Section::make($request->validate([
            'name'          => 'required',
            'subject_id'    => 'required',
        ],[
            'name.unique' => 'Please enter non-existing section',
        ]));

        $section->save();
        return redirect()->route('section.show')->with('success', 'Successfully added new section!');
    }

    public function delete(Section $section){
        $section->delete();
        return redirect()->back()->with('success', 'Successfully deleted!');
    }

    public function edit($id){
        //dd(Section::with('subject')->findOrFail($id));
        //dd(Subject::all());
        return inertia('AdminDashboard/AdminPages/SectionManagement/SectionEdit', [
            'section' => Section::with('subject')->findOrFail($id),
            'subjects' => Subject::all(),
        ]);
    }

    public function update(Request $request){

        // {"section_id":6,"name":"32A1","subject_id":2}
        $data = $request->validate([
            'name'          => 'required',
            'subject_id'    => 'required',
        ]);

        if($data){
            $section = Section::findOrFail($request->section_id);

            $section->name          = $request->name;
            $section->subject_id    = $request->subject_id;
            $section->updated_by    = Auth::user()->id;
            $section->updated_at    = Carbon::now();
            $section->save();

            return redirect()->route('section.show')->with('success', 'Successfully Updated');
        }

        
    }
}
