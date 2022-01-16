<?php

namespace App\Http\Controllers;

use App\Models\AnswerPaper;
use App\Models\QuestionPaper;
use App\Models\registerTest;
use Illuminate\Http\Request;
use PhpParser\JsonDecoder;

class PerformTestController extends Controller
{
    /**
     * Function to return JSON data of question and answer 
     * when user click at question
     */
    public function getQuestionDetail($id)
    {
        $answers = AnswerPaper::where('paper_id', '=', $id)->get();
        return response()->json(["question" => QuestionPaper::find($id), 'Answers' => $answers]);
    }

    /**
     * Function to update the testing time of user 
     */

    public function updateUserTimer(Request $req)
    {
       //Get json object
        $object = json_decode($req->getContent());
        //Get session ticket and update new time to DB
        $ticket = registerTest::find(session('ticket'));
        $ticket->testing_timespan = $object->timer;
        $ticket->save();
 
        return response()->json('OK');
    }
}
