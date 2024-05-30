<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\SeekerRegistrationRequest;
use App\Http\Requests\SeekerLoginRequest;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    const JOB_SEEKER = 'seeker';
    public function createSeeker(){
        return view("user.seeker-register");
    }

    public function storeSeeker(SeekerRegistrationRequest $request){
       
        User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'user_type' => self::JOB_SEEKER,
        ]);

        return back();
    }

    public function login(){
        return view('user.login');
    }

    public function postLogin(SeekerLoginRequest $request){
        $credentials = $request->only('email', 'password');
        if (Auth()->attempt($credentials)) {
            return redirect()->route('dashboard');
        }
        return back();
    }
}
