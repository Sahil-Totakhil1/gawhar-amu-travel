@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-8 dark:text-white text-gray-800">@lang('messages.edit_ad_title')</h1>

    @if ($errors->any())
        <div class="bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.ads.update', $ad) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8">
        @csrf
        @method('PUT')

        <!-- په دریو ژبو کې سرلیک -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.title_ps') *</label>
            <input type="text" name="title_ps" value="{{ old('title_ps', $ad->title['ps'] ?? '') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" required>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.title_dr')</label>
            <input type="text" name="title_dr" value="{{ old('title_dr', $ad->title['dr'] ?? '') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.title_en')</label>
            <input type="text" name="title_en" value="{{ old('title_en', $ad->title['en'] ?? '') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>

        <!-- په دریو ژبو کې تشریح -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.description_ps')</label>
            <textarea name="description_ps" rows="3" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">{{ old('description_ps', $ad->description['ps'] ?? '') }}</textarea>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.description_dr')</label>
            <textarea name="description_dr" rows="3" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">{{ old('description_dr', $ad->description['dr'] ?? '') }}</textarea>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.description_en')</label>
            <textarea name="description_en" rows="3" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">{{ old('description_en', $ad->description['en'] ?? '') }}</textarea>
        </div>

        <!-- کټګوري -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.category') *</label>
            <select name="category" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" required>
                <option value="">@lang('messages.select_option')</option>
                <option value="visa" {{ old('category', $ad->category) == 'visa' ? 'selected' : '' }}>@lang('messages.visa')</option>
                <option value="tour" {{ old('category', $ad->category) == 'tour' ? 'selected' : '' }}>@lang('messages.tour')</option>
                <option value="hajj" {{ old('category', $ad->category) == 'hajj' ? 'selected' : '' }}>@lang('messages.hajj')</option>
                <option value="ticket" {{ old('category', $ad->category) == 'ticket' ? 'selected' : '' }}>@lang('messages.ticket')</option>
                <option value="residence" {{ old('category', $ad->category) == 'residence' ? 'selected' : '' }}>@lang('messages.residence')</option>
                <option value="other" {{ old('category', $ad->category) == 'other' ? 'selected' : '' }}>@lang('messages.other')</option>
            </select>
        </div>

        <!-- قیمت -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.price_dollar')</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $ad->price) }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>

        <!-- موقعیت -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.location')</label>
            <input type="text" name="location" value="{{ old('location', $ad->location) }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>

        <!-- اوسنی انځور -->
        @if($ad->image)
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.current_image')</label>
            <img src="{{ asset('storage/' . $ad->image) }}" class="h-20 w-20 object-cover rounded border dark:border-gray-600">
        </div>
        @endif

        <!-- نوی انځور -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.new_image_optional')</label>
            <input type="file" name="image" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>

        <!-- ویډیو لینک -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.video_url')</label>
            <input type="url" name="video_url" value="{{ old('video_url', $ad->video_url) }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" placeholder="@lang('messages.video_url_placeholder')">
        </div>

        <!-- تڼۍ -->
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">@lang('messages.update')</button>
            <a href="{{ route('admin.ads.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">@lang('messages.back')</a>
        </div>
    </form>
</div>
@endsection