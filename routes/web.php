<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\API\DoTestController;
use App\Http\Controllers\AppSettingController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PerformTestController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\WorkerController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    Session::forget('ticket');
    Session::flush();
    return view('welcome');
})->name('welcome');
/** Route to call starter input page */
Route::get('/starter',[WorkerController::class,'starterPage'])->name('starterPage');
/** Route to validate the starter submit */
Route::post('/starter',[WorkerController::class,'validateStarter'])->name('validateStater');
/** Login Page Route */
Route::get('/login',[LoginController::class,'index'])->name('getLogin');
/** Validate User Login */
Route::post('/login',[LoginController::class,'validateUser'])->name('postLogin');
/** Show csrf_token() */
Route::get('/gettoken',[WorkerController::class,'showToken']);
/**
 * Protect Route for Admin Role
 */
Route::group(['prefix'=>'admin', 'middleware'=>['authAdmin','web']],function(){

    Route::get('/home',[AdminController::class,'index'])->name('admin_home');
    Route::get('/logout',[LoginController::class,'logout'])->name('admin_Logout');
    /** Question Controller */
    Route::get('/question',[AdminController::class,'questionPage'])->name('questionIndex');
    Route::post('/question',[QuestionController::class,'store'])->name('questionStore');
    Route::get('/question/edit/{id}',[QuestionController::class,'edit'])->name('questionEdit');
    Route::post('/question/edit',[QuestionController::class,'update'])->name('questionUpdate');
    Route::post('/choice',[ChoiceController::class,'store'])->name('storeChoice');
    Route::get('/question/update_correct_answser/{choice_id}/{question_id}',[QuestionController::class,'updateCorrectAnswer'])->name('questionUpdateCorrectAnswer');

    /** Choice Controller */
    Route::get('/choice/edit/{id}/{choice_id}',[ChoiceController::class,'edit'])->name('editChoice');
    Route::post('/choice/update',[ChoiceController::class,'update'])->name('updateChoice');

    /** Test Setting Controller */
    Route::get('/test/setting',[AdminController::class,'appSettingPage'])->name('appSettingPage');
    Route::post('/test',[AppSettingController::class,'update'])->name('appSettingUpdate');
    /** Tester controller */
    Route::get('/tester',[AdminController::class,'showTesterManagerPage'])->name('TesterShow');
    Route::post('/tester/store',[AdminController::class,'storeTester'])->name('TesterStore');
    Route::get('/tester/search',[AdminController::class,'searchTester'])->name('TesterSearch');
    Route::get('/tester/edit/{id}',[AdminController::class,'editTesterInfo'])->name('TesterEdit');
    Route::post('/tester/update',[AdminController::class,'updateTesterInfo'])->name('TesterUpdate');
    /** JSON web */
    Route::get('/api/tester/active/{id}',[AdminController::class,'updateActiveStatusTester']);
    Route::get('/api/tester/deactive/{id}',[AdminController::class,'updateDeActiveStatusTester']);
});

Route::group(['prefix'=>'exam','middleware'=>'sessionAuth'],function(){
    //Route to examing page
    Route::get('/dotest',[WorkerController::class,'doTest'])->name('doTest');
    //Route for api to get session (testing only)
    Route::get('/getsession',[WorkerController::class,'getSession'])->name('getSession');
    //Route for stopping exam or quite exam (Still keep old data in DB)
    Route::get('/stopexamp',[WorkerController::class,'stopExamp'])->name('stopExamp');
    //Finish the exam route
    Route::get('/finish_exam',[DoTestController::class,'submitExam'])->name('submitExam');
    //Route for display testing result
    Route::get('/testing_result',[DoTestController::class,'showTestResult'])->name('showTestResult');
    //Route to reset the user testing result
    Route::post('/reset_exam',[DoTestController::class,'resetTest'])->name('resetExam');
    //Route Validate the tester from reset functino
    Route::get('/validate_tester',[WorkerController::class, 'validateTester'])->name('validateTester');
});

Route::group(['prefix'=>'api','middleware'=>'sessionAuth'],function(){


//Get question and answer by each question id on paper question
Route::get('/getquestion/{id}',[DoTestController::class,'getQuestionDetail']);
//Route to update the answer to question
Route::get('/answer_question/{question_id}/{answer_id}',[DoTestController::class,'selectAnswer'])->name('answerQuestion');
Route::get('/testJson',[WorkerController::class,'testJson']);

});
