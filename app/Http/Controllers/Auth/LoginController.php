<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * د ننوتلو فورم ښکاره کوي.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * د ننوتلو پروسه ترسره کوي.
     * د ایمیل، یوزرنیم یا تلیفون نمبر په مرسته ننوتل.
     * تلیفون یوازې انګلیسي عددونه مني.
     */
    public function login(Request $request)
    {
        // د نوي "login" فیلډ تایید
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        // معلومول چې کاروونکي څه ورکړي: ایمیل، یوزرنیم، که نمبر
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $login, 'password' => $password];
        } else {
            // د تلیفون شمېره پاکول — یوازې انګلیسي عددونه (0-9) ساتل
            $cleanedLogin = preg_replace('/[^0-9]/', '', $login);
            // که د پاکولو وروسته لږ تر لږه ۷ عددونه پاتې شي
            // او یوازې خالص انګلیسي عددونه وي (د پښتو/دري عددونه نه)
            if (strlen($cleanedLogin) >= 7 && ctype_digit($cleanedLogin)) {
                $credentials = ['phone' => $cleanedLogin, 'password' => $password];
            } else {
                $credentials = ['username' => $login, 'password' => $password];
            }
        }

        // د ننوتلو هڅه
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // د تېروتنې پیغام
        return back()->withErrors([
            'login' => 'د ننوتلو معلومات سم نه دي. مهرباني وکړئ بیا هڅه وکړئ.',
        ])->onlyInput('login');
    }

    /**
     * د وتلو پروسه ترسره کوي.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}