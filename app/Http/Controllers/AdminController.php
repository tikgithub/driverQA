<?php

namespace App\Http\Controllers;

use App\Models\appsetting;
use App\Models\questions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }

    /**
     * Function Calling QuestionController
     * And reading all question from DB
     */
    public function questionPage()
    {

        $questionList = questions::paginate(10);

        return view('admin.question.index')->with('questions', $questionList);
    }

    /**
     * Function Calling AppSettingController
     * Reading all setting from DB
     */

     public function appSettingPage(){
         //Get first row of select result
         $settings = DB::table('appsettings')->first();

         return view('admin.testsetting.index')->with('settings',$settings);
     }
}
