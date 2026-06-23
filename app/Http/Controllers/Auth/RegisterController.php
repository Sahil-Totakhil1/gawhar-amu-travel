<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * د ثبت نوم فورم ښکاره کوي.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * د ثبت نوم پروسه ترسره کوي.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'user', // هر نوی کاروونکی په ډیفالټ 'user' رول لري
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}