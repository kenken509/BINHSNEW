<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Section;
use App\Models\Subject;
use App\Models\SentQuiz;
use App\Models\QuizChoices;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\StudentActiveQuiz;

class QuizManagementController extends Controller
{
    public function show(){
        $loggedUser = Auth::user()->role;


        if($loggedUser == 'admin')
        {
            return inertia('AdminDashboard/AdminPages/ExaminationManagement/QuizManagement/Admin/QuizAll', [
                'quizzes' => Quiz::with(['question.choices','subject'])->withCount('question')->latest()->get(),
            ]);
        }

        if($loggedUser == 'instructor')
        {
            $insturctorSubject = Auth::user()->subject_id;
            $sentQuiz = SentQuiz::all();

            
            return inertia('AdminDashboard/AdminPages/ExaminationManagement/QuizManagement/Instructor/InstructorQuizAll', [
                'quizzes' => Quiz::where('subject_id', '=', $insturctorSubject)->with(['question.choices','subject'])->withCount('question')->latest()->get(),
                'sections' => Section::all(),
                'sentQuiz'  => $sentQuiz,
            ]);
        }
        

    }

    public function create(){

        $loggedUser = Auth::user()->role;

        if($loggedUser == 'admin')
        {
            return inertia('AdminDashboard/AdminPages/ExaminationManagement/QuizManagement/Admin/QuizAdd',[
                'strands' => Subject::all(),
            ]);
        }

        if($loggedUser == 'instructor')
        {
            return inertia('AdminDashboard/AdminPages/ExaminationManagement/QuizManagement/Instructor/InstructorQuizAdd',[
                'strands' => Subject::all(),
            ]);
        }
       
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
        
        $loggedUser = Auth::user()->role;


        if($loggedUser == 'admin')
        {
            return inertia('AdminDashboard/AdminPages/ExaminationManagement/QuizManagement/Admin/QuizEdit',[
                'quizToEdit'    => $quizToEdit,
                'strands'       => $strands,
            ]);
        }

        if($loggedUser == 'instructor')
        {
            return inertia('AdminDashboard/AdminPages/ExaminationManagement/QuizManagement/Instructor/InstructorQuizEdit',[
                'quizToEdit'    => $quizToEdit,
                'strands'       => $strands,
            ]);
        }
        
    }

    // +request: Symfony\Component\HttpFoundation\ParameterBag {#36 ▼
    //     #parameters: array:5 [▼
    //       "subject_id" => 2
    //       "title" => "Quiz 1"
    //       "grading_period" => "1st"
    //       "duration" => 20
    //       "questions" => array:2 [▼
    //         0 => array:3 [▼
    //           "question" => "What does RAM stands for?"
    //           "correct_answer" => "Random Access Memory"
    //           "choices" => array:3 [▶]
    //         ]
    //         1 => array:3 [▼
    //           "question" => "Who is the current president of the Philippines"
    //           "correct_answer" => "Ferdinan Marcos Jr."
    //           "choices" => array:3 [▶]
    //         ]
    //       ]
    //     ]
    //   }
    public function update(Request $request)
    {
        //dd($request);
        $validate = $request->validate([
            'subject_id' => 'required',
            'title' => 'required',
            'grading_period' => 'required',
            "duration"          => 'required',
            "questions"         => 'required|array|min:1',
        ],[
            'questions'     => 'Must have at least 1 question!'
        ]);

        $quizId = $request->id;
        $quiz = Quiz::with('question.choices')->findOrFail($quizId);

        //try block here <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<,
        if($quiz)
        {
            $quiz->subject_id       = $request['subject_id'];
            $quiz->title            = $request['title'];
            $quiz->grading_period   = $request['grading_period'];
            $quiz->duration         = $request['duration'];
            $quiz->save();

            $deletedQuestion = $request->deleted_question_id;
            if($deletedQuestion)
            {
                foreach ($deletedQuestion as $questId) 
                {
                    if($questId)
                    {
                        $questionToDelete = QuizQuestion::findOrFail($questId);

                        $questionToDelete->choices()->delete(); // Assuming 'choices' is the relationship method in QuizQuestion model
                
                        // Delete the QuizQuestion
                        $questionToDelete->delete();
                    }
                }
            }
            

            $requestQuestion = $request->questions;
            foreach($requestQuestion as $questionData)
            {

                if($questionData['id'])
                {
                    
                    $questionId = $questionData['id'];
                    $question = QuizQuestion::findOrFail($questionId);
                    
                    
                    {
                        $question->question         = $questionData['question'];
                        $question->quiz_id          = $quizId;
                        $question->correct_answer   = $questionData['correct_answer'];
                        $question->save();
    
                        $choices = QuizChoices::where('quiz_question_id', '=', $questionId)->get();
    
                        
                        $choices[0]->quiz_question_id   = $questionId;
                        $choices[0]->option_a           = $questionData['choices']['option_a'];
                        $choices[0]->option_b           = $questionData['choices']['option_b'];
                        $choices[0]->option_c           = $questionData['choices']['option_c'];
                        $choices[0]->option_d           = $questionData['correct_answer'];
                        $choices[0]->save();
                    }
                }
                else
                {
                    
                        $newQuestion = new QuizQuestion(); 
                        $newQuestion->question         = $questionData['question'];
                        $newQuestion->quiz_id          = $quizId;
                        $newQuestion->correct_answer   = $questionData['correct_answer'];
                        $newQuestion->save();

                        $newQuestionId = $newQuestion->id;

                        $newChoices = new QuizChoices();

                        $newChoices->quiz_question_id   = $newQuestionId;
                        $newChoices->option_a           = $questionData['choices']['option_a'];
                        $newChoices->option_b           = $questionData['choices']['option_a'];
                        $newChoices->option_c           = $questionData['choices']['option_a'];
                        $newChoices->option_d           = $questionData['correct_answer'];
                        $newChoices->save();
                }
            }
        }

        return redirect()->route('quiz.show')->with('success', 'Updated Successfully');
    }

    public function sendQuiz(Request $request)
    {
        

        
        $request->validate([
            'section_id' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
        ],[
            'section_id' => 'The section field is required!'
        ]);
        // {"quiz_id":1,"startDate":"2023-09-11T16:00:00.000Z","endDate":"2023-09-19T16:00:00.000Z","subject_id":3,"section_id":5}
        $sectionStudents = User::where('role','=','student')->where('section_id','=',$request->section_id)->get();
        $thisQuiz = Quiz::find($request->quiz_id);
        

        $activeQuiz                 = new SentQuiz();
        $activeQuiz->quiz_id        = $request->quiz_id;
        $activeQuiz->section_id     = $request->section_id;
        $activeQuiz->subject_id     = $request->subject_id;
        $activeQuiz->start_date     = Carbon::parse($request->startDate)->toDateString();
        $activeQuiz->end_date       = Carbon::parse($request->endDate)->toDateString();
        $activeQuiz->created_by     = Auth::user()->id;
        $activeQuiz->save();

        

        foreach($sectionStudents as $student)
        {
            $studentQuiz = new StudentActiveQuiz();

            $studentQuiz->sent_quizzes_id   = $activeQuiz->id;
            $studentQuiz->student_id        = $student->id;
            $studentQuiz->quiz_id           = $request->quiz_id;
            $studentQuiz->grading_period    = $thisQuiz->grading_period;
            $studentQuiz->start_date        = Carbon::parse($request->startDate)->toDateString();
            $studentQuiz->end_date          = Carbon::parse($request->endDate)->toDateString();
            $studentQuiz->save();
        };
        
        return redirect()->route('quiz.active')->with('success', 'Successfully sent new quiz!');
        
    }


    public function showActiveQuiz()
    {
        $currentDate = Carbon::now(); // Get the current date

        $quizzes = SentQuiz::with(['quiz' => function ($query) {
            $query->with(['question' => function ($query) {
                $query->inRandomOrder();
            }]);
        }, 'section'])->whereDate('end_date', '>=', $currentDate)->latest()->get();
        
        return inertia('AdminDashboard/AdminPages/ExaminationManagement/QuizManagement/Instructor/InstructorActiveQuizzesAll',[
            'quizzes' => $quizzes,
        ]);
    }

    public function showPastDueQuiz()
    {
        $currentDate = Carbon::now(); // Get the current date

        $quizzes = SentQuiz::with(['quiz' => function ($query) {
            $query->with(['question' => function ($query) {
                $query->inRandomOrder();
            }]);
        }, 'section'])->whereDate('end_date', '<', $currentDate)->latest()->get();
        
        return inertia('AdminDashboard/AdminPages/ExaminationManagement/QuizManagement/Instructor/InstructorPastDueQuizzesAll',[
            'quizzes' => $quizzes,
        ]);
    }
    

    
}
