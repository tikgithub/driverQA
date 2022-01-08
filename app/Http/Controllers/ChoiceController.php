<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\questions;
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

    /**
     * Function to edit the choice
     */
    public function edit($id, $choice_id){
    
        $question = questions::find($id);
        $choices = Choice::where('question_id','=',$id)->get();
        $choice = Choice::find($choice_id);

        return view('admin.question.question-edit')
        ->with('question',$question)
        ->with('choices',$choices)
        ->with('choice',$choice);
    }

    /** Function to update the choice */
    public function update(Request $req){
         /**
         * Validate user input with check is unique of answer column ?
         */
        $req->validate([
            'answer'=>'required',
            'pointing'=>'required',
            'choice_id' => 'required'
        ]);

        $choice = Choice::find($req->input('choice_id'));
        $choice->answer = $req->input('answer');
        $choice->pointing = $req->input('pointing');
        if($choice->save()){
            return redirect()->back()->with('success','ດຳເນີນການສຳເລັດ');
        } else{
            return redirect()->route('admin_home')->with('error','Server Error Please try again later');
        }
    }

}
