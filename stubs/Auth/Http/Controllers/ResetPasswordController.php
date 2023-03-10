<?php

namespace Modules\Auth\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Laravel\Sanctum\PersonalAccessToken;
use Modules\Auth\Mail\ResetPasswordUserMail;

class ResetPasswordController extends Controller
{
    public function index()
    {
        return Inertia::render('Auth::ForgotPassword', [
            'logo' => config('ladmin.logo'),
        ]);
    }

    public function forgot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($validator->fails() || !$user) {
            return Inertia::render('Auth::ForgotPassword', [
                'logo' => config('ladmin.logo'),
                'errors' => true,
                'success' => false,
            ]);
        }


        $token = $user->createToken('forgot-password')->plainTextToken;

        $link = route('auth.resetPasswordPage', ['token' => $token]);
        Mail::to($user->email)->send(new ResetPasswordUserMail($user->toArray(), $link));

        return Inertia::render('Auth::ForgotPassword', [
            'logo' => config('ladmin.logo'),
            'errors' => false,
            'success' => true,
        ]);
    }

    public function resetPage($token)
    {
        $accessToken = PersonalAccessToken::findToken($token);

        if ($accessToken && $accessToken->last_used_at == null) {
            return Inertia::render('Auth::ResetPassword', [
                'logo' => config('ladmin.logo'),
                'token' => $token,
            ]);
        }

        return to_route('auth.loginPage');

    }

    public function reset(Request $request, $token)
    {
        $val = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed',
        ]);

        if($val->fails()){
            return Inertia::render('Auth::ResetPassword', [
                'logo' => config('ladmin.logo'),
                'token' => $token,
                'errors' => $val->errors()->toArray(),
            ]);
        }

        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken) {
            return to_route('auth.loginPage');
        }

        $user = User::find($accessToken->tokenable_id);

        $user->update([
            'password' => bcrypt($request->password)
        ]);

        return to_route('auth.loginPage');
    }
}
