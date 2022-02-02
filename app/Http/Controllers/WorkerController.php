<?php

namespace App\Http\Controllers;

use App\Models\AnswerPaper;
use App\Models\appsetting;
use App\Models\Choice;
use App\Models\QuestionPaper;
use App\Models\questions;
use App\Models\registerTest;
use App\Models\TestType;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WorkerController extends Controller
{
    /** Function to call the starter view
     *  For User input Name and their driver ID from school
     *  Location: /views/start.blade.php
     */
    public function starterPage()
    {
        //Load Test Type Data
        $testTypes = TestType::all();
        return view('start')->with('testTypes', $testTypes);
    }

    /**
     * Function to submit data from starter page
     * Rule Check Input ID compare with Testing Type
     */
    public function validateStarter(Request $req)
    {
        $req->validate(
            [
                'testingNo' => 'required'
            ],
            [
                'testingNo.required' => 'ກະລຸນາໃສ່ເລກທີ່ສອບເສັງ',
            ]
        );

        //Check tester has been tested alread?
        //Condition depend on the TestType

        $unique = registerTest::where('testingNo', '=', $req->input('testingNo'))->first();
        //Check active and disactive status
        if($unique !== null){
            if($unique->status ==="disactive"){
                if($unique->testing_timespan === '0'){
                    return redirect()->back()->with('info','ທ່ານ '.$unique->testerFullname.'ບໍ່ສາມາດສອບເຂົ້າສອບເສັງໄດ້, ເນື່ອງຈາກທ່ານໄດ້ສອບເສັງແລ້ວ');
                }
                return redirect()->back()->with('info','ທ່ານ '.$unique->testerFullname.' ບໍ່ສາມາດສອບເຂົ້າສອບເສັງໄດ້');
            }
        }
        //Get the testing timespan
        $settings = appsetting::find(1)->first();

        //Check if unique then return to start page
        if ($unique != null) {
            //Check the testing is timeout or not
            if ($unique->testing_timespan == $settings->test_time) {
                //Reset User question and answer
                $lastQ = QuestionPaper::where('ticket_id','=',$unique->id)->get();
               // dd($lastQ);
               for($i=0;$i<sizeof($lastQ);$i++){
                   AnswerPaper::where('id','=',$lastQ[$i]->id)->delete();
               }
                QuestionPaper::where('ticket_id','=',$unique->id)->delete();

                // Operation To generate random question for this user with number of question in DB
                $ranDomQuestion = questions::inRandomOrder()->limit($settings->questionNo)->get();
                // //Perform Update data and contionue to Testing page
                $unique->testing_timespan = $settings->test_time;
                /** Save to database */
                $unique->save();
                // Loop and Add Random question to test paper table
                for ($i = 0; $i < sizeof($ranDomQuestion); $i++) {

                    //Insert the question detail to the table
                    $questPaper = new QuestionPaper();
                    $questPaper->ticket_id = $unique->id;
                    $questPaper->question_string = $ranDomQuestion[$i]->question;
                    $questPaper->photo = $ranDomQuestion[$i]->photo;
                    $questPaper->question_id = $ranDomQuestion[$i]->id;
                    $questPaper->correct_answer = $ranDomQuestion[$i]->correct_answer;
                    $questPaper->save();

                    //Insert the answer for each question
                    $answerList = Choice::where('question_id', '=', $ranDomQuestion[$i]->id)->get();
                    // dd($answerList);

                    //Save the answer
                    for ($j = 0; $j < sizeof($answerList); $j++) {
                        $answer = new AnswerPaper();
                        $answer->paper_id = $questPaper->id;
                        $answer->answer_text = $answerList[$j]->answer;
                        $answer->answer_title = $answerList[$j]->pointing;
                        $answer->save();
                    }
                }

                //Set Session and redirect to testing page
                //Set ticket id
                session(['ticket' => $questPaper->ticket_id]);
                session()->save();
                //Redirect to testing page
                return redirect()->route('doTest');
            }

            if ($unique->testing_timespan < $settings->test_time && $unique->testing_timespan !== "0") {
                $questionHasBeenAnswer = QuestionPaper::where('ticket_id', '=', $unique->id, 'and')->where('answer_selected', '=', NULL)->get();
                //Check user has answer somequestion ?
                if (sizeof($questionHasBeenAnswer) >= 0) {
                    error_log('$questionHasBeenAnswer) > 0');
                    //Set session
                    session(['ticket' => $unique->id]);
                    session()->save();
                    //Redirect to testing page
                    return redirect()->route('doTest');
                }
            }

            if ($unique->testing_timespan === "0") {
                //Set session
                session(['ticket' => $unique->id]);
                session()->save();
                //Redirect to testing page
                return redirect()->route('showTestResult');
            }

        } else {
            return redirect()->route('starterPage')->with('error', 'ບໍ່ສາມາດສອບເສັງໄດ້ກະລຸນາພົວພັນກັບຫ້ອງການສອບເສັງ')->withInput();
        }
        error_log("exit function");
    }
    /**
     * Function to call the testing page of user
     */
    public function doTest()
    {
        //Get session ticket
        $ticket = session('ticket');
        //Get question list to the view by ticket
        $questions = QuestionPaper::where('ticket_id', '=', $ticket)->get();
        //Get test type
        $registerTest = registerTest::find($ticket);
        $testype = TestType::find($registerTest->testTypeId);

        return view('testscreen')->with('questions', $questions)
            ->with("testType", $testype)
            ->with('register', $registerTest);
    }

    /**
     * Function to return session
     */
    public function getSession()
    {
        return response()->json(session('ticket'));
    }

    /** Function to logout or stop the exam */
    public function stopExamp()
    {

        Session::flush();
        return redirect()->route('starterPage');
    }

    /** Function to return crsf_token as json */
    public function showToken()
    {
        return response()->json(csrf_token());
    }

    public function testJson()
    {
        $jsonstr = "{\n    timer:'1200'\n}";
        dd(json_decode($jsonstr));
    }
}
