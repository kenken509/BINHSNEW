<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Question;
use App\Models\Choice;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class QuestionsController extends Controller
{
    public function questionsShow(){

            //dd(Question::with(['choices','subjects'])->get());
            return inertia('AdminDashboard/AdminPages/ExaminationManagement/QuestionsManagement/QuestionsAll',[
                'questions' => Question::with(['choices','subjects'])->get(),
        ]);
    }

    public function create(){
        return inertia('AdminDashboard/AdminPages/ExaminationManagement/QuestionsManagement/QuestionAdd', [
            'subjects' => Subject::all(),
        ]);
    }

    // question: null,
    // correct_answer:null,
    // option_a:null,
    // option_b:null,
    // option_c:null,
    // option_d:null,
    public function store(Request $request){

        //dd($request->subject_id);
        $data = $request->validate([
            'subject_id'        => 'required',
            'question'          => 'required|min:11|max:500',
            'correct_answer'    => 'required',
            'option_a'          => 'required',
            'option_b'          => 'required',
            'option_c'          => 'required',
            'option_d'          => 'required',
        ]);

        if($data){
                //if role == admin do this

                //if role == instructor do this
                $newQuestion = new Question();

                $newQuestion->question          = $request->question;
                $newQuestion->correct_answer    = $request->correct_answer;
                $newQuestion->subject_id        = $request->subject_id;
                $newQuestion->created_by        = Auth::user()->id;
                $newQuestion->created_at        = Carbon::now();
                $newQuestion->save();
        }

        $questionId = $newQuestion->id;

        $option = new Choice();
        $option->question_id = $questionId;
        $option->a = $request->option_a;
        $option->b = $request->option_b;
        $option->c = $request->option_c;
        $option->d = $request->option_d;
        $option->created_at = Carbon::now();
        
        // Save the option to the options table
        $option->save();
        
        return redirect()->route('question.all')->with('success', 'Successfully Updated!');

    }

    public function edit($id){

        //$question = Question::with('subjects')->findOrFail($id);

        //dd($question);
        return inertia('AdminDashboard/AdminPages/ExaminationManagement/QuestionsManagement/QuestionEdit', [
            'question' => Question::with(['subjects','choices'])->findOrFail($id),
            'subjects' => Subject::all(),
        ]);
    }

    /* 
        "subject_id" => 2
        "question" => "this is a question posted by an admin for ict subject"
        "correct_answer" => "test answer"
        "option_a" => "a"
        "option_b" => "b"
        "option_c" => "c"
        "option_d" => "d"
    */
    public function update(Request $request){
        
        $data = $request->validate([
            'subject_id'        => 'required',
            'question'          => 'required|min:11|max:500',
            'correct_answer'    => 'required',
            'option_a'          => 'required',
            'option_b'          => 'required',
            'option_c'          => 'required',
            'option_d'          => 'required',
        ]);

        if($data){
            
            $updateQuestion = Question::with(['choices'])->findOrFail($request->questionId);
            
            $updateQuestion->subject_id         = $request->subject_id;
            $updateQuestion->question           = $request->question;
            $updateQuestion->correct_answer     = $request->correct_answer;
            $updateQuestion->updated_by         = Auth::user()->id;
            $updateQuestion->updated_at         = Carbon::now();
            $updateQuestion->save();
            $choices                            = $updateQuestion->choices;
            $choices->a                         = $request->option_a;
            $choices->b                         = $request->option_b;
            $choices->c                         = $request->option_c;
            $choices->d                         = $request->option_d;
            $choices->save();     

        }

        return redirect()->route('question.all')->with('success', 'Successfully Updated!');
    }



    public function delete(Question $question){
        $question->delete();
        return redirect()->back()->with('success', 'Deleted Successfully');
    }

}
