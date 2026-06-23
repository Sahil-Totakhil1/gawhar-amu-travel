<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Destination;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Package;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $logo = Setting::get('logo');
        $background = Setting::get('background');
        $companyName = Setting::get('company_name', []);
        $slogan = Setting::get('slogan', []);
        $aboutText = Setting::get('about_text', []);

        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        $packages = Package::where('is_active', true)->latest()->get();
        $ads = Ad::where('status', 'active')->latest()->take(6)->get();
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->get();
        $galleries = Gallery::where('is_active', true)->orderBy('sort_order')->get();
        $destinations = Destination::where('is_active', true)->latest()->get();
        $teamMembers = TeamMember::where('is_active', true)->orderBy('sort_order')->get();
        $testimonials = Testimonial::where('is_active', true)->latest()->get();

        return view('frontend.home', compact(
            'logo', 'background', 'companyName', 'slogan', 'aboutText',
            'services', 'packages', 'ads', 'faqs', 'galleries',
            'destinations', 'teamMembers', 'testimonials'
        ));
    }
}