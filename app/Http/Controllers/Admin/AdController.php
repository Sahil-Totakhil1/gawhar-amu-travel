<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    /**
     * ټول اعلانونه ښکاره کوي.
     * Admin ټول ویني، Staff یوازې خپل (که د 'ads' واک ولري).
     */
    public function index()
    {
        // چیک کړئ چې آیا کاروونکی د 'ads' واک لري
        if (!Auth::user()->hasPermissionTo('ads')) {
            abort(403, 'تاسو د اعلاناتو د لیدلو اجازه نه لرئ.');
        }

        if (Auth::user()->role === 'admin') {
            $ads = Ad::with('user')->latest()->paginate(15);
        } else {
            // Staff یوازې خپل اعلانونه ویني
            $ads = Ad::where('user_id', Auth::id())->with('user')->latest()->paginate(15);
        }
        return view('admin.ads.index', compact('ads'));
    }

    /**
     * د نوي اعلان جوړولو فورم.
     */
    public function create()
    {
        // چیک کړئ چې آیا کاروونکی د 'ads' واک لري
        if (!Auth::user()->hasPermissionTo('ads')) {
            abort(403, 'تاسو د اعلان د جوړولو اجازه نه لرئ.');
        }
        return view('admin.ads.create');
    }

    /**
     * نوی اعلان ذخیره کوي.
     */
    public function store(Request $request)
    {
        // چیک کړئ چې آیا کاروونکی د 'ads' واک لري
        if (!Auth::user()->hasPermissionTo('ads')) {
            abort(403, 'تاسو د اعلان د جوړولو اجازه نه لرئ.');
        }

        $request->validate([
            'title_ps' => 'required|string|max:255',
            'title_dr' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_ps' => 'nullable|string',
            'description_dr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'category' => 'required|string',
            'price' => 'nullable|numeric',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'video_url' => 'nullable|url|max:255',
        ]);

        // د انځور اپلوډ
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('ads', 'public');
        }

        Ad::create([
            'user_id' => Auth::id(),
            'title' => [
                'ps' => $request->title_ps,
                'dr' => $request->title_dr ?? $request->title_ps,
                'en' => $request->title_en ?? $request->title_ps,
            ],
            'description' => [
                'ps' => $request->description_ps,
                'dr' => $request->description_dr,
                'en' => $request->description_en,
            ],
            'category' => $request->category,
            'price' => $request->price,
            'location' => $request->location,
            'image' => $imagePath,
            'video_url' => $request->video_url,
            'status' => 'active',
            'views' => 0,
        ]);

        return redirect()->route('admin.ads.index')->with('success', 'اعلان په بریالیتوب سره جوړ شو.');
    }

    /**
     * یو ځانګړی اعلان ښکاره کوي.
     */
    public function show(Ad $ad)
    {
        // چیک کړئ چې آیا کاروونکی د 'ads' واک لري
        if (!Auth::user()->hasPermissionTo('ads')) {
            abort(403, 'تاسو د اعلاناتو د لیدلو اجازه نه لرئ.');
        }
        $ad->increment('views');
        return view('admin.ads.show', compact('ad'));
    }

    /**
     * د اعلان د سمولو فورم.
     */
    public function edit(Ad $ad)
    {
        // لومړی چیک کړئ چې آیا کاروونکی د 'ads' واک لري
        if (!Auth::user()->hasPermissionTo('ads')) {
            abort(403, 'تاسو د اعلاناتو د سمولو اجازه نه لرئ.');
        }

        // بیا چیک کړئ چې آیا دا خپل اعلان دی (که Admin نه وي)
        if (Auth::user()->role !== 'admin' && $ad->user_id !== Auth::id()) {
            abort(403, 'تاسو د دې اعلان د سمولو اجازه نه لرئ.');
        }

        return view('admin.ads.edit', compact('ad'));
    }

    /**
     * اعلان تازه کوي.
     */
    public function update(Request $request, Ad $ad)
    {
        // لومړی چیک کړئ چې آیا کاروونکی د 'ads' واک لري
        if (!Auth::user()->hasPermissionTo('ads')) {
            abort(403, 'تاسو د اعلاناتو د تازه کولو اجازه نه لرئ.');
        }

        // بیا چیک کړئ چې آیا دا خپل اعلان دی (که Admin نه وي)
        if (Auth::user()->role !== 'admin' && $ad->user_id !== Auth::id()) {
            abort(403, 'تاسو د دې اعلان د تازه کولو اجازه نه لرئ.');
        }

        $request->validate([
            'title_ps' => 'required|string|max:255',
            'title_dr' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_ps' => 'nullable|string',
            'description_dr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'category' => 'required|string',
            'price' => 'nullable|numeric',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'video_url' => 'nullable|url|max:255',
        ]);

        // د انځور اپلوډ که نوی وي
        if ($request->hasFile('image')) {
            // پخوانی انځور ړنګول
            if ($ad->image) {
                Storage::disk('public')->delete($ad->image);
            }
            $imagePath = $request->file('image')->store('ads', 'public');
        } else {
            $imagePath = $ad->image;
        }

        $ad->update([
            'title' => [
                'ps' => $request->title_ps,
                'dr' => $request->title_dr ?? $request->title_ps,
                'en' => $request->title_en ?? $request->title_ps,
            ],
            'description' => [
                'ps' => $request->description_ps,
                'dr' => $request->description_dr,
                'en' => $request->description_en,
            ],
            'category' => $request->category,
            'price' => $request->price,
            'location' => $request->location,
            'image' => $imagePath,
            'video_url' => $request->video_url,
        ]);

        return redirect()->route('admin.ads.index')->with('success', 'اعلان په بریالیتوب سره تازه شو.');
    }

    /**
     * اعلان حذفوي.
     */
    public function destroy(Ad $ad)
    {
        // لومړی چیک کړئ چې آیا کاروونکی د 'ads' واک لري
        if (!Auth::user()->hasPermissionTo('ads')) {
            abort(403, 'تاسو د اعلاناتو د حذف کولو اجازه نه لرئ.');
        }

        // بیا چیک کړئ چې آیا دا خپل اعلان دی (که Admin نه وي)
        if (Auth::user()->role !== 'admin' && $ad->user_id !== Auth::id()) {
            abort(403, 'تاسو د دې اعلان د حذف کولو اجازه نه لرئ.');
        }

        // انځور هم حذفول
        if ($ad->image) {
            Storage::disk('public')->delete($ad->image);
        }

        $ad->delete();
        return redirect()->route('admin.ads.index')->with('success', 'اعلان په بریالیتوب سره حذف شو.');
    }
}