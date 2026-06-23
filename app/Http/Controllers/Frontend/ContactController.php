<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * د تماس فورم ښکاره کوي.
     */
    public function showForm()
    {
        return view('frontend.contact');
    }

    /**
     * د تماس فورم څخه پیغام ذخیره کوي.
     */
    public function submitForm(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'phone'   => 'nullable|string|max:30',
            'message' => 'required|string|min:10',
        ]);

        ContactMessage::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'message' => $request->message,
        ]);

        return back()->with('success', 'پیغام مو په بریالیتوب سره واستول شو. مننه!');
    }
}