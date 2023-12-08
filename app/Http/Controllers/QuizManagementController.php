<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Section;
use App\Models\Subject;
use App\Models\SentQuiz;
use App\Models\SchoolYear;
use App\Models\QuizChoices;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\StudentNewQuizMail;
use App\Models\StudentActiveQuiz;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Rules\StartDateBeforeEndDate;
use Illuminate\Validation\ValidationException;

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
            $instructor = Auth::user()->id;
            $sentQuiz = SentQuiz::all();

            $user = Auth::user();
            $sections = $user->instructorSections;

            //dd($sections);
            
           

            return inertia('AdminDashboard/AdminPages/ExaminationManagement/QuizManagement/Instructor/InstructorQuizAll', [
                'quizzes' => Quiz::where('subject_id', '=', $insturctorSubject)
                                ->where('created_by',$instructor)
                                ->with(['question.choices','subject','sentQuiz'])
                                ->withCount('question')->latest()->get(),
                'instructorSections' => $sections,
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
        $currentSchoolYear = SchoolYear::first();

        $currentSchoolYear = $currentSchoolYear->year;
        

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
            $quiz->school_year      = $currentSchoolYear;
            $quiz->duration         = $request->duration;
            $quiz->created_by       = Auth::user()->id;
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
                $choice->option_d = $questionData['option_d'];
                $choice->save();
                
            }
        }

        return redirect()->route('quiz.show')->with('success', 'Successfully Added New Quiz');
    }

    public function delete($id)
    {
        try{

            DB::beginTransaction();

            $quiz = Quiz::findOrFail($id);

            $quizQuestions = $quiz->question;
            
            foreach ($quizQuestions as $question) {
                // Delete the related QuizChoices manually
                $question->choices()->delete(); // Assuming 'choices' is the relationship method in QuizQuestion model
        
                // Delete the QuizQuestion
                $question->delete();
            }

            $quiz->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Successfully Deleted');
        
        }catch(\Exception $e)
        {
            
            DB::rollBack();

            return redirect()->back()->with('error', 'Quiz distributed: Deletion not allowed!.');
        }
        

        
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

   
    public function update(Request $request)
    {
        
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
            $quiz->updated_by       = Auth::user()->id;
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
                        $choices[0]->option_d           = $questionData['choices']['option_d'];
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
                        $newChoices->option_b           = $questionData['choices']['option_b'];
                        $newChoices->option_c           = $questionData['choices']['option_c'];
                        $newChoices->option_d           = $questionData['choices']['option_d'];
                        $newChoices->save();
                }
            }
        }

        return redirect()->route('quiz.show')->with('success', 'Updated Successfully');
    }

    public function sendQuiz(Request $request)
    {
        
        if(($request->startDate > $request->endDate))
        {
            throw ValidationException::withMessages([
                'startDate' => 'Start date should not come before end date!',
            ]);
        }
        
        if(Carbon::parse($request->startDate) < now()->startOfDay())
        {
            throw ValidationException::withMessages([
                'startDate' => 'Start Date should be at least today!',
            ]);
        }

        $request->validate([
            'section_id' => 'required',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:start_date',
        ],[
            'section_id' => 'The section field is required!'
        ]);
        
        $schoolYear = SchoolYear::first();
        $currentSchoolYear = $schoolYear->year;

        
        $sectionStudents = User::where('role','=','student')
                            ->where('section_id','=',$request->section_id)
                            ->where('school_year','=', $currentSchoolYear)
                            ->get();
         
        
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
            $studentQuiz->section_id        = $request->section_id;
            $studentQuiz->grading_period    = $thisQuiz->grading_period;
            $studentQuiz->start_date        = Carbon::parse($request->startDate)->toDateString();
            $studentQuiz->end_date          = Carbon::parse($request->endDate)->toDateString();
            $studentQuiz->sent_by           = Auth::user()->id;
            $studentQuiz->save();
            
            $filteredEmails = ['admin@gmail.com', 'afaInstructor@gmail.com', 'heInstructor@gmail.com', 'ictInstructor@gmail.com', 'iaInstructor@gmail.com', 'afaStudent@gmail.com', 'heStudent@gmail.com', 'ictStudent@gmail.com', 'ictStudent2@gmail.com', 'ictStudent5@gmail.com', 'ictStudent6@gmail.com', 'ictStudent3@gmail.com', 'ictStudent4@gmail.com', 'iaStudent@gmail.com', 'ictStudent7@gmail.com', 'ictStudent9@gmail.com', 'ictStudent10@gmail.com', 'ictStudent11@gmail.com', 'heStudent2@gmail.com', 'heStudent3@gmail.com',];

            $mailData = [
                'userName'      => $student->fName,
                'instructor'    => Auth::user()->fName,
                'start'         => Carbon::parse($request->startDate)->format('F j, Y'),
                'end'           => Carbon::parse($request->endDate)->format('F j, Y'),
            ];

            if (in_array($student->email, $filteredEmails)) {
                // Use Mailtrap SMTP configuration
                config([
                    'mail.driver' => 'smtp',
                    'mail.host' => env('MAILTRAP_HOST'),
                    'mail.port' => env('MAILTRAP_PORT'),
                    'mail.username' => env('MAILTRAP_USERNAME'),
                    'mail.password' => env('MAILTRAP_PASSWORD'),
                    'mail.encryption' => env('MAILTRAP_ENCRYPTION'),
                ]);
            }

            Mail::to($student->email)->send(new StudentNewQuizMail($mailData));
            // send email notification for student
        };
        
        return redirect()->route('quiz.active')->with('success', 'Successfully sent new quiz!');
        
    }


    public function showActiveQuiz()
    {
        $currentDate = Carbon::now(); // Get the current date

        $quizzes = SentQuiz::with(['quiz' => function ($query) {
            $query->with(['question' => function ($query) {
                $query->with('choices')->inRandomOrder();
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
    
    public function deleteSentQuiz($id)
    {
        
        $quiz = SentQuiz::findOrFail($id);

        $quiz->delete();

        return redirect()->route('quiz.active')->with('success', 'Successfully deleted sent quiz!');
    }

    public function showUpdateSentQuiz($id)
    {
        $sentQuiz = SentQuiz::findOrFail($id);
        
        


    }

    public function showQuizResults(Request $request)
    {
        $filters = $request->sectionId;

        $instructorId = Auth::user()->id;
        
        $studentResults = StudentActiveQuiz::with(['student' => function($query){
            $query->with('section');
        },'quiz' => function($query){
            $query->with('question');
        }])
        ->where('status','!=','pending')
        ->where('sent_by', $instructorId)
        ->latest();
        
        

        $instructorHandledSection = User::with('instructorSections')->find($instructorId);
        
        return inertia('AdminDashboard/AdminPages/ExaminationManagement/QuizManagement/Instructor/InstructorQuizResult',[
            'studentResults' => $studentResults->filteredData($filters)->paginate(10),
            'instructorHandledSection' => $instructorHandledSection,
        ]);
    }
    
}
