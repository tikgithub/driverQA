<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AnswerPaper;
use App\Models\QuestionPaper;
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

    public function selectAnswer($question_id, $answer_id){
        $questPaper = QuestionPaper::find($question_id);
        $questPaper->answer_selected = $answer_id;
        if($questPaper->save()){
            return response(200);
        }else{
            return response(500);
        }
    }
}
