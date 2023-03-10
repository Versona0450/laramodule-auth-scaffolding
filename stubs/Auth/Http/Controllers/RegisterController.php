<?php

namespace Modules\Auth\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Inertia\Inertia;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Models\Client;

class RegisterController extends Controller
{
    public function index()
    {
        return Inertia::render('Auth::Register', [
            'logo' => config('ladmin.logo')
        ]);
    }
    public function register(Request $request){

        // try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ], [
                'name.required' => 'Nama tidak boleh kosong',
                'name.max' => 'Nama tidak boleh lebih dari :max karakter',
                'email.required' => 'Email tidak boleh kosong',
                'email.email' => 'Email tidak valid',
                'email.max' => 'Email tidak boleh lebih dari :max karakter',
                'email.unique' => 'Email sudah digunakan',
                'password.required' => 'Password tidak boleh kosong',
                'password.min' => 'Password harus memiliki minimal :min karakter',
                'password.confirmed' => 'Password dan konfirmasi password harus sama',
            ]);

            if ($validator->fails()) {
                return Inertia::render('Auth::Register', [
                    'logo' => config('ladmin.logo'),
                    'errors' => $validator->errors()->toArray(),
                ]);
            }


            $user = new User();
            // $user->uuid = (string) Str::uuid();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return to_route('auth.loginPage');
    }
}
