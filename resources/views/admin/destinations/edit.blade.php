@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-8 dark:text-white text-gray-800">
        @lang('messages.edit_destination_title'): {{ $destination->title[app()->getLocale()] ?? $destination->title['ps'] }}
    </h1>

    @if ($errors->any())
        <div class="bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.destinations.update', $destination) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8">
        @csrf
        @method('PUT')

        <!-- عنوان (پښتو) -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.title_ps') *</label>
            <input type="text" name="title_ps" value="{{ old('title_ps', $destination->title['ps'] ?? '') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" required>
        </div>
        <!-- عنوان (دری) -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.title_dr')</label>
            <input type="text" name="title_dr" value="{{ old('title_dr', $destination->title['dr'] ?? '') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>
        <!-- Title (English) -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.title_en')</label>
            <input type="text" name="title_en" value="{{ old('title_en', $destination->title['en'] ?? '') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>

        <!-- تشریح (پښتو) -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.description_ps')</label>
            <textarea name="description_ps" rows="3" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">{{ old('description_ps', $destination->description['ps'] ?? '') }}</textarea>
        </div>
        <!-- تشریح (دری) -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.description_dr')</label>
            <textarea name="description_dr" rows="3" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">{{ old('description_dr', $destination->description['dr'] ?? '') }}</textarea>
        </div>
        <!-- Description (English) -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.description_en')</label>
            <textarea name="description_en" rows="3" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">{{ old('description_en', $destination->description['en'] ?? '') }}</textarea>
        </div>

        <!-- اوسنی انځور -->
        @if($destination->image)
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.current_image')</label>
            <img src="{{ asset('storage/' . $destination->image) }}" alt="Current Image" class="h-20 w-20 object-cover rounded border dark:border-gray-600">
        </div>
        @endif

        <!-- نوی انځور -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.new_image_optional')</label>
            <input type="file" name="image" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>

        <!-- فعال/غیرفعال -->
        <div class="mb-6">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $destination->is_active) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span class="mr-2 text-gray-700 dark:text-gray-300 font-bold">@lang('messages.active')</span>
            </label>
        </div>

        <!-- تڼۍ -->
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">@lang('messages.update')</button>
            <a href="{{ route('admin.destinations.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">@lang('messages.back')</a>
        </div>
    </form>
</div>
@endsection