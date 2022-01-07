<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\WorkerController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});
/** Route to call starter input page */
Route::get('/starter',[WorkerController::class,'starterPage'])->name('starterPage');
/** Route to validate the starter submit */
Route::post('/starter',[WorkerController::class,'validateStarter'])->name('validateStater');
/** Login Page Route */
Route::get('/login',[LoginController::class,'index'])->name('getLogin');
/** Validate User Login */
Route::post('/login',[LoginController::class,'validateUser'])->name('postLogin');

/**
 * Protect Route for Admin Role
 */
Route::group(['prefix'=>'admin', 'middleware'=>'authAdmin'],function(){
    Route::get('/home',[AdminController::class,'index'])->name('admin_home');
    Route::get('/logout',[LoginController::class,'logout'])->name('admin_Logout');
    /** Question Controller */
    Route::get('/question',[AdminController::class,'questionPage'])->name('questionIndex');
    Route::post('/question',[QuestionController::class,'store'])->name('questionStore');
    Route::get('/question/{id}',[QuestionController::class,'edit'])->name('questionEdit');
});