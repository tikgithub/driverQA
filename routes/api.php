<?php

use App\Http\Controllers\API\DoTestController;
use App\Http\Controllers\PerformTestController;
use App\Http\Controllers\WorkerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//Function to update timer
Route::post('/update_user_timer',[PerformTestController::class,'updateUserTimer'])->middleware('apiAuth');
//Get question and answer by each question id on paper question
Route::get('/getquestion/{id}',[DoTestController::class,'getQuestionDetail'])->middleware('apiAuth');
//Route to update the answer to question
Route::get('/answer_question/{question_id}/{answer_id}',[DoTestController::class,'selectAnswer'])->name('answerQuestion')->middleware('apiAuth');
Route::get('/testJson',[WorkerController::class,'testJson']);
