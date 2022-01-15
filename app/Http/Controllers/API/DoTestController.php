<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AnswerPaper;
use App\Models\QuestionPaper;
use App\Models\registerTest;
use Illuminate\Http\Request;

class DoTestController extends Controller
{
    /**
     * Function API for response question base by ticket
     */
    public function getPaperTest(){
        //Get ticket ID
        
        $ticket_id = session(['ticket']);
        dd($ticket_id);
        //$question = QuestionPaper::where('ticket_id','=',$ticket_id)->get();
        return ['ok','ok'];
    }

    public function updateUserTimer(Request $req){
        return response()->json($req->all());
     }

     public function getQuestionDetail($id){
        $answers = AnswerPaper::where('paper_id','=',$id)->get();
        return response()->json(["question"=>QuestionPaper::find($id),'Answers'=>$answers]);
    }

    /** Function to select answer and save to db */
    public function selectAnswer($question_id, $answer_id){
        $questPaper = QuestionPaper::find($question_id);
        $questPaper->answer_selected = $answer_id;
        if($questPaper->save()){
            return response(200);
        }else{
            return response(500);
        }
    }

    /** 
     * Function to submit the test if user finish
     */
    public function submitExam(){
        $ticket_id = session('ticket');
        $regisTest = registerTest::find($ticket_id);
        $regisTest->testing_timespan = 0;
        $regisTest->save();
        return redirect()->route('showTestResult');

    }

    /** Function to display testing result of user */
    public function showTestResult(){
        $ticket_id = session('ticket');
        dd($ticket_id);
    }

}
