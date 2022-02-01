<?php

namespace App\Http\Controllers;

use App\Models\appsetting;
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

    public function appSettingPage()
    {
        //Get first row of select result
        $settings = DB::table('appsettings')->first();

        return view('admin.testsetting.index')->with('settings', $settings);
    }
    /**
     * Function to show Tester page
     */
    public function showTesterManagerPage()
    {

        $test = TestType::all();
        return view('admin.tester.index')->with('testType', $test);
    }
    /**
     * Function to store the Tester to db
     */
    public function storeTester(Request $req)
    {

        //Validate tester
        $req->validate(
            [
                'testerFullname' => 'required',
                'testingNo'   =>  'required|unique:register_tests,testingNo',
                'testTypeId'  =>  'required',
                'contact' =>  'required'
            ],
            [
                'testingNo.unique' => 'ເລກທີ່ສອບເສັງນີ້ໄດ້ຖືກນຳໃຊ້ແລ້ວ ກາລຸນາລອງໃໝ່ອີກຄັ້ງ'
            ]
        );

        //Create new Object
        //Get the testing timespan
        $settings = appsetting::find(1)->first();

        $tester = new registerTest();
        $tester->testerFullname = $req->input('testerFullname');
        $tester->testingNo = $req->input('testingNo');
        $tester->testTypeId = $req->input('testTypeId');
        $tester->contact = $req->input('contact');
        $tester->email = $req->input('email');
        $tester->testing_timespan = $settings->test_time;
        $tester->status = 'disactive';
        if ($tester->save()) {
            return redirect()->route('TesterShow')->with('success', 'ດຳເນີນການສຳເລັດ');
        } else {
            return redirect()->route('TesterShow')->with('error', 'Server Error Please try again later');
        }
    }
    /**
     * Function search tester
     */
    public function searchTester(Request $req)
    {
        $queryString = "select rt.id, rt.testerFullname, rt.testingNo, rt.testing_timespan, tt.name ,rt.contact, rt.email ,
          rt.status, rt.start_test_date from register_tests rt inner join test_types tt on rt.testTypeId = tt.id
          where ";
        $params = [];
        //dd($req->input('status'));
        if (!$req->input('searchFullname') && !$req->input('status')) {
            return redirect()->back()->with('warning', 'ກະລຸນາເລືອກລາຍທີ່ຕ້ອງການຄົ້ນຫາກ່ອນ');
        }
        if ($req->input('searchFullname')) {
            $queryString .= " testerFullname like ?";
            array_push($params, "%" . $req->input('searchFullname') . "%"); //push parameter
            if ($req->input('status')) {
                $queryString .= " And status= ?";
                array_push($params, $req->input('status'));
            }
        } else {
            $queryString .= " status=?";
            array_push($params, $req->input('status'));
        }

        $result = DB::select($queryString, $params);

        return view('admin.tester.searched')->with('result', $result);
    }

    /**
     * Function for update tester status = active
     */
    public function updateActiveStatusTester($id)
    {
        $tester = registerTest::find($id);
        $tester->status = 'active';
        $tester->save();

        return response()->json(200);
    }


    /**
     * Function for update tester status = deactive
     */
    public function updateDeActiveStatusTester($id)
    {
        $tester = registerTest::find($id);
        $tester->status = 'disactive';
        $tester->save();

        return response()->json(200);
    }
    /**
     * Function to edit the tester info
     */

    public function editTesterInfo($id)
    {
        $tester = registerTest::find($id);
        $testType = TestType::all();

        return view('admin.tester.edit')
            ->with('tester', $tester)
            ->with('testType', $testType);
    }
    /**
     * Function to update the tester info
     */
    public function updateTesterInfo(Request $req)
    {
        //Validate tester
        $req->validate(
            [
                'testerFullname' => 'required',
                'testingNo'   =>  'required',
                'testTypeId'  =>  'required',
                'contact' =>  'required'
            ]
        );

        $tester = registerTest::find($req->input('id'));
        $tester->testerFullname = $req->input('testerFullname');
        $tester->testingNo = $req->input('testingNo');
        $tester->testTypeId = $req->input('testTypeId');
        $tester->contact = $req->input('contact');
        $tester->email = $req->input('email');
        if ($tester->save()) {
            return redirect()->back()->with('success', 'ດຳເນີນການສຳເລັດ');
        } else {
            return redirect()->back()->with('error', 'ເກີດຂໍ້ຜິດພາດ ລອງໃຫມ່ອີກຄັ້ງ');
        }
    }
}
