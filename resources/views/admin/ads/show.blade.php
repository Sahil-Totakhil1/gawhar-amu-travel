@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
        {{-- انځور / ویډیو --}}
        @if($ad->video_url)
            <div class="relative" style="padding-top: 56.25%">
                <iframe class="absolute inset-0 w-full h-full" src="{{ $ad->video_url }}" frameborder="0" allowfullscreen></iframe>
            </div>
        @elseif($ad->image)
            <img src="{{ asset('storage/' . $ad->image) }}" alt="Ad Image" class="w-full h-64 object-cover">
        @else
            <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 text-lg">@lang('messages.no_image')</div>
        @endif
        
        {{-- منځپانګه --}}
        <div class="p-8">
            <div class="flex justify-between items-start mb-4">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                    {{ $ad->title[app()->getLocale()] ?? $ad->title['ps'] ?? '' }}
                </h1>
                <span class="px-3 py-1 text-sm rounded-full font-semibold {{ $ad->status == 'active' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-200' }}">
                    {{ $ad->status == 'active' ? __('messages.active') : __('messages.inactive') }}
                </span>
            </div>
            
            <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mb-6">
                <span class="bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-200 px-3 py-1 rounded-full">{{ $ad->category }}</span>
                <span>👁 {{ $ad->views }} @lang('messages.views')</span>
                @if($ad->location)
                    <span>📍 {{ $ad->location }}</span>
                @endif
            </div>
            
            @if($ad->price)
                <div class="text-2xl font-bold text-green-600 dark:text-green-400 mb-6">${{ number_format($ad->price, 2) }}</div>
            @endif
            
            <div class="prose max-w-none text-gray-700 dark:text-gray-300 mb-8">
                <p>{{ $ad->description[app()->getLocale()] ?? $ad->description['ps'] ?? '' }}</p>
            </div>
            
            <div class="border-t dark:border-gray-700 pt-6 flex items-center justify-between">
                <a href="{{ route('admin.ads.edit', $ad) }}" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">✏️ @lang('messages.edit')</a>
                <a href="{{ route('admin.ads.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">← @lang('messages.back_to_list')</a>
            </div>
        </div>
    </div>
</div>
@endsection