<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * د ټولو پیغامونو لېست.
     */
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(20);
        return view('admin.messages.index', compact('messages'));
    }

    /**
     * د یوه ځانګړي پیغام تفصیل.
     */
    public function show(ContactMessage $message)
    {
        // که پیغام لوستل شوی نه وي، لوستل شوی یې کړه
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }
        return view('admin.messages.show', compact('message'));
    }

    /**
     * پیغام حذف کول.
     */
    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')
            ->with('success', 'پیغام په بریالیتوب سره حذف شو.');
    }
}