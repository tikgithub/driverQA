<?php

namespace App\Http\Controllers;

use App\Models\appsetting;
use App\Models\registerTest;
use App\Models\TestType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkerController extends Controller
{
    /** Function to call the starter view 
     *  For User input Name and their driver ID from school
     *  Location: /views/start.blade.php
     */
    public function starterPage(){
        //Load Test Type Data
        $testTypes = TestType::all();
        return view('start')->with('testTypes',$testTypes);
    }

    /**
     * Function to submit data from starter page
     * Rule Check Input ID compare with Testing Type
     */
    public function validateStarter(Request $req){
        $req->validate([
            'testerFullname' => 'required',
            'testingNo' => 'required',
            'testTypeId' => 'required'
        ],
        [
            'testerFullname.required' => 'ກະລຸນາໃສ່ຊີ່ຜູ້ສອບເສັງ',
            'testingNo.required' => 'ກະລຸນາໃສ່ເລກທີ່ສອບເສັງ',
            'testTypeId.required' => 'ກະລຸນາເລືອກປະເພດຂອງການສອບເສັງ'
        ]);
        
        //Check tester has been tested alread?
        //Condition depend on the TestType

        $unique = registerTest::where('testingNo','=',$req->input('testingNo'),'and')->where('testTypeId','=',$req->input('testTypeId'))->first();
        //Check if unique then return to start page
        if($unique!=null){
            return redirect()->route('starterPage')->with('error','ທ່ານໄດ້ສອບເສັງໃນປະເພດນີ້ແລ້ວ')->withInput();
        }
        //Perform save data and contionue to Testing page
        $reg = new registerTest();
        $reg->testerFullname = $req->input('testerFullname');
        $reg->testingNo = $req->input('testingNo');
        $reg->testTypeId = $req->input('testTypeId');

        //Get the testing timespan
        $time = appsetting::find(1)->default_testing_timespan;
        $reg->testing_timespan = $time;
        /** Save to database */
        $registerDetail = $reg->save();

        dd($reg);
    }
}
