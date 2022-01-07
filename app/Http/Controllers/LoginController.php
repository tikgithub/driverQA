<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Controller for controll the login and logout process
 */
class LoginController extends Controller
{
    /** Show the index page */
    public function index(){
        return view('admin.login');
    }

    /** Function to validate user login */
    public function validateUser(Request $req){
        $userdata = $req->only('name','password');
        //hashing password
      //  dd(Auth::attempt(['email'=>'admin@admin.co8m', 'password'=>'123qwe!@#']));

        if(Auth::attempt(['name'=>$userdata['name'], 'password'=>$userdata['password']])){
            return redirect()->route('admin_home');
        }else{
            return redirect()->route('getLogin')->with('error','ກວກສອບລະຫັດຜ່ານອີກຄັ້ງ');
        }
    }

    /** 
     * Function to logout for admin
     */
    public function logout(){
        Auth::logout();
        return redirect()->route('starterPage');
    }
}
