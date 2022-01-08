<?php

namespace App\Http\Controllers;

use App\Models\appsetting;
use Illuminate\Http\Request;
use PDO;

class AppSettingController extends Controller
{
    /** Function to update the setting to db  */
    public function update(Request $req){
        
        $app = appsetting::find($req->input('id'));
        $app->test_time = $req->input('test_time');
        $app->questionNo = $req->input('questionNo');

        if($app->save()){
            return redirect()->back();
        }else{
            return redirect()->route('admin_home')->with('error','ເກີດຂໍ້ຜິດພາດຈາກ server ກະລຸນາລອງໃໝ່ພາຍຫຼັງ');
        }
    }
}
