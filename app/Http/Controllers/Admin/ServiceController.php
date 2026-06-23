<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * د ټولو خدماتو لیست ښکاره کوي.
     * یوازې هغه کاروونکي چې د 'services' واک لري.
     */
    public function index()
    {
        // چیک کړئ چې آیا کاروونکی د 'services' واک لري
        if (!Auth::user()->hasPermissionTo('services')) {
            abort(403, 'تاسو د خدماتو د لیدلو اجازه نه لرئ.');
        }

        $services = Service::orderBy('sort_order')->latest()->paginate(15);
        return view('admin.services.index', compact('services'));
    }

    /**
     * د نوي خدمت د جوړولو فورم.
     */
    public function create()
    {
        // چیک کړئ چې آیا کاروونکی د 'services' واک لري
        if (!Auth::user()->hasPermissionTo('services')) {
            abort(403, 'تاسو د خدمت د جوړولو اجازه نه لرئ.');
        }

        return view('admin.services.create');
    }

    /**
     * نوی خدمت ذخیره کوي.
     */
    public function store(Request $request)
    {
        // چیک کړئ چې آیا کاروونکی د 'services' واک لري
        if (!Auth::user()->hasPermissionTo('services')) {
            abort(403, 'تاسو د خدمت د جوړولو اجازه نه لرئ.');
        }

        $request->validate([
            'icon' => 'nullable|string|max:50',
            'title_ps' => 'required|string|max:255',
            'title_dr' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_ps' => 'nullable|string',
            'description_dr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        Service::create([
            'icon' => $request->icon,
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
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true,
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', 'خدمت په بریالیتوب سره جوړ شو.');
    }

    /**
     * د خدمت د سمولو فورم.
     */
    public function edit(Service $service)
    {
        // چیک کړئ چې آیا کاروونکی د 'services' واک لري
        if (!Auth::user()->hasPermissionTo('services')) {
            abort(403, 'تاسو د خدمت د سمولو اجازه نه لرئ.');
        }

        return view('admin.services.edit', compact('service'));
    }

    /**
     * خدمت تازه کوي.
     */
    public function update(Request $request, Service $service)
    {
        // چیک کړئ چې آیا کاروونکی د 'services' واک لري
        if (!Auth::user()->hasPermissionTo('services')) {
            abort(403, 'تاسو د خدمت د تازه کولو اجازه نه لرئ.');
        }

        $request->validate([
            'icon' => 'nullable|string|max:50',
            'title_ps' => 'required|string|max:255',
            'title_dr' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_ps' => 'nullable|string',
            'description_dr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $service->update([
            'icon' => $request->icon,
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
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', 'خدمت په بریالیتوب سره تازه شو.');
    }

    /**
     * خدمت حذفوي.
     */
    public function destroy(Service $service)
    {
        // چیک کړئ چې آیا کاروونکی د 'services' واک لري
        if (!Auth::user()->hasPermissionTo('services')) {
            abort(403, 'تاسو د خدمت د حذف کولو اجازه نه لرئ.');
        }

        $service->delete();
        return redirect()->route('admin.services.index')
            ->with('success', 'خدمت په بریالیتوب سره حذف شو.');
    }
}