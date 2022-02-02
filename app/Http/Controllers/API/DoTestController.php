<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AnswerPaper;
use App\Models\appsetting;
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
    public function getPaperTest()
    {
        //Get ticket ID

        $ticket_id = session(['ticket']);
        dd($ticket_id);
        //$question = QuestionPaper::where('ticket_id','=',$ticket_id)->get();
        return ['ok', 'ok'];
    }

    public function updateUserTimer(Request $req)
    {
        return response()->json($req->all());
    }

    public function getQuestionDetail($id)
    {
        $answers = AnswerPaper::where('paper_id', '=', $id)->get();
        return response()->json(["question" => QuestionPaper::find($id), 'Answers' => $answers]);
    }

    /** Function to select answer and save to db */
    public function selectAnswer($question_id, $answer_id)
    {
        $answerData = AnswerPaper::find($answer_id);
        $questPaper = QuestionPaper::find($question_id);
        $questPaper->answer_selected = $answerData->id;
        $questPaper->answer_selected_title = $answerData->answer_title;

        if ($questPaper->save()) {
            return response(200);
        } else {
            return response(500);
        }
    }

    /**
     * Function to submit the test if user finish
     */
    public function submitExam()
    {
        $ticket_id = session('ticket');
        $regisTest = registerTest::find($ticket_id);
        $regisTest->testing_timespan = 0;
        $regisTest->save();
        return redirect()->route('showTestResult');
    }

    /** Function to display testing result of user */
    public function showTestResult()
    {
        $answerDetail = [];

        $ticket_id = session('ticket');
        $register = registerTest::find($ticket_id);
        //Test Type
        $testType = TestType::find($register->testTypeId);
        //Count all question
        $countAllQuestion = QuestionPaper::where('ticket_id', '=', $ticket_id)->count();
        //Question not answered
        $countQuestionNotAnswered = QuestionPaper::where('ticket_id', '=', $ticket_id)->where('answer_selected', '=', NULL)->count();

        $countWrongQuestion = DB::select("SELECT * FROM question_papers WHERE  correct_answer != answer_selected_title and ticket_id = ?", [$ticket_id]);

        $appSetting = appsetting::find(1);

            //Total number of not correct answer
            $number_of_wrong = sizeof($countWrongQuestion);
      
            //Number of question answered correctly
            $number_of_correct = $appSetting->questionNo - ($number_of_wrong + $countQuestionNotAnswered);
           // dd($number_of_wrong, $number_of_correct);
            if ($number_of_correct < $appSetting->minimum_pass_score) {
                //Not pass
                $register->test_status = 0;
            } else {
                //Pass
                $register->test_status = 1;
            }
            $register->save();

        // dd($countWrongQuestion);

        //Question not correct list
        $questionWrongList = DB::select("
       SELECT ap .paper_id ,
		qp.question_string,
       (CASE
           WHEN correct_answer != answer_selected_title THEN 'False'
           WHEN correct_answer = answer_selected_title THEN 'True'
           WHEN answer_selected_title is NULL THEN NULL
       END)
       as correctOrNot,
       concat(qp.correct_answer,'.',(SELECT aps.answer_text from answer_papers aps where aps.answer_title = qp.correct_answer and aps.paper_id=qp.id))  as real_answer,
       concat(qp.answer_selected_title,'.', (SELECT aps.answer_text from answer_papers aps where aps.answer_title = qp.answer_selected_title and aps.paper_id=qp.id))as user_selected
       from question_papers qp left join answer_papers ap on ap.id = qp.answer_selected
       WHERE qp.ticket_id = ?", [$ticket_id]);

        return view('showExampResult')
            ->with('countAllQuestion', $countAllQuestion)
            ->with('countQuestionNotAnswered', $countQuestionNotAnswered)
            ->with('countWrongQuestion', $countWrongQuestion)
            ->with('register', $register)
            ->with('questinoWrongList', $questionWrongList)
            ->with('testType', $testType)
            ->with('test_status', $register->test_status);
    }

    /**
     * Function to perform reset the test for user
     */
    public function resetTest()
    {
        $ticket_id = session('ticket');
        //Reset User question and answer
        $lastQ = QuestionPaper::where('ticket_id', '=', $ticket_id)->get();
        // dd($lastQ);
        for ($i = 0; $i < sizeof($lastQ); $i++) {
            AnswerPaper::where('id', '=', $lastQ[$i]->id)->delete();
        }
        QuestionPaper::where('ticket_id', '=', $ticket_id)->delete();

        //Reset the testing time
        $settings = appsetting::find(1)->first();

        $register_test = registerTest::find($ticket_id);
        $register_test->testing_timespan = $settings->test_time;
        $register_test->test_status = NULL;
        $register_test->save();

        return redirect()->route('validateTester');
    }
}
