<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Auth;

class LoginController extends Controller
{
    public function index(){
        
        if(Auth::user()){
            return redirect('/dashboard');
        }
        return view('/login');
        // atau bisa juga menggunakan cara di bawah ini
        // $session = Auth::user();
        // if(!empty($session)){
        //     return redirect('/dashboard');
        // }
        
    }
    public function login(Request $request){
        $user = Auth::attempt(['email' =>$request->email, 'password' =>$request->password]);

        if($user) {
            return redirect()->to('/dashboard');
        } else {
            session()->flash('message', 'User not found');
            return Redirect::back();
        }
    }
    
}
