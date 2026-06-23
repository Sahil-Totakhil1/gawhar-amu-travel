<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    /**
     * د ټولو منزلونو لیست ښکاره کوي.
     * یوازې هغه کاروونکي چې د 'destinations' واک لري.
     */
    public function index()
    {
        // چیک کړئ چې آیا کاروونکی د 'destinations' واک لري
        if (!Auth::user()->hasPermissionTo('destinations')) {
            abort(403, 'تاسو د منزلونو د لیدلو اجازه نه لرئ.');
        }

        $destinations = Destination::latest()->paginate(15);
        return view('admin.destinations.index', compact('destinations'));
    }

    /**
     * د نوي منزل د جوړولو فورم.
     */
    public function create()
    {
        // چیک کړئ چې آیا کاروونکی د 'destinations' واک لري
        if (!Auth::user()->hasPermissionTo('destinations')) {
            abort(403, 'تاسو د منزل د جوړولو اجازه نه لرئ.');
        }

        return view('admin.destinations.create');
    }

    /**
     * نوی منزل ذخیره کوي.
     */
    public function store(Request $request)
    {
        // چیک کړئ چې آیا کاروونکی د 'destinations' واک لري
        if (!Auth::user()->hasPermissionTo('destinations')) {
            abort(403, 'تاسو د منزل د جوړولو اجازه نه لرئ.');
        }

        $request->validate([
            'title_ps'       => 'required|string|max:255',
            'title_dr'       => 'nullable|string|max:255',
            'title_en'       => 'nullable|string|max:255',
            'description_ps' => 'nullable|string',
            'description_dr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('destinations', 'public');
        }

        Destination::create([
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
            'image'     => $imagePath,
            'is_active' => true,
        ]);

        return redirect()->route('admin.destinations.index')
            ->with('success', 'منزل په بریالیتوب سره اضافه شو.');
    }

    /**
     * د منزل د سمولو فورم.
     */
    public function edit(Destination $destination)
    {
        // چیک کړئ چې آیا کاروونکی د 'destinations' واک لري
        if (!Auth::user()->hasPermissionTo('destinations')) {
            abort(403, 'تاسو د منزل د سمولو اجازه نه لرئ.');
        }

        return view('admin.destinations.edit', compact('destination'));
    }

    /**
     * منزل تازه کوي.
     */
    public function update(Request $request, Destination $destination)
    {
        // چیک کړئ چې آیا کاروونکی د 'destinations' واک لري
        if (!Auth::user()->hasPermissionTo('destinations')) {
            abort(403, 'تاسو د منزل د تازه کولو اجازه نه لرئ.');
        }

        $request->validate([
            'title_ps'       => 'required|string|max:255',
            'title_dr'       => 'nullable|string|max:255',
            'title_en'       => 'nullable|string|max:255',
            'description_ps' => 'nullable|string',
            'description_dr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // د انځور بدلول که نوی وي
        if ($request->hasFile('image')) {
            if ($destination->image && Storage::disk('public')->exists($destination->image)) {
                Storage::disk('public')->delete($destination->image);
            }
            $imagePath = $request->file('image')->store('destinations', 'public');
        } else {
            $imagePath = $destination->image;
        }

        $destination->update([
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
            'image'     => $imagePath,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.destinations.index')
            ->with('success', 'منزل په بریالیتوب سره تازه شو.');
    }

    /**
     * منزل حذفوي.
     */
    public function destroy(Destination $destination)
    {
        // چیک کړئ چې آیا کاروونکی د 'destinations' واک لري
        if (!Auth::user()->hasPermissionTo('destinations')) {
            abort(403, 'تاسو د منزل د حذف کولو اجازه نه لرئ.');
        }

        if ($destination->image && Storage::disk('public')->exists($destination->image)) {
            Storage::disk('public')->delete($destination->image);
        }

        $destination->delete();
        return redirect()->route('admin.destinations.index')
            ->with('success', 'منزل په بریالیتوب سره حذف شو.');
    }
}