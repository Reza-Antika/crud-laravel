<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Auth;

class RegisterController extends Controller
{
    public function registerIndex(){

         $session = Auth::user();
        if(!empty($session)){
            return redirect('/login');
        }
        return view('register');
    }

    public function register()
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $user = User::create(request(['name', 'email', 'password']));
        
        if($user) {
            return redirect()->to('/login');
        } else {
            session()->flash('message', 'User not found');
            return Redirect::back();
        }
    }
}
