<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);

        Auth::login($user);

        $user->sendEmailVerificationNotification();

        $user->profile()->create([
            'post_code' => '',
            'address' => ''
        ]);

        return redirect('/email/verify');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            if (!$user->email_verified_at) {

                return redirect('/email/verify');
            }
            return redirect('/');
        };

        return back()->withErrors([
            'login_error' => 'ログイン情報が登録されていません',
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
