<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

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

    public function profile(User $user){
        
        
        return view('profile-posts',['usernam' => $user->username, 'posts'=>$user->posts()->latest()->get()]);
    }

    public function manageAvatarForm(){
        return view('manage-avatar');
    }
    public function storeAvatar(Request $request){
        $request->validate([
            'avatar' => 'required|image|max:8000'
        ]);
        $user = auth()->user();
        $filename = $user->id.'-'.uniqid().'.jpg';

        $imgData = Image::make($request->file('avatar'))->fit(120)->encode('jpg');
        Storage::put('public/avatars/'.$filename ,$imgData);

        $oldAvatar = $user->avatar;
        
        $user->avatar = $filename;
        $user->save();
        if($oldAvatar != 'fallback-avatar.jpg'){
            Storage::delete(str_replace("/storage/", "public/", $oldAvatar));
        }

        return back()->with('success', 'Congratulation for new Avatar');
        
    }
}
