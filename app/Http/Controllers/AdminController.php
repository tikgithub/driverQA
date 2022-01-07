<?php

namespace App\Http\Controllers;

use App\Models\questions;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view('admin.home');
    }

    /**
     * Function Calling QuestionController
     * And reading all question from DB
     */
    public function questionPage(){

        $questionList = questions::paginate(10);

        return view('admin.question.index')->with('questions',$questionList);
    
    }
}
