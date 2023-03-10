<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function index(){
        return Inertia::render('Auth::Login', [
            'logo' => config('ladmin.logo'),
            'success' => ['status' => false, 'message' => null],
        ]);
    }

    public function login(Request $request){

        if (Auth::attempt($request->only(['email', 'password']))) {
            $user =  auth()->user();

            return to_route('auth.welcome');
        }

        return Inertia::render('Auth::Login', [
            'logo' => config('ladmin.logo'),
            'errors' => 'These Credentials do not match our records.',
        ]);



    }
}
