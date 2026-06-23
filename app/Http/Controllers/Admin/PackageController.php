<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    /**
     * ټول پکېجونه ښکاره کوي.
     * یوازې هغه کاروونکي چې د 'packages' واک لري.
     */
    public function index()
    {
        // چیک کړئ چې آیا کاروونکی د 'packages' واک لري
        if (!Auth::user()->hasPermissionTo('packages')) {
            abort(403, 'تاسو د پکېجونو د لیدلو اجازه نه لرئ.');
        }

        $packages = Package::latest()->paginate(15);
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * د نوي پکېج د جوړولو فورم.
     */
    public function create()
    {
        // چیک کړئ چې آیا کاروونکی د 'packages' واک لري
        if (!Auth::user()->hasPermissionTo('packages')) {
            abort(403, 'تاسو د پکېج د جوړولو اجازه نه لرئ.');
        }

        return view('admin.packages.create');
    }

    /**
     * نوی پکېج ذخیره کوي.
     */
    public function store(Request $request)
    {
        // چیک کړئ چې آیا کاروونکی د 'packages' واک لري
        if (!Auth::user()->hasPermissionTo('packages')) {
            abort(403, 'تاسو د پکېج د جوړولو اجازه نه لرئ.');
        }

        $request->validate([
            'title_ps'        => 'required|string|max:255',
            'title_dr'        => 'nullable|string|max:255',
            'title_en'        => 'nullable|string|max:255',
            'category'        => 'required|string',
            'price'           => 'nullable|numeric',
            'destination'     => 'nullable|string|max:255',
            'duration'        => 'nullable|string|max:100',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description_ps'  => 'nullable|string',
            'description_dr'  => 'nullable|string',
            'description_en'  => 'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('packages', 'public');
        }

        Package::create([
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
            'category'    => $request->category,
            'price'       => $request->price,
            'destination' => $request->destination,
            'duration'    => $request->duration,
            'image'       => $imagePath,
        ]);

        return redirect()->route('admin.packages.index')->with('success', 'پکېج په بریالیتوب سره جوړ شو.');
    }

    /**
     * د پکېج د سمولو فورم.
     */
    public function edit(Package $package)
    {
        // چیک کړئ چې آیا کاروونکی د 'packages' واک لري
        if (!Auth::user()->hasPermissionTo('packages')) {
            abort(403, 'تاسو د پکېج د سمولو اجازه نه لرئ.');
        }

        return view('admin.packages.edit', compact('package'));
    }

    /**
     * پکېج تازه کوي.
     */
    public function update(Request $request, Package $package)
    {
        // چیک کړئ چې آیا کاروونکی د 'packages' واک لري
        if (!Auth::user()->hasPermissionTo('packages')) {
            abort(403, 'تاسو د پکېج د تازه کولو اجازه نه لرئ.');
        }

        $request->validate([
            'title_ps'        => 'required|string|max:255',
            'title_dr'        => 'nullable|string|max:255',
            'title_en'        => 'nullable|string|max:255',
            'category'        => 'required|string',
            'price'           => 'nullable|numeric',
            'destination'     => 'nullable|string|max:255',
            'duration'        => 'nullable|string|max:100',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description_ps'  => 'nullable|string',
            'description_dr'  => 'nullable|string',
            'description_en'  => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($package->image) {
                Storage::disk('public')->delete($package->image);
            }
            $imagePath = $request->file('image')->store('packages', 'public');
        } else {
            $imagePath = $package->image;
        }

        $package->update([
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
            'category'    => $request->category,
            'price'       => $request->price,
            'destination' => $request->destination,
            'duration'    => $request->duration,
            'image'       => $imagePath,
        ]);

        return redirect()->route('admin.packages.index')->with('success', 'پکېج په بریالیتوب سره تازه شو.');
    }

    /**
     * پکېج حذفوي.
     */
    public function destroy(Package $package)
    {
        // چیک کړئ چې آیا کاروونکی د 'packages' واک لري
        if (!Auth::user()->hasPermissionTo('packages')) {
            abort(403, 'تاسو د پکېج د حذف کولو اجازه نه لرئ.');
        }

        if ($package->image) {
            Storage::disk('public')->delete($package->image);
        }
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'پکېج په بریالیتوب سره حذف شو.');
    }
}