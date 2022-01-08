<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    /**
     * Function to store answer to database
     *  */
    public function store(Request $req){
        /**
         * Validate user input with check is unique of answer column ?
         */
        $req->validate([
            'answer'=>'required',
            'pointing'=>'required'
        ]);
        //Create Object choice
        $choice = new Choice();
        $choice->answer = $req->input('answer');
        $choice->pointing = $req->input('pointing');
        $choice->question_id = $req->input('question_id');

        if($choice->save()){
            return redirect()->back()->with('success','ດຳເນີນການສຳເລັດ');
        }else{
            return redirect()->route('admin_home')->with('error','Server Error Please try again later');
        }

    }
}
