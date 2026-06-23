@extends('layouts.admin')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-bold mb-4" style="color: var(--body-text);">@lang('messages.dashboard')</h1>
    <p class="mb-8" style="color: var(--card-text);">@lang('messages.welcome_user', ['name' => Auth::user()->name, 'role' => Auth::user()->role])</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- اعلانونه - یوازې هغو ته چې د ads واک لري --}}
        @if(auth()->user()->hasPermissionTo('ads'))
            <a href="{{ route('admin.ads.index') }}" class="block section-card hover:scale-105 transition duration-300">
                <h2 class="text-xl font-bold mb-2" style="color: var(--primary);">📋 @lang('messages.ads')</h2>
                <p style="color: var(--card-text);">@lang('messages.ads_desc')</p>
            </a>
        @endif

        {{-- خدمات - یوازې هغو ته چې د services واک لري --}}
        @if(auth()->user()->hasPermissionTo('services'))
            <a href="{{ route('admin.services.index') }}" class="block section-card hover:scale-105 transition duration-300">
                <h2 class="text-xl font-bold mb-2" style="color: #0d9488;">🛠️ @lang('messages.services')</h2>
                <p style="color: var(--card-text);">@lang('messages.services_desc')</p>
            </a>
        @endif

        {{-- پکېجونه - یوازې هغو ته چې د packages واک لري --}}
        @if(auth()->user()->hasPermissionTo('packages'))
            <a href="{{ route('admin.packages.index') }}" class="block section-card hover:scale-105 transition duration-300">
                <h2 class="text-xl font-bold mb-2" style="color: #ea580c;">📦 @lang('messages.packages')</h2>
                <p style="color: var(--card-text);">@lang('messages.packages_desc')</p>
            </a>
        @endif

        {{-- منزلونه - یوازې هغو ته چې د destinations واک لري --}}
        @if(auth()->user()->hasPermissionTo('destinations'))
            <a href="{{ route('admin.destinations.index') }}" class="block section-card hover:scale-105 transition duration-300">
                <h2 class="text-xl font-bold mb-2" style="color: #65a30d;">🌍 @lang('messages.destinations')</h2>
                <p style="color: var(--card-text);">@lang('messages.destinations_desc')</p>
            </a>
        @endif

        {{-- ټیم غړي - یوازې Admin یا هغو ته چې د team واک لري --}}
        @if(auth()->user()->role === 'admin' || auth()->user()->hasPermissionTo('team'))
            <a href="{{ route('admin.team.index') }}" class="block section-card hover:scale-105 transition duration-300">
                <h2 class="text-xl font-bold mb-2" style="color: #d97706;">👨‍💼 @lang('messages.team')</h2>
                <p style="color: var(--card-text);">@lang('messages.team_desc')</p>
            </a>
        @endif

        {{-- د نظرونو مدیریت - یوازې Admin یا هغو ته چې د testimonials واک لري --}}
        @if(auth()->user()->role === 'admin' || auth()->user()->hasPermissionTo('testimonials'))
            <a href="{{ route('admin.testimonials.index') }}" class="block section-card hover:scale-105 transition duration-300">
                <h2 class="text-xl font-bold mb-2" style="color: #e11d48;">🗣️ @lang('messages.testimonials')</h2>
                <p style="color: var(--card-text);">@lang('messages.testimonials_desc')</p>
            </a>
        @endif

        {{-- FAQ - یوازې Admin یا هغو ته چې د faqs واک لري --}}
        @if(auth()->user()->role === 'admin' || auth()->user()->hasPermissionTo('faqs'))
            <a href="{{ route('admin.faqs.index') }}" class="block section-card hover:scale-105 transition duration-300">
                <h2 class="text-xl font-bold mb-2" style="color: #0891b2;">❓ @lang('messages.faq')</h2>
                <p style="color: var(--card-text);">@lang('messages.faq_desc')</p>
            </a>
        @endif

        {{-- ګالري - یوازې Admin یا هغو ته چې د gallery واک لري --}}
        @if(auth()->user()->role === 'admin' || auth()->user()->hasPermissionTo('gallery'))
            <a href="{{ route('admin.galleries.index') }}" class="block section-card hover:scale-105 transition duration-300">
                <h2 class="text-xl font-bold mb-2" style="color: #db2777;">🖼️ @lang('messages.gallery')</h2>
                <p style="color: var(--card-text);">@lang('messages.gallery_desc')</p>
            </a>
        @endif

        {{-- پیغامونه - یوازې Admin یا هغو ته چې د messages واک لري --}}
        @if(auth()->user()->role === 'admin' || auth()->user()->hasPermissionTo('messages'))
            <a href="{{ route('admin.messages.index') }}" class="block section-card hover:scale-105 transition duration-300">
                <h2 class="text-xl font-bold mb-2" style="color: #4f46e5;">📩 @lang('messages.messages')</h2>
                <p style="color: var(--card-text);">@lang('messages.messages_desc')</p>
            </a>
        @endif

        {{-- د کاروونکو مدیریت (یوازې Admin) --}}
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.users.index') }}" class="block section-card hover:scale-105 transition duration-300">
                <h2 class="text-xl font-bold mb-2" style="color: #7c3aed;">👥 @lang('messages.users')</h2>
                <p style="color: var(--card-text);">@lang('messages.users_desc')</p>
            </a>
        @endif

        {{-- د شرکت تنظیمات (یوازې Admin) --}}
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.settings.index') }}" class="block section-card hover:scale-105 transition duration-300">
                <h2 class="text-xl font-bold mb-2" style="color: #16a34a;">⚙️ @lang('messages.settings')</h2>
                <p style="color: var(--card-text);">@lang('messages.settings_desc')</p>
            </a>
        @endif

        {{-- پاسورډ بدلول (ټولو ته ښکاره) --}}
        <a href="{{ route('change.password.form') }}" class="block section-card hover:scale-105 transition duration-300">
            <h2 class="text-xl font-bold mb-2" style="color: #ca8a04;">🔒 @lang('messages.change_password')</h2>
            <p style="color: var(--card-text);">@lang('messages.change_password_desc')</p>
        </a>
    </div>
</div>
@endsection