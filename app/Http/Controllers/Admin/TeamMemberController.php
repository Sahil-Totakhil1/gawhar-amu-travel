<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    /**
     * د ټیم غړو لېست ښکاره کوي.
     */
    public function index()
    {
        $members = TeamMember::orderBy('sort_order')->latest()->paginate(15);
        return view('admin.team.index', compact('members'));
    }

    /**
     * د نوي غړي د جوړولو فورم.
     */
    public function create()
    {
        return view('admin.team.create');
    }

    /**
     * نوی غړی ذخیره کوي.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'position'        => 'required|string|max:255',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'whatsapp_number' => 'nullable|string|max:30',
            'whatsapp_qr_code'=> 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            'sort_order'      => 'nullable|integer',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('team', 'public');
        }

        $qrPath = null;
        if ($request->hasFile('whatsapp_qr_code')) {
            $qrPath = $request->file('whatsapp_qr_code')->store('team/qrcodes', 'public');
        }

        TeamMember::create([
            'name'            => $request->name,
            'position'        => $request->position,
            'image'           => $imagePath,
            'whatsapp_number' => $request->whatsapp_number,
            'whatsapp_qr_code'=> $qrPath,
            'sort_order'      => $request->sort_order ?? 0,
            'is_active'       => true,
        ]);

        return redirect()->route('admin.team.index')
            ->with('success', 'د ټیم غړی په بریالیتوب سره اضافه شو.');
    }

    /**
     * د غړي د سمولو فورم.
     */
    public function edit(TeamMember $team)
    {
        return view('admin.team.edit', compact('team'));
    }

    /**
     * غړی تازه کوي.
     */
    public function update(Request $request, TeamMember $team)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'position'        => 'required|string|max:255',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'whatsapp_number' => 'nullable|string|max:30',
            'whatsapp_qr_code'=> 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            'sort_order'      => 'nullable|integer',
        ]);

        // د انځور بدلول
        if ($request->hasFile('image')) {
            if ($team->image && Storage::disk('public')->exists($team->image)) {
                Storage::disk('public')->delete($team->image);
            }
            $imagePath = $request->file('image')->store('team', 'public');
        } else {
            $imagePath = $team->image;
        }

        // د QR کوډ بدلول
        if ($request->hasFile('whatsapp_qr_code')) {
            if ($team->whatsapp_qr_code && Storage::disk('public')->exists($team->whatsapp_qr_code)) {
                Storage::disk('public')->delete($team->whatsapp_qr_code);
            }
            $qrPath = $request->file('whatsapp_qr_code')->store('team/qrcodes', 'public');
        } else {
            $qrPath = $team->whatsapp_qr_code;
        }

        $team->update([
            'name'            => $request->name,
            'position'        => $request->position,
            'image'           => $imagePath,
            'whatsapp_number' => $request->whatsapp_number,
            'whatsapp_qr_code'=> $qrPath,
            'sort_order'      => $request->sort_order ?? 0,
            'is_active'       => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.team.index')
            ->with('success', 'د ټیم غړی په بریالیتوب سره تازه شو.');
    }

    /**
     * غړی حذفوي.
     */
    public function destroy(TeamMember $team)
    {
        if ($team->image && Storage::disk('public')->exists($team->image)) {
            Storage::disk('public')->delete($team->image);
        }
        if ($team->whatsapp_qr_code && Storage::disk('public')->exists($team->whatsapp_qr_code)) {
            Storage::disk('public')->delete($team->whatsapp_qr_code);
        }

        $team->delete();
        return redirect()->route('admin.team.index')
            ->with('success', 'د ټیم غړی په بریالیتوب سره حذف شو.');
    }
}