<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\RegistrationFormRequest;
use App\Http\Requests\SeekerLoginRequest;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    const JOB_SEEKER = 'seeker';
    const JOB_POSTER = 'employer';
    public function createSeeker(){
        return view("user.seeker-register");
    }

    public function storeSeeker(RegistrationFormRequest $request){
       
        User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'user_type' => self::JOB_SEEKER,
        ]);

        return redirect()->route('login')->with('successMessage', 'Your account was created.');
    }

    public function login(){
        return view('user.login');
    }

    public function postLogin(SeekerLoginRequest $request){
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }
        return "Wrong email or password!!";
    }

    public function logout(){     
        auth()->logout();
        return redirect()->route('login');
    }

    public function createEmployer(){
        return view('user.employer-register');
    }

    public function storeEmployer(RegistrationFormRequest $request)
    {
        User::create([
            'name' => request('name'),
            'email' =>request('email'),
            'password'=> bcrypt(request('password')),
            'user_type' => self::JOB_POSTER,
            'user_trial' => now()->addWeek()

        ]);
        return redirect()->route('login')->with('successMessage', 'Your account was created.');
    }

}
