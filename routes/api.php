<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestRouteController;
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

// Route::controller(SimulatorAuthController::class)->group(function(){
//     Route::match(['get', 'post'], '/simulator/login', 'simLogin')->name('simulator.login');
//     //Route::post('/simulator/login','simLogin')->name('simulator.login');
//     Route::get('/simulator/active-quizzes/{id}','getActiveQuiz')->name('simulator.getActiveQuiz');
//     Route::match(['get', 'post'], '/simulator/active-quiz/submit-grade', 'activeQuizGrade')->name('simulator.activeQuizGrade');
// });

// Route::controller(AuthController::class)->group(function(){
//     Route::post('/simlogin','simulatorAppLogin');
//     Route::post('sim/otp/authenticate',  'simAuthOtp');
//     Route::get('sim/user/otp/resend/{id}', 'simResendOtp');
// });


// current route ***********************
//public route
// Route::post('/simlogin', [AuthController::class, 'simulatorAppLogin'])->name('simulator.login');

//protected route
// Route::group(['middleware' => 'auth:sanctum'], function () {
    
//     Route::get('sim/otp/authenticate',[AuthController::class, 'simAuthOtp'])->name('simulator.getActiveQuiz');
//     Route::get('sim/user/otp/resend/{id}', [AuthController::class, 'simResendOtp'])->name('simulator.activeQuizGrade1');
// });
// current route ***********************


// testing sanctum routes *************************************************************************8
//public route
Route::post('/simlogin', [SimulatorAuthController::class, 'simulatorAppLogin'])->name('simulator.login');
Route::get('/upload/show', [TestRouteController::class, 'chunkUploadShow2'])->name('test.chunkUpload2.show');
Route::post('/upload', [TestRouteController::class, 'chunkUploadStore2'])->name('test.chunkUpload2.store');




//protected route
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('sim/otp/authenticate',[SimulatorAuthController::class, 'simAuthOtp']);
    Route::get('sim/user/otp/resend/{id}', [SimulatorAuthController::class, 'simResendOtp']);
    Route::get('/simulator/active-quizzes/{id}',[SimulatorAuthController::class, 'getActiveQuiz']);
    Route::match(['get', 'post'], '/simulator/active-quiz/submit-grade', [SimulatorAuthController::class, 'activeQuizGrade']);
    Route::post('/sim/logout', [SimulatorAuthController::class, 'simLogout']);
});




