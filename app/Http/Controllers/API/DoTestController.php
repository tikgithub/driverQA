<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
}
