<?php

namespace App\Http\Controllers;

use App\Models\questions;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class QuestionController extends Controller
{
    /**
     * Function to store question data
     */
    public function store(Request $req)
    {
        /** Vailidate question data should mandary 
         *  Image can optional some case question not have picture
         * */
        $req->validate(
            [
                'question' => 'required',
                'questionImage' => 'max:1000'
            ],
            [
                'question.required' => 'ກະລຸນາໃສ່ຄຳຖາມ',
                'questionImage.max' => 'ຮູບພາບຕ້ອງບໍ່ຫຼາຍກວ່າ 1MB'
            ]
        );

        // Set Object data
        $question = new questions();
        $question->question = $req->input('question');

        /** When user submit with picture */
        $uploadingImage = "";
        if ($req->hasFile('questionImage')) {

            //Get the original extension
            $extension = $req->file('questionImage')->getClientOriginalExtension();

            //Generate new upload file name
            $generateImage = Str::uuid() . '.' . $extension;

            //Create upload path with filename
            $uploadingImage = "imageQuestion/" . $generateImage;

            //Perform upload to directory imageQuestion in public folder
            $req->file('questionImage')->move('imageQuestion', $generateImage);
            //Set data attribute
            $question->photo = $uploadingImage;
        }
        //Execute data to database
        if ($question->save()) {

            return redirect()->route('questionIndex')->with('success', 'ສຳເລັດ');
        } else {

            return redirect()->route('getLogin')->with('error', 'ເກີດຂໍ້ຜິດພາດຈາກລະບົບ');
        }
    }

    /**
     * Function to show update page of question information
     */
    public function edit($id){
        $question = questions::find($id);

        return view('admin.question.question-edit')->with('question',$question);
    }

    /**
     * Function to update question
     */
    public function update(Request $req){
        /** Vailidate question data should mandary 
         *  Image can optional some case question not have picture
         * */
        $req->validate(
            [
                'question' => 'required',
                'questionImage' => 'max:1000'
            ],
            [
                'question.required' => 'ກະລຸນາໃສ່ຄຳຖາມ',
                'questionImage.max' => 'ຮູບພາບຕ້ອງບໍ່ຫຼາຍກວ່າ 1MB'
            ]
        );

         // Find the object data from database
         $question = questions::find($req->input('question_id'));
         $question->question = $req->input('question');
 
         /** When user submit with picture */
         $uploadingImage = "";
         if ($req->hasFile('questionImage')) {
 
             //Get the original extension
             $extension = $req->file('questionImage')->getClientOriginalExtension();
 
             //Generate new upload file name
             $generateImage = Str::uuid() . '.' . $extension;
 
             //Create upload path with filename
             $uploadingImage = "imageQuestion/" . $generateImage;
            
             /** If have current image then delete it */
             //Get current image path from photo filed
             File::delete($question->photo);

             //Perform upload to directory imageQuestion in public folder
             $req->file('questionImage')->move('imageQuestion', $generateImage);
             //Set data attribute
             $question->photo = $uploadingImage;
            
            
         }
         //Execute data to database
         if ($question->save()) {
 
             return redirect()->route('questionEdit',['id'=>$req->input('question_id')])->with('success', 'ສຳເລັດ');
         } else {
 
             return redirect()->route('getLogin')->with('error', 'ເກີດຂໍ້ຜິດພາດຈາກລະບົບ');
         }
    }
}
