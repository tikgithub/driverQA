<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AnswerPaper;
use App\Models\Choice;
use App\Models\QuestionPaper;
use App\Models\questions;
use App\Models\registerTest;
use App\Models\TestType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Question\Question;

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
        $answerData = Choice::find($answer_id);
        $questPaper = QuestionPaper::find($question_id);
        $questPaper->answer_selected = $answerData->id;
        $questPaper->answer_selected_title = $answerData->pointing;
        
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
        $answerDetail = [];

        $ticket_id = session('ticket');
        $register = registerTest::find($ticket_id);
        //Test Type
        $testType = TestType::find($register->testTypeId);
        //Count all question
        $countAllQuestion = QuestionPaper::where('ticket_id','=',$ticket_id)->count();
        //Question not answered
        $countQuestionNotAnswered = QuestionPaper::where('ticket_id','=',$ticket_id)->where('answer_selected','=',NULL)->count();
  
        $countWrongQuestion = DB::select("SELECT * FROM question_papers WHERE  correct_answer != answer_selected_title and ticket_id = ?",[$ticket_id]);
       // dd($countWrongQuestion);

       //Question not correct list
       $questionWrongList = DB::select("
                SELECT qp.question_string,
            ap.answer_title , ap.answer_text,
            (CASE 
                WHEN correct_answer != answer_selected_title THEN 'False'
                WHEN correct_answer = answer_selected_title THEN 'True'
                WHEN answer_selected_title is NULL THEN NULL
            END)
            as correctOrNot
            from question_papers qp left join answer_papers ap on ap.id = qp.answer_selected 
            WHERE qp.ticket_id = ?",[$ticket_id]);

        return view('showExampResult')
        ->with('countAllQuestion', $countAllQuestion)
        ->with('countQuestionNotAnswered',$countQuestionNotAnswered)
        ->with('countWrongQuestion',$countWrongQuestion)
        ->with('register',$register)
        ->with('questinoWrongList',$questionWrongList)
        ->with('testType',$testType);
    }

}
