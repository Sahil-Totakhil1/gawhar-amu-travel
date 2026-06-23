<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * ټول کاروونکي ښکاره کوي (یوازې Admin).
     */
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'تاسو دې برخې ته د لاسرسي اجازه نه لرئ.');
        }
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * د نوي کاروونکي (Staff) د جوړولو فورم.
     */
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('admin.users.create');
    }

    /**
     * نوی کاروونکی ذخیره کوي.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        // د تلیفون شمېره پاکول — یوازې عددونه ساتل
        $cleanedPhone = $request->has('phone') && $request->phone
            ? preg_replace('/[^0-9]/', '', $request->phone)
            : null;

        $request->merge(['phone' => $cleanedPhone]);

        $request->validate([
            'name'       => 'required|string|max:255',
            'username'   => 'required|string|max:100|unique:users,username',
            // قوي پاسورډ: لږ تر لږه ۸ توري، غټ حرف، کوچنی حرف، نمبر، ځانګړی سمبول
            'password'   => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
            'role'       => 'required|in:admin,staff',
            'permission' => 'nullable|string|max:255',
            'email'      => 'nullable|email|unique:users,email',
            'phone'      => 'nullable|string|max:30|unique:users,phone',  // اضافه شوی
        ]);

        User::create([
            'name'       => $request->name,
            'username'   => $request->username,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            'permission' => $request->role === 'staff' ? $request->permission : null,
            'is_active'  => true,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'کاروونکی په بریالیتوب سره جوړ شو.');
    }

    /**
     * د کاروونکي د سمولو فورم.
     */
    public function edit(User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('admin.users.edit', compact('user'));
    }

    /**
     * کاروونکی تازه کوي.
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        // د تلیفون شمېره پاکول
        $cleanedPhone = $request->has('phone') && $request->phone
            ? preg_replace('/[^0-9]/', '', $request->phone)
            : null;

        $request->merge(['phone' => $cleanedPhone]);

        $request->validate([
            'name'       => 'required|string|max:255',
            'username'   => 'required|string|max:100|unique:users,username,' . $user->id,
            'password'   => [
                'nullable',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
            'role'       => 'required|in:admin,staff',
            'permission' => 'nullable|string|max:255',
            'email'      => 'nullable|email|unique:users,email,' . $user->id,
            'phone'      => 'nullable|string|max:30|unique:users,phone,' . $user->id,  // اضافه شوی
            'is_active'  => 'boolean',
        ]);

        $data = [
            'name'       => $request->name,
            'username'   => $request->username,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'role'       => $request->role,
            'permission' => $request->role === 'staff' ? $request->permission : null,
            'is_active'  => $request->boolean('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'کاروونکی په بریالیتوب سره تازه شو.');
    }

    /**
     * کاروونکی حذفوي.
     */
    public function destroy(User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'تاسو خپل ځان حذف کولی نه شئ.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'کاروونکی په بریالیتوب سره حذف شو.');
    }

    /**
     * د پاسورډ بدلولو فورم (د Admin او Staff دواړو لپاره).
     */
    public function changePasswordForm()
    {
        return view('admin.users.change-password');
    }

    /**
     * پاسورډ بدلوي.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'اوسنی پاسورډ سم نه دی.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'پاسورډ په بریالیتوب سره بدل شو.');
    }
}