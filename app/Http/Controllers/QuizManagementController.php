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
            'questions'     => 'Please add at least 1 question!'
        ]);

        if($validate){
           
            $quiz                   = new Quiz();
            $quiz->subject_id       = $request->subject_id;
            $quiz->title            = $request->title;
            $quiz->grading_period   = $request->grading_period;
            $quiz->duration         = $request->duration;
            $quiz->save();

            $latestQuiz = Quiz::latest()->get();
            $quizId = $latestQuiz->id;

            foreach ($questionsArray as $questionData) {
                $question = new QuizQuestion();
                $question->question = $questionData->question;
                $question->quiz_id = $quizId;
                $question->correct_answer = $questionData->correct_answer;
                $question->save();
            
                // Retrieve the saved question to obtain the correct question_id
                $savedQuestion = Question::latest()->first();
                $questionId = $savedQuestion->id;
               
                $choice = new QuizChoices();
                $choice->question_id = $questionId; // Assign the question_id foreign key
                $choice->choice_text = $choiceData['choice_text'];
                $choice->save();
                
            }
            // 'question'      :null,
            // 'correct_answer':null,
            // 'option_a'      :null,
            // 'option_b'      :null,
            // 'option_c'      :null,
        }
        // foreach($questionsArray as $question){
            
        //     $data = new QuizQuestion();

        //     $data->question = $question['question'];
        //     $data->quiz_id  = 1;
        //     $data->correct_answer = $question['correct_answer'];
           
        //     $data->save();
        // }
    }
}
