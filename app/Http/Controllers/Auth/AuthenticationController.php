<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AuthenticationController extends Controller
{
    public function login(){
        return view("auth.login");
    }

    public function login_submit(Request $request){
        $request->validate([
            'email'=>'required|email|exists:users,email',
            'password'=>'required|min:3'
        ],[
            'email'=>[
                'required'=>'Email is required',
                'email'=>"Email should be a valid email address",
                'exists'=>'Email does not match our records'
            ],
            'password'=>[
                'required'=>'Password is required',
                'min'=>'Password must contain minimum :min letters'
            ]
        ],$request->all());

        $remember = $request->remember == 'on' ? true : false;
        if(Auth::attempt($request->only("email","password"),$remember)){
            $user = Auth::user();
            $request->session()->regenerate();
            if($user->is_admin){
                return redirect()->route('admin.dashboard');
            }else{
                return redirect()->route('user.dashboard');
            }
        }else{
            return redirect()->back()->withErrors(["password"=>"Invalid password"]);
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function register(){
        return view("auth.register");
    }

    public function register_submit(Request $request){
        $request->validate([
            'email'=>'required|email|exists:users,email',
            'password'=>'required|min:3'
        ],[
            'email'=>[
                'required'=>'Email is required',
                'email'=>"Email should be a valid email address",
                'exists'=>'Email does not match our records'
            ],
            'password'=>[
                'required'=>'Password is required',
                'min'=>'Password must contain minimum :min letters'
            ]
        ],$request->all());
    }
}
