<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class User extends Controller
{
    public function login(){
        return view('user.login');
    }

    public function proses_login(request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        $check= $request->only('email','password');
        if(Auth::guard('user')->attempt($check)){
            return redirect()->route('user.home')->with('success','Login Success');
        }else{
            return redirect()->back()->with('erorr','Login Failed');
        }
    
    }

    public function logout(Request $request){
        Auth::guard('user')->logout();
        return redirect()->route('user.login');
    }
}
