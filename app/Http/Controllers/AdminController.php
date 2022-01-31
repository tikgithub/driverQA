<?php

namespace App\Http\Controllers;

use App\Models\questions;
use App\Models\registerTest;
use App\Models\TestType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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

        $questionList = questions::paginate(50);

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
     /**
      * Function to show Tester page
      */
      public function showTesterManagerPage(){
      
          $test = TestType::all();
          return view('admin.tester.index')->with('testType',$test);

      }
      /**
       * Function to store the Tester to db
       */
      public function storeTester(Request $req){

          //Validate tester
          $req->validate([
              'testerFullname' => 'required',
              'testingNo'   =>  'required|unique:register_tests,testingNo',
              'testTypeId'  =>  'required',
              'contact' =>  'required'
          ]);

          //Create new Object
          $tester = new registerTest();
          $tester->testerFullname = $req->input('testerFullname');
          $tester->testingNo = $req->input('testingNo');
          $tester->testTypeId = $req->input('testTypeId');
          $tester->contact = $req->input('contact');
          $tester->email = $req->input('email');
          $tester->status = 'disactive';


            Session::flash('success','from flash function');
            Session::save();
           // dd(Session::all());
            return redirect()->route('TesterShow')->with('success','Server Error Please try again later');

      }
}
