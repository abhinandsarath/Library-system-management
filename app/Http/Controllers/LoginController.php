<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginView(){
        return view('loginView');
    }

    public function login(Request $request){
        $input=['email'=>request('email'),'password'=>request('password')];

        if (Auth::attempt($input,true)){
            return redirect()->route('booksView');
        }
        else{
            return redirect()->route('loginView')->with('message','Invalid User');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('loginView');
    }

    public function userLoginView(){
        return view('userLoginView');
    }

    public function userRegisterView(){
        return view('userRegisterView');
    }

    public function userLogin(Request $request){
        $input=['email'=>request('email'),'password'=>request('password')];

        if (Auth::attempt($input,true)){
            return redirect()->route('borrowBooksView');
        }
        else{
            return redirect()->route('userLoginView')->with('message','Invalid User');
        }
    }

    public function userRegister(Request $request){
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->save();
        return redirect()->route('userLoginView')->with('message','User Registration Completed.');
    }

    public function userLogout(){
        
    }
}
