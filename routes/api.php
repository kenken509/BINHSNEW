<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SimulatorAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::controller(SimulatorAuthController::class)->group(function(){
//     Route::match(['get', 'post'], '/simulator/active-quiz/submit-grade1', 'activeQuizGrade')->name('simulator.activeQuizGrade1');
// });

// Route::group(['middleware' => 'auth:sanctum'], function () {
//     Route::match(['get', 'post'], '/simulator/login', [SimulatorAuthController::class, 'simLogin'])->name('simulator.login');
//     Route::get('/simulator/active-quizzes/{id}',[SimulatorAuthController::class, 'getActiveQuiz'])->name('simulator.getActiveQuiz');
//     Route::match(['get', 'post'], '/simulator/active-quiz/submit-grade1', [SimulatorAuthController::class, 'activeQuizGrade'])->name('simulator.activeQuizGrade1');
// });

Route::controller(SimulatorAuthController::class)->group(function(){
    Route::match(['get', 'post'], '/simulator/login', 'simLogin')->name('simulator.login');
    //Route::post('/simulator/login','simLogin')->name('simulator.login');
    Route::get('/simulator/active-quizzes/{id}','getActiveQuiz')->name('simulator.getActiveQuiz');
    Route::match(['get', 'post'], '/simulator/active-quiz/submit-grade', 'activeQuizGrade')->name('simulator.activeQuizGrade');
});


Route::post('/simlogin', [AuthController::class, 'simulatorAppLogin']);

Route::post('sim/otp/authenticate', [AuthController::class, 'simAuthOtp'] );

Route::get('sim/user/otp/resend/{id}', [AuthController::class, 'simResendOtp']);