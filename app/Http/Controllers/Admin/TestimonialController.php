<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * د ټولو نظرونو لېست.
     */
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * د نوي نظر د جوړولو فورم.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * نوی نظر ذخیره کوي.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'comment' => 'required|string|min:10',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'rating'  => 'required|integer|min:1|max:5',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create([
            'name'    => $request->name,
            'comment' => $request->comment,
            'image'   => $imagePath,
            'rating'  => $request->rating,
            'is_active' => true,
        ]);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'نظر په بریالیتوب سره اضافه شو.');
    }

    /**
     * د نظر د سمولو فورم.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * نظر تازه کوي.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'comment' => 'required|string|min:10',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'rating'  => 'required|integer|min:1|max:5',
        ]);

        // د انځور بدلول
        if ($request->hasFile('image')) {
            if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
                Storage::disk('public')->delete($testimonial->image);
            }
            $imagePath = $request->file('image')->store('testimonials', 'public');
        } else {
            $imagePath = $testimonial->image;
        }

        $testimonial->update([
            'name'    => $request->name,
            'comment' => $request->comment,
            'image'   => $imagePath,
            'rating'  => $request->rating,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'نظر په بریالیتوب سره تازه شو.');
    }

    /**
     * نظر حذفوي.
     */
    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
            Storage::disk('public')->delete($testimonial->image);
        }

        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')
            ->with('success', 'نظر په بریالیتوب سره حذف شو.');
    }
}