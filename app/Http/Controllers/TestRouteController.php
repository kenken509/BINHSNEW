<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\SentQuiz;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\StudentActiveQuiz;
use App\Models\StudentQuizResult;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class TestRouteController extends Controller
{
    public function showTestRoute(){
         
        return view('testViews/OtpMail');
    }

    public function showTakeQuiz()
    {
        $quizzes = SentQuiz::with(['quiz','section'])->latest()->get();

        return inertia('Index/TestPages/TakeQuizAll',[
            'quizzes' => $quizzes,
        ]);
    }

    public function showActiveQuiz()
    {
        $userId = Auth::user()->id;
       

        $activeQuizzes = StudentActiveQuiz::where('student_id', '=', $userId)
                            ->where('status', '=', 'pending')
                            ->with(['quiz' => function ($query) {
                                $query->with(['question' => function  ($query) {
                                    $query->with('choices')->inRandomOrder();
                                }]);
                            }])
                            ->latest()->get();

        
        // $quizzes = SentQuiz::with(['quiz','section'])->latest()->get();
        // $currentUser = User::with('section')->where('id', '=', $userId)->first();
        // $userSection = $currentUser['section']['id'];
        
        // $currentDate = Carbon::now(); // Get the current date
        // $studentFinishedQuizzes = StudentQuizResult::all();

        // $quizzes = SentQuiz::with(['quiz' => function ($query) {
        //     $query->with(['question' => function ($query) {
        //         $query->inRandomOrder();
        //     }]);
        // }, 'section'])->whereDate('end_date', '>=', $currentDate)->where('section_id', '=', $userSection)->latest()->get();
        
        return inertia('Index/TestPages/StudentActiveQuiz',[
            'quizzes'   => $activeQuizzes,
        ]);
    }

    public function showBeginQuiz($activeId, $qId)
    {
        
        $quiz = Quiz::with(['question' => function ($query) {
            $query->with('choices')->inRandomOrder();
        }])->where('id', '=', $qId)->first();

        
        // Paginate the questions.
        

        return inertia('Index/TestPages/StudentTakeQuiz', [
            'quiz' => $quiz,
            'studentActiveQuizId' => $activeId,
        ]);
    }

    public function submitQuizResult(Request $request)
    {
        //{"studentId":8,"quizId":2,"gradingPeriod":"1st","studentScore":1,"quizGrade":"33.33","status":"done"}
        
        $studentQuiz = StudentActiveQuiz::findOrFail($request->studentActiveQuizId);

        $studentQuiz->quiz_score        = $request->studentScore;
        $studentQuiz->quiz_grade        = $request->quizGrade;
        $studentQuiz->status            = 'done';
        $studentQuiz->save();


        
        return redirect()->route('quiz.result')->with('success', 'Quiz Submitted Successfully!');
    }

    public function showQuizResults()
    {
        
        $loggedUser = Auth::user()->id;
        $studentQuizzes = StudentActiveQuiz::with(['quiz' => function ($query){
                            $query->with('question');
                        }])
                        ->where('student_id', '=', $loggedUser)
                        ->where(function ($query){
                            $query->where('status','=','done') 
                            ->orWhere('status', '=', 'lapse');
                        })
                        ->latest()
                        ->get();
       // dd($studentQuizzes);
        return inertia('Index/TestPages/StudentQuizResult',[
            'quizResults' => $studentQuizzes,
        ]);
    }

    // chunkt uploading test
    public function chunkUploadShow()
    {
        return inertia('Index/TestPages/ChunkUpload');

    }

    public function storeChunk(Request $request)
    {
        $chunk = $request->getContent();
        $totalChunks = $request->input('totalChunks');
        $currentChunk = $request->input('currentChunk');
        $originalFilename = $request->input('originalFilename');
    
        $tempDir = storage_path('app/temp');
        $chunkFileName = "chunk_{$currentChunk}_{$originalFilename}.tmp";
    
        // Ensure the temporary directory exists (no effect if it already exists)
        File::makeDirectory($tempDir, 0755, true, true);
    
        // Save the chunk to the temporary directory
        file_put_contents("$tempDir/$chunkFileName", $chunk);
    
        // Check if all chunks have been uploaded
        $uploadedChunks = count(glob("$tempDir/chunk_*_$originalFilename.tmp"));
    
        // Log the number of uploaded chunks and their filenames
        $chunkFilenames = glob("$tempDir/chunk_*_$originalFilename.tmp");
        Log::info("Number of uploaded chunks: $uploadedChunks");
        Log::info("Chunk filenames: " . implode(', ', $chunkFilenames));
    
        // Check if all chunks have been uploaded
        if ($uploadedChunks == $totalChunks) {
            // All chunks have been uploaded, call the function to reassemble the file
            $this->reassembleFile($totalChunks, $originalFilename);
    
            return response()->json(['success' => 'Successfully uploaded the file!!!!']);
        }
    
        return response()->json(['message' => 'Chunk uploaded successfully']);
    }

    // ...

// ...

public function reassembleFile($totalChunks, $originalFilename)
{
    $tempDir = storage_path('app/temp');
    $outputDir = storage_path('app/public/uploads');

    // Create the output directory if it doesn't exist
    if (!file_exists($outputDir)) {
        File::makeDirectory($outputDir, 0755, true, true);
    }

    $outputFilePath = "$outputDir/$originalFilename";

    // Open the output file for writing
    $outputFile = fopen($outputFilePath, 'wb');

    // Retrieve all chunk filenames
    $chunkFiles = glob("$tempDir/chunk_*_$originalFilename.tmp");

    // Sort the chunk filenames based on the chunk number
    natsort($chunkFiles);

    foreach ($chunkFiles as $chunkFile) {
        // Open the chunk file for reading
        $chunkContent = file_get_contents($chunkFile);

        // Write the chunk content to the output file
        fwrite($outputFile, $chunkContent);

        // Optionally, you can delete the individual chunk after processing
        unlink($chunkFile);
    }

    // Close the output file
    fclose($outputFile);
}


// ...


// ...


    private function cleanupChunks($tempDir, $originalFilename)
    {
        $files = glob("$tempDir/chunk_*_{$originalFilename}.tmp");
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }








    public function chunkUploadShow2()
    {
        return inertia('Index/TestPages/ChunkUploadTest2');
    }

    public function chunkUploadStore2(Request $request)
    {
        $file = $request->file('file');

        $path = Storage::disk('local')->path("chunks/{$file->getClientOriginalName()}");

        File::append($path, $file->get());

        if ($request->has('is_last') && $request->boolean('is_last')) {
            $name = basename($path, '.part');

            File::move($path, "/path/to/public/someid/{$name}");
        }


        return response()->json(['uploaded' => true]);
    }

    public function showEmailTemplate()
    {
        return view('mails/ResetPasswordMail');
    }

    public function testData()
    {
        $sampleId = '123';
        $randomString = Str::random(20);

        $randomNumber = rand(1, 20);

        // Ensure the random number is within a valid range
        $randomNumber = max(1, min($randomNumber, strlen($randomString)));

        // Insert the sampleId at the specified position
        $modifiedString = substr($randomString, 0, $randomNumber - 1) . $sampleId . substr($randomString, $randomNumber - 1);

        // Output the modified string
        //dd('test here: ' . $modifiedString);
        $this->extractSampleId($modifiedString,$sampleId);
    }

    public function extractSampleId($modifiedString, $sampleId)
    {
        $randomNumber = rand(1, 20);

        // Ensure the random number is within a valid range
        $randomNumber = max(1, min($randomNumber, strlen($modifiedString)));

        // Extract the sampleId from the modified string
        $sampleId = substr($modifiedString, $randomNumber - 1, strlen($sampleId));

        // Output the extracted sampleId
        dd('Extracted sampleId: ' . $sampleId);
    }
}
