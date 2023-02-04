<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{   
    public function correctHomepage(){
        if(auth()->check()){
            return view('home-feed');
        }else{
            return view('home');
        }
    }
    public function login(Request $request){

        $incomingFields = $request-> validate([
            'loginusername' => 'required',
            'loginpassword' => 'required',
        ]);

        if(auth()->attempt(['username'=>$incomingFields['loginusername'], 'password' => $incomingFields['loginpassword']])){
            $request->session()->regenerate();
            return redirect('/')->with('success', 'Welcome, You are successfully logged in');
        }else{
            return redirect('/')->with('failure','Invalid Login');
        }

    }
    public function logout(){
        auth()->logout();
        return redirect('/')->with('success','You are logged out');
    }
    public function register(Request $request){
        $incomingFields = $request->validate([
            'username' => ['required', 'min:3', 'max:15', Rule::unique('users','username')],
            'email' => ['required', 'email', Rule::unique('users','email')],
            'password' => ['required','min:8', 'confirmed']
        ]);
        $incomingFields['password'] = bcrypt($incomingFields['password']);
         $user = User::create($incomingFields);
         auth()->login($user);

        return redirect('/')->with('success','Thank you for createing account');
    }
}
