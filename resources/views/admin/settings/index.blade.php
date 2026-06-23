@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold mb-8 dark:text-white text-gray-800">@lang('messages.settings_title')</h1>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8">
        @csrf

        {{-- ========== لوګو ========== --}}
        <div class="mb-8 border-b dark:border-gray-700 pb-8">
            <h2 class="text-xl font-bold dark:text-white text-gray-700 mb-4">@lang('messages.logo')</h2>
            @if($logo)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-20 object-contain border dark:border-gray-600 rounded">
                </div>
            @endif
            <input type="file" name="logo" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>

        {{-- ========== بکګراونډ انځور ========== --}}
        <div class="mb-8 border-b dark:border-gray-700 pb-8">
            <h2 class="text-xl font-bold dark:text-white text-gray-700 mb-4">@lang('messages.background_image')</h2>
            @if($background)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $background) }}" alt="Background" class="h-32 object-cover border dark:border-gray-600 rounded">
                </div>
            @endif
            <input type="file" name="background" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>

        {{-- ========== د شرکت نوم ========== --}}
        <div class="mb-8 border-b dark:border-gray-700 pb-8">
            <h2 class="text-xl font-bold dark:text-white text-gray-700 mb-4">@lang('messages.company_name')</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 mb-1">@lang('messages.lang_ps')</label>
                    <input type="text" name="company_name_ps" value="{{ $companyName['ps'] ?? '' }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
                </div>
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 mb-1">@lang('messages.lang_dr')</label>
                    <input type="text" name="company_name_dr" value="{{ $companyName['dr'] ?? '' }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
                </div>
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 mb-1">@lang('messages.lang_en')</label>
                    <input type="text" name="company_name_en" value="{{ $companyName['en'] ?? '' }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
                </div>
            </div>
        </div>

        {{-- ========== شعار ========== --}}
        <div class="mb-8 border-b dark:border-gray-700 pb-8">
            <h2 class="text-xl font-bold dark:text-white text-gray-700 mb-4">@lang('messages.slogan')</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 mb-1">@lang('messages.lang_ps')</label>
                    <input type="text" name="slogan_ps" value="{{ $slogan['ps'] ?? '' }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
                </div>
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 mb-1">@lang('messages.lang_dr')</label>
                    <input type="text" name="slogan_dr" value="{{ $slogan['dr'] ?? '' }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
                </div>
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 mb-1">@lang('messages.lang_en')</label>
                    <input type="text" name="slogan_en" value="{{ $slogan['en'] ?? '' }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
                </div>
            </div>
        </div>

        {{-- ========== زموږ په اړه ========== --}}
        <div class="mb-8 border-b dark:border-gray-700 pb-8">
            <h2 class="text-xl font-bold dark:text-white text-gray-700 mb-4">@lang('messages.about')</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 mb-1">@lang('messages.lang_ps')</label>
                    <textarea name="about_text_ps" rows="4" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">{{ $aboutText['ps'] ?? '' }}</textarea>
                </div>
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 mb-1">@lang('messages.lang_dr')</label>
                    <textarea name="about_text_dr" rows="4" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">{{ $aboutText['dr'] ?? '' }}</textarea>
                </div>
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 mb-1">@lang('messages.lang_en')</label>
                    <textarea name="about_text_en" rows="4" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">{{ $aboutText['en'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        {{-- ========== سوشل میډیا ========== --}}
        <div class="mb-8 border-b dark:border-gray-700 pb-8">
            <h2 class="text-xl font-bold dark:text-white text-gray-700 mb-4">@lang('messages.social_media')</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 mb-1">@lang('messages.facebook_link')</label>
                    <input type="url" name="social_facebook" value="{{ $socialFacebook }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" placeholder="https://facebook.com/...">
                </div>
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 mb-1">@lang('messages.instagram_link')</label>
                    <input type="url" name="social_instagram" value="{{ $socialInstagram }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" placeholder="https://instagram.com/...">
                </div>
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 mb-1">@lang('messages.whatsapp_number_only')</label>
                    <input type="text" name="social_whatsapp" value="{{ $socialWhatsapp }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" placeholder="93700000000">
                </div>
            </div>
        </div>

        {{-- ========== د اړیکو معلومات ========== --}}
        <div class="mb-8">
            <h2 class="text-xl font-bold dark:text-white text-gray-700 mb-4">@lang('messages.contact_info')</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 mb-1">@lang('messages.phone')</label>
                    <input type="text" name="contact_phone" value="{{ $contactPhone }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
                </div>
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 mb-1">@lang('messages.whatsapp')</label>
                    <input type="text" name="contact_whatsapp" value="{{ $contactWhatsapp }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
                </div>
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 mb-1">@lang('messages.email')</label>
                    <input type="email" name="contact_email" value="{{ $contactEmail }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
                </div>
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 mb-1">@lang('messages.address')</label>
                    <textarea name="contact_address" rows="2" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">{{ $contactAddress }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-start">
            <button type="submit" class="bg-blue-600 text-white px-8 py-2 rounded-md hover:bg-blue-700 transition">@lang('messages.save')</button>
        </div>
    </form>
</div>
@endsection