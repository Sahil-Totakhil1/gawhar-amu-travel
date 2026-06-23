<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('sort_order')->latest()->paginate(15);
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_ps' => 'required|string|max:255',
            'question_dr' => 'nullable|string|max:255',
            'question_en' => 'nullable|string|max:255',
            'answer_ps'   => 'required|string',
            'answer_dr'   => 'nullable|string',
            'answer_en'   => 'nullable|string',
            'sort_order'  => 'nullable|integer',
        ]);

        Faq::create([
            'question' => [
                'ps' => $request->question_ps,
                'dr' => $request->question_dr ?? $request->question_ps,
                'en' => $request->question_en ?? $request->question_ps,
            ],
            'answer' => [
                'ps' => $request->answer_ps,
                'dr' => $request->answer_dr,
                'en' => $request->answer_en,
            ],
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => true,
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ په بریالیتوب سره جوړ شو.');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question_ps' => 'required|string|max:255',
            'question_dr' => 'nullable|string|max:255',
            'question_en' => 'nullable|string|max:255',
            'answer_ps'   => 'required|string',
            'answer_dr'   => 'nullable|string',
            'answer_en'   => 'nullable|string',
            'sort_order'  => 'nullable|integer',
        ]);

        $faq->update([
            'question' => [
                'ps' => $request->question_ps,
                'dr' => $request->question_dr ?? $request->question_ps,
                'en' => $request->question_en ?? $request->question_ps,
            ],
            'answer' => [
                'ps' => $request->answer_ps,
                'dr' => $request->answer_dr,
                'en' => $request->answer_en,
            ],
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ په بریالیتوب سره تازه شو.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ په بریالیتوب سره حذف شو.');
    }
}