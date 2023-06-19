<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Subject;
use App\Models\QuizChoices;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuizManagementController extends Controller
{
    public function show(){

        //dd(Quiz::with(['question','subject'])->latest()->get());
        return inertia('AdminDashboard/AdminPages/ExaminationManagement/QuizManagement/Admin/QuizAll', [
            'quizzes' => Quiz::with(['question.choices','subject'])->withCount('question')->latest()->get(),
            // 'quizzes' => Quiz::with(['questions.choices' => function ($query) {  this gives a random choices
            //     $query->inRandomOrder();
            // }, 'subject'])->latest()->get(),
        ]);

    }

    public function create(){

        
        return inertia('AdminDashboard/AdminPages/ExaminationManagement/QuizManagement/Admin/QuizAdd',[
            'strands' => Subject::all(),
        ]);
    }

   

    public function store(Request $request){
        //dd($request);
        //dd($request->questions);
        $questionsArray = $request->questions;
        //dd($questionsArray);

        $validate = $request->validate([
            "subject_id"        => 'required',
            "title"             => 'required',
            "grading_period"    => 'required',
            "duration"          => 'required',
            "questions"         => 'required|array|min:1',
        ],[
            'questions'     => 'Must have at least 1 question!'
        ]);

        if($validate)
        {
           
            $quiz                   = new Quiz();
            $quiz->subject_id       = $request->subject_id;
            $quiz->title            = $request->title;
            $quiz->grading_period   = $request->grading_period;
            $quiz->duration         = $request->duration;
            $quiz->save();

            $quizId = $quiz->id;
            
            // $latestQuiz = Quiz::latest()->limit(1)->get();
            
            // $quizId = $latestQuiz[0]->id;
            
            foreach ($questionsArray as $questionData) 
            {
                $question = new QuizQuestion();
                $question->question = $questionData['question'];
                $question->quiz_id = $quizId;
                $question->correct_answer = $questionData['correct_answer'];
                $question->save();
                
                $questionId = $question->id;
                // Retrieve the saved question to obtain the correct question_id
                // $savedQuestion = QuizQuestion::latest()->limit(1)->first();
                
                // $questionId = $savedQuestion->id;
               
                $choice = new QuizChoices();
                $choice->quiz_question_id  = $questionId; // Assign the question_id foreign key
                $choice->option_a = $questionData['option_a'];
                $choice->option_b = $questionData['option_b'];
                $choice->option_c = $questionData['option_c'];
                $choice->option_d = $questionData['correct_answer'];
                $choice->save();
                
            }
        }

        return redirect()->route('quiz.show')->with('success', 'Successfully Added New Quiz');
    }

    public function delete($id)
    {
        $quiz = Quiz::findOrFail($id);

        $quizQuestions = $quiz->question;
        
        foreach ($quizQuestions as $question) {
            // Delete the related QuizChoices manually
            $question->choices()->delete(); // Assuming 'choices' is the relationship method in QuizQuestion model
    
            // Delete the QuizQuestion
            $question->delete();
        }

        $quiz->delete();

        return redirect()->back()->with('success', 'Successfully Deleted');
    }

    public function editQuiz($id)
    {
        $quizToEdit = Quiz::with(['question.choices', 'subject'])->findOrFail($id);
        $strands = Subject::all();
        
        return inertia('AdminDashboard/AdminPages/ExaminationManagement/QuizManagement/Admin/QuizEdit',[
            'quizToEdit'    => $quizToEdit,
            'strands'       => $strands,
        ]);
    }

    public function update(Request $request)
    {
        dd($request);
    }
}
