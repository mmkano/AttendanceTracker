<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\AuthCodeMail;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function showRegisterForm() {
        return view('auth.register');
    }

    public function register(RegisterRequest $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return view('auth.login');
    }

    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $authCode = rand(100000, 999999);

            DB::table('user_auth_codes')->insert([
                'user_id' => $user->id,
                'auth_code' => $authCode,
                'created_at' => now(),
            ]);

            Mail::send('emails.auth_code', ['code' => $authCode], function ($message) use ($user) {
                $message->to($user->email)->subject('Your Authentication Code');
            });

            return redirect()->route('auth.code');
        }

        return back()->withErrors(['email' => '提供された認証情報が記録と一致しません。']);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showCodeForm(){
        $email = Auth::user()->email;

        return view('auth.code', ['email' => $email]);
        }

        public function verifyCode(Request $request){
        $request->validate([
            'auth_code' => 'required|numeric|digits:6',
        ]);

        $user = Auth::user();
        $isValid = DB::table('user_auth_codes')
            ->where('user_id', $user->id)
            ->where('auth_code', $request->auth_code)
            ->where('created_at', '>', now()->subMinutes(10))
            ->exists();

        if ($isValid) {
            return redirect()->route('dashboard');
        } else {
            return back()->withErrors(['auth_code' => '認証コードが一致しないか、または期限が切れています。']);
        }
        }

        public function resendCode(Request $request){
        $user = $request->user();
        $code = rand(100000, 999999);
        Mail::to($user->email)->send(new AuthCodeMail($code));
        return back()->with('status', '認証コードを再送しました。');
    }
}
