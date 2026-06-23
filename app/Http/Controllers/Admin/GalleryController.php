<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy('sort_order')->latest()->paginate(15);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'         => 'required|in:image,video',
            'image'        => 'required_if:type,image|image|mimes:jpeg,png,jpg,webp|max:2048',
            'video_url'    => 'nullable|url|max:255', // دلته 'nullable' وګرځول شو
            'caption_ps'   => 'nullable|string|max:255',
            'caption_dr'   => 'nullable|string|max:255',
            'caption_en'   => 'nullable|string|max:255',
            'sort_order'   => 'nullable|integer',
        ]);

        if ($request->type === 'image' && $request->hasFile('image')) {
            $url = $request->file('image')->store('galleries', 'public');
        } else {
            $url = $request->video_url; // که ویډیو وي، URL ذخیره کوي
        }

        Gallery::create([
            'type' => $request->type,
            'url'  => $url,
            'caption' => [
                'ps' => $request->caption_ps,
                'dr' => $request->caption_dr,
                'en' => $request->caption_en,
            ],
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => true,
        ]);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'ګالري آیتم په بریالیتوب سره جوړ شو.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'type'         => 'required|in:image,video',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'video_url'    => 'nullable|url|max:255',
            'caption_ps'   => 'nullable|string|max:255',
            'caption_dr'   => 'nullable|string|max:255',
            'caption_en'   => 'nullable|string|max:255',
            'sort_order'   => 'nullable|integer',
        ]);

        // منطق سمول
        if ($request->type === 'image') {
            if ($request->hasFile('image')) {
                if ($gallery->url && Storage::disk('public')->exists($gallery->url)) {
                    Storage::disk('public')->delete($gallery->url);
                }
                $url = $request->file('image')->store('galleries', 'public');
            } else {
                $url = $gallery->url;
            }
        } else {
            $url = $request->video_url ?: $gallery->url;
        }

        $gallery->update([
            'type' => $request->type,
            'url'  => $url,
            'caption' => [
                'ps' => $request->caption_ps,
                'dr' => $request->caption_dr,
                'en' => $request->caption_en,
            ],
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'ګالري آیتم په بریالیتوب سره تازه شو.');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->type === 'image' && $gallery->url && Storage::disk('public')->exists($gallery->url)) {
            Storage::disk('public')->delete($gallery->url);
        }

        $gallery->delete();
        return redirect()->route('admin.galleries.index')
            ->with('success', 'ګالري آیتم په بریالیتوب سره حذف شو.');
    }
}