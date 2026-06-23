<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    /**
     * د ټولو فعالو اعلانونو لېست ښکاره کوي.
     */
    public function index(Request $request)
    {
        $query = Ad::where('status', 'active')->with('user')->latest();

        // د کټګورۍ فلټر (اختیاري)
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $ads = $query->paginate(12);
        $categories = ['visa', 'tour', 'hajj', 'ticket', 'residence', 'other']; // د فلټر لپاره

        return view('frontend.ads.index', compact('ads', 'categories'));
    }

    /**
     * یو ځانګړی اعلان د جزئیاتو سره ښکاره کوي.
     */
    public function show(Ad $ad)
    {
        // د لیدو شمېر زیاتول
        $ad->increment('views');
        return view('frontend.ads.show', compact('ad'));
    }
}