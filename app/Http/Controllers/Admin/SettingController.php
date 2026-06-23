<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $logo = Setting::get('logo');
        $background = Setting::get('background');
        $companyName = Setting::get('company_name', []);
        $slogan = Setting::get('slogan', []);
        $aboutText = Setting::get('about_text', []);
        $socialFacebook = Setting::get('social_facebook');
        $socialInstagram = Setting::get('social_instagram');
        $socialWhatsapp = Setting::get('social_whatsapp');
        $contactPhone = Setting::get('contact_phone');
        $contactWhatsapp = Setting::get('contact_whatsapp');
        $contactEmail = Setting::get('contact_email');
        $contactAddress = Setting::get('contact_address');

        return view('admin.settings.index', compact(
            'logo', 'background', 'companyName', 'slogan', 'aboutText',
            'socialFacebook', 'socialInstagram', 'socialWhatsapp',
            'contactPhone', 'contactWhatsapp', 'contactEmail', 'contactAddress'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'logo'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'background'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'company_name_ps' => 'nullable|string|max:255',
            'company_name_dr' => 'nullable|string|max:255',
            'company_name_en' => 'nullable|string|max:255',
            'slogan_ps'       => 'nullable|string|max:500',
            'slogan_dr'       => 'nullable|string|max:500',
            'slogan_en'       => 'nullable|string|max:500',
            'about_text_ps'   => 'nullable|string',
            'about_text_dr'   => 'nullable|string',
            'about_text_en'   => 'nullable|string',
            'social_facebook' => 'nullable|url|max:255',
            'social_instagram'=> 'nullable|url|max:255',
            'social_whatsapp' => 'nullable|string|max:30',
            'contact_phone'   => 'nullable|string|max:30',
            'contact_whatsapp'=> 'nullable|string|max:30',
            'contact_email'   => 'nullable|email|max:255',
            'contact_address' => 'nullable|string|max:500',
        ]);

        // د لوګو اپلوډ
        if ($request->hasFile('logo')) {
            $oldLogo = Setting::get('logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $logoPath = $request->file('logo')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'logo'], ['value' => $logoPath]);
        }

        // د بکګراونډ اپلوډ
        if ($request->hasFile('background')) {
            $oldBg = Setting::get('background');
            if ($oldBg && Storage::disk('public')->exists($oldBg)) {
                Storage::disk('public')->delete($oldBg);
            }
            $bgPath = $request->file('background')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'background'], ['value' => $bgPath]);
        }

        // د شرکت نوم
        if ($request->has('company_name_ps')) {
            $value = ['ps' => $request->company_name_ps, 'dr' => $request->company_name_dr, 'en' => $request->company_name_en];
            Setting::updateOrCreate(['key' => 'company_name'], ['value' => $value]);
        }

        // شعار
        if ($request->has('slogan_ps')) {
            $value = ['ps' => $request->slogan_ps, 'dr' => $request->slogan_dr, 'en' => $request->slogan_en];
            Setting::updateOrCreate(['key' => 'slogan'], ['value' => $value]);
        }

        // زموږ په اړه
        if ($request->has('about_text_ps')) {
            $value = ['ps' => $request->about_text_ps, 'dr' => $request->about_text_dr, 'en' => $request->about_text_en];
            Setting::updateOrCreate(['key' => 'about_text'], ['value' => $value]);
        }

        // سوشل میډیا او اړیکې (ساده متنونه)
        $simpleKeys = [
            'social_facebook', 'social_instagram', 'social_whatsapp',
            'contact_phone', 'contact_whatsapp', 'contact_email', 'contact_address',
        ];
        foreach ($simpleKeys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->$key]);
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'تنظیمات په بریالیتوب سره تازه شول.');
    }
}