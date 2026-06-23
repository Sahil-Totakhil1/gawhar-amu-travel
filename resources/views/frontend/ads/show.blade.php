@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <a href="{{ route('ads.index') }}" class="inline-flex items-center gap-2 mb-6 transition" style="color: var(--primary);">
        <i class="fas fa-arrow-right rtl:rotate-180"></i> @lang('messages.back_to_ads')
    </a>

    <div class="section-card overflow-hidden">
        @if($ad->video_url)
            <div class="relative" style="padding-top: 56.25%">
                <iframe class="absolute inset-0 w-full h-full" src="{{ $ad->video_url }}" frameborder="0" allowfullscreen></iframe>
            </div>
        @elseif($ad->image)
            <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title['ps'] ?? '' }}" class="w-full h-72 object-cover">
        @else
            <div class="w-full h-72 flex items-center justify-center" style="background: var(--card-bg); color: var(--card-text);">@lang('messages.no_image')</div>
        @endif

        <div class="p-8">
            <h1 class="text-3xl font-extrabold mb-4" style="color: var(--card-heading);">{{ $ad->title[app()->getLocale()] ?? $ad->title['ps'] ?? '' }}</h1>

            <div class="flex flex-wrap items-center gap-3 text-sm mb-6" style="color: var(--card-text);">
                <span class="px-4 py-1.5 rounded-full border" style="border-color: var(--primary); color: var(--primary); background: rgba(0,210,255,0.1);">{{ $ad->category }}</span>
                <span><i class="fas fa-eye"></i> {{ $ad->views }} @lang('messages.views')</span>
                @if($ad->location) <span><i class="fas fa-map-marker-alt" style="color: var(--primary);"></i> {{ $ad->location }}</span> @endif
            </div>

            @if($ad->price)
                <div class="text-4xl font-bold mb-6" style="color: var(--primary);">${{ $ad->price }}</div>
            @endif

            <div class="text-lg leading-8 mb-8 pt-6 border-t" style="color: var(--card-text); border-color: var(--glass-border);">
                {{ $ad->description[app()->getLocale()] ?? $ad->description['ps'] ?? '' }}
            </div>

            <div class="text-sm pt-6 border-t" style="color: var(--card-text); border-color: var(--glass-border);">
                <p>@lang('messages.published_by'): <strong style="color: var(--card-heading);">{{ $ad->user->name ?? __('messages.unknown') }}</strong></p>
            </div>

            <div class="mt-8 flex flex-wrap gap-4">
                @php
                    $wa = \App\Models\Setting::get('social_whatsapp');
                    $ph = \App\Models\Setting::get('contact_phone');
                @endphp
                <a href="https://wa.me/{{ $wa ?? '' }}" target="_blank" class="inline-flex items-center gap-2 bg-green-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-green-600 transition">
                    <i class="fab fa-whatsapp text-xl"></i> @lang('messages.whatsapp')
                </a>
                <a href="tel:{{ $ph ?? '' }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-semibold transition" style="background: var(--glass-bg); border: 1px solid var(--glass-border); color: var(--body-text);">
                    <i class="fas fa-phone text-xl"></i> @lang('messages.phone')
                </a>
            </div>
        </div>
    </div>
</div>
@endsection