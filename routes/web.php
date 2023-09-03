<?php
namespace App\Http\Controllers;


use App\Mail\FirstMail;
use Illuminate\Http\Request;
use App\Mail\OtpVerification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\StrandsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\TestRouteController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//****************************************************************************** */


//API for unity
Route::controller(ApiRequestController::class)->group(function(){
    Route::get('/api-request/users', 'showUsers')->name('api-request.users');
});


Route::get('/email/verify', function(){
   $isVerified = Auth::user()->email_verified_at;

   if($isVerified){
     return redirect()->route('index');
   }
    return inertia('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');


 //verification mail handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect()->route('index',)->with('success', 'Email was verified');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) { // import this: use Illuminate\Http\Request;
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send'); // 'throttle:attemptTime,minutes'
//mail


//************************************************************************** */
// Route::get('/send-mail', function(){
//     Mail::to('testing@example.com')->send(new FirstMail());
    
// });

//Auth::routes(['verify' => true]);

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/show', [IndexController::class, 'show']);

Route::controller(IndexController::class)->group(function(){
    
    Route::get('/about', 'showAbout')->name('index.about');
    Route::get('/contact', 'showContact')->name('index.contact');
    Route::get('/downloads', 'showDownloads')->name('index.downloads');
    Route::get('/news', 'showNews')->name('index.news');

    Route::get('full-post/view/{page}/{id}', 'showFullPost')->name('fullPost.show');
    Route::post('carousel/replace-image', 'carouselReplaceImageStore')->name('carousel.replace.image');
});



Route::controller(AuthController::class)->group(function(){
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store')->name('login.store');
    Route::delete('/logout', 'destroy')->name('logout');
    Route::get('/guest-registration', 'showRegistration')->name('register.guest');
    Route::post('/guest-register', 'storeGuest')->name('register.guestStore');
    Route::get('/change-password', 'showChangePassword')->name('change.password');
    Route::post('/change-password/store', 'changePassword')->name('reset.password');
    Route::get('/forgot-password', 'showForgotPassword')->name('forgot.password');

    Route::get('user/otp/verify/{id}', 'showOtpVerification')->name('otpVerification.show');
    Route::post('user/otp/authenticate', 'authOtp')->name('otp.auth');
    Route::get('user/otp/resend/{id}', 'resendOtp')->name('otp.resend');
    
});


Route::controller(MailController::class)->group(function(){
    Route::get('/verify-email', 'showVerify')->name('verify.show');
    Route::get('/verify-email-sent', 'showVerificationSent')->name('verificationSent.show');
    Route::get('/send-mail/{id}', 'sendMail')->name('mail.verify');
    Route::get('/confirmed-email/{id}', 'confirmEmail')->name('mail.confirmed');
});

Route::controller(UserAccountController::class)->group(function(){
    Route::get('/register', 'create')->name('register');
    Route::post('/store', 'store')->name('register.store');
});

Route::controller(AdminDashboardController::class)->middleware('isAdmin')->group(function(){
    Route::get('/admin/panel', 'showAdminPanel')->name('admin.showAdminPanel');
});

Route::controller(StrandsController::class)->middleware('auth','verified')->group(function(){
    Route::get('/track/he', 'showHE')->name('strand.showHE');
    Route::get('/track/ict', 'showICT')->name('strand.showICT');
    Route::get('/track/ia', 'showIA')->name('strand.showIA');
    Route::get('/track/agri-fishery', 'showAgriFisheryArts')->name('strand.showAgriFisheryArts');
    
});

Route::controller(UserManagementController::class)->middleware(['auth','verified','isAdmin'])->group(function(){
    Route::match(['get','post'],'/admin/panel/users-all', 'showAllUsers')->name('admin.showAllUsers');
    Route::get('/admin/panel/user-add', 'showAddUser')->name('admin.addUser');
    Route::get('/admin/panel/user-approval', 'showApproveUser')->name('admin.approveUser.show');
    Route::get('/admin/panel/user-approve/{id}', 'ApproveUser')->name('admin.aprprovedUser.approve');
    Route::delete('/admin/panel/user-approve/{id}', 'rejectUser')->name('admin.aprprovedUser.reject');
    Route::get('/admin/panel/user-edit/{id}', 'showEditUser')->name('admin.editUser');
    Route::delete('/admin/panel/user-delete/{user}', 'userDelete')->name('admin.userDelete');
    Route::post('/admin/panel/user-store', 'userStore')->name('admin.userStore');
    Route::post('/admin/panel/user-update','userUpdate')->name('admin.userUpdate');
});

Route::controller(UserProfileController::class)->middleware(['auth','verified'])->group(function(){
    Route::get('/account/profile/edit/{id}', 'showEditProfile')->name('user.profile.edit');
    Route::post('/account/profile/image-update/', 'userProfileImageUpdate')->name('user.profile.image.update');
    Route::post('/account/profile/account-info-update/', 'userProfileInfoUpdate')->name('user.profile.info.update');
});

Route::controller(QuestionsController::class)->middleware(['auth','verified','isAdmin'])->group(function(){
    Route::get('admin/panel/exam-management/question-all', 'questionsShow' )->name('question.all');
    Route::delete('/admin/panel/question-delete/{question}', 'delete')->name('question.delete');
    Route::get('/admin/panel/question-add', 'create')->name('question.add');
    Route::post('/admin/panel/question-store', 'store')->name('question.store');
    Route::get('/admin/panel/question-edit/{id}', 'edit')->name('question.edit');
    Route::post('/admin/panel/question-update', 'update')->name('question.update');
});

Route::controller(ExaminationManagementSystem::class)->middleware(['auth', 'verified','isAdmin'])->group(function(){
    Route::get('student-examination/home', 'showExamSystem')->name('studentExamination.show');
});


Route::controller(QuizManagementController::class)->middleware(['auth','verified','isAdmin'])->group(function(){
    Route::get('admin/panel/quiz/show', 'show')->name('quiz.show');
    Route::get('admin/panel/quiz/add', 'create')->name('quiz.add');
    Route::post('admin/panel/quiz/store', 'store')->name('quiz.store');
    Route::delete('admin/panel/quiz/delete/{id}', 'delete')->name('quiz.delete');
    Route::get('admin/panel/quiz/edit/{id}', 'editQuiz')->name('quiz.edit');
    Route::post('admin/panel/quiz/update', 'update')->name('quiz.update');
    Route::post('admin/panel/quiz/send', 'sendQuiz')->name('quiz.send');

    Route::get('admin/panel/quiz/active', 'showActiveQuiz')->name('quiz.active');
    Route::get('admin/panel/quiz/past-due', 'showPastDueQuiz')->name('quiz.pastDue');
});

Route::controller(SectionController::class)->middleware(['auth','verified','isAdmin'])->group(function(){
    Route::get('admin/panel/section/show', 'show')->name('section.show');
    Route::get('admin/panel/section/section-add', 'create')->name('section.add');
    Route::post('admin/panel/section/section-store', 'store')->name('section.store');
    Route::delete('admin/panel/section/section-delete/{section}', 'delete')->name('section.delete');
    Route::get('admin/panel/section/section-edit/{id}', 'edit')->name('section.edit');
    Route::post('admin/panel/section/section-update', 'update')->name('section.update');
});


Route::controller(SimulatorAuthController::class)->group(function(){
    Route::post('/simulator/login','simLogin')->name('simulator.login');
    Route::get('/simulator/test-api','handlePostRequest')->name('simulator.login');
});

//website controller *********************************************************8
Route::controller(WebContentsController::class)->group(function(){
   Route::get('admin/web-content/display', 'show')->name('webPosts.all');
   
   Route::delete('admin/web-content/delete-post/{id}', 'delete')->name('webPost.delete');
   //instructor
   Route::get('instructor/web-content/add-post', 'showInstructorAddPost')->name('instructorWebPost.add');
   Route::post('instructor/web-content/store-post', 'instructorStorePost')->name('instructorWebPost.store');
   Route::get('instructor/web-content/edit-post/{id}', 'showInstructorEditPost')->name('instructorWebPost.edit');
   Route::post('instructor/web-content/update', 'updatePost')->name('instructorWebPost.update');

   
});

Route::controller(CommentsController::class)->group(function(){
    Route::post('admin/comment/approve', 'approveComment')->name('comment.approve');
    
});

//attachments
Route::controller(AttachmentController::class)->group(function(){
    //image update
    Route::delete('instructor/attachments/delete-attachment/{id}', 'delete')->name('attachment.delete');
    Route::post('instructor/attachments/update-image', 'updateImage')->name('attachment.image.update');
    Route::post('instructor/attachments/update-add-image', 'updateAddNewImage')->name('attachment.addNewImage.update');

    //video update
    Route::post('instructor/attachments/update-video', 'updateVideo')->name('attachment.video.update');
});

Route::controller(AdminPostController::class)->group(function(){
    Route::get('admin/post/all-post', 'showAllPost')->name('admin.post.all');
    Route::get('admin/web-content/add-post', 'showAddPost')->name('webPost.add');
    Route::post('admin/web-content/store-post', 'storePost')->name('webPost.store');
    Route::delete('admin/web-content/about-post/delete/{id}', 'aboutPostDelete')->name('aboutPost.delete');
    Route::delete('admin/web-content/contact-post/delete/{id}', 'contactPostDelete')->name('contactPost.delete');
    Route::delete('admin/web-content/news-post/delete/{id}', 'newsPostDelete')->name('newsPost.delete');
    Route::delete('admin/web-content/downloads-post/delete/{id}', 'downloadsPostDelete')->name('downloadsPost.delete');

    //update routes
    Route::get('admin/edit-post/{id}/{page}', 'showEditPost')->name('editPost.show');
    Route::post('admin/edit-post/about/store', 'storeEditPost')->name('editAboutPost.store');
});

// test route for email
Route::get('/send-otp', function(){
    $mailData = [
        'name' => "test data",
        'dob'   => '12/12/22'
    ];

    Mail::to('helloworld@example.com')->send(new OtpVerification($mailData));
    
    dd('email sent successfully ');

});

Route::controller(TestRouteController::class)->group(function(){
    Route::get('test/route/controller', 'showTestRoute')->name('test.show');
    Route::get('test/route/take-quiz', 'showTakeQuiz')->name('test.quiz');
    Route::get('test/quiz/active', 'showActiveQuiz')->name('quiz.active.show');
    Route::get('test/quiz/begin/{id}', 'showBeginQuiz')->name('quiz.begin');
});


