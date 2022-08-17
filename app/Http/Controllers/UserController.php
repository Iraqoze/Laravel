<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{


    //show register form
   public function create(){
    return view('users.create');
   }


   //Store new User
   public function store(Request $request){
    $formFields=$request->validate([
        'name'=>['required','min:3'],
        'email'=>['required','email', Rule::unique('users','email')],
        'password' =>'required|confirmed|min:6'

    ]);

    //Hash Password
    $formFields['password']=bcrypt($formFields['password']);

    //Create User
    $user=User::create($formFields);

    //login
    auth()->login($user);

    return redirect('/')->with('message','User Created and Logged In Successfully');


   }

   //Logout User
   public function logout(Request $request){
    auth()->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->with('message', 'You have been logged out');

   }

   public function login(){
    return view('users.login');
   }

   //Authenticate User
   public function authenticate(Request $request){
    $formFields=$request->validate([
        'email'=>['required','email'],
        'password' =>'required'
    ]);
    if(auth()->attempt($formFields)){
        $request->session()->regenerate();
        return redirect('/')->with('message','You are now Logged in');
    }
    return back()->withErrors(['email'=>'Invalid credentials'])->onlyInput('email');
   }

}
