@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-8 dark:text-white text-gray-800">@lang('messages.edit_gallery_title')</h1>

    @if ($errors->any())
        <div class="bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8">
        @csrf
        @method('PUT')

        <!-- ډول -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.type') *</label>
            <select name="type" id="type" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" required onchange="toggleTypeFields()">
                <option value="image" {{ old('type', $gallery->type) == 'image' ? 'selected' : '' }}>@lang('messages.image')</option>
                <option value="video" {{ old('type', $gallery->type) == 'video' ? 'selected' : '' }}>@lang('messages.video')</option>
            </select>
        </div>

        <!-- د انځور برخه -->
        <div id="image-field" class="mb-6" style="{{ old('type', $gallery->type) == 'video' ? 'display:none;' : '' }}">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.image')</label>
            @if($gallery->type == 'image' && $gallery->url)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $gallery->url) }}" alt="Current Image" class="h-20 w-20 object-cover rounded border dark:border-gray-600">
                </div>
            @endif
            <input type="file" name="image" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" accept="image/*">
        </div>

        <!-- د ویډیو برخه -->
        <div id="video-field" class="mb-6" style="{{ old('type', $gallery->type) == 'image' ? 'display:none;' : '' }}">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.video_url')</label>
            <input type="url" name="video_url" value="{{ old('video_url', $gallery->type == 'video' ? $gallery->url : '') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" placeholder="@lang('messages.video_url_placeholder')">
        </div>

        <!-- توضیح (Caption) په دریو ژبو -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.caption_ps')</label>
            <input type="text" name="caption_ps" value="{{ old('caption_ps', $gallery->caption['ps'] ?? '') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.caption_dr')</label>
            <input type="text" name="caption_dr" value="{{ old('caption_dr', $gallery->caption['dr'] ?? '') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.caption_en')</label>
            <input type="text" name="caption_en" value="{{ old('caption_en', $gallery->caption['en'] ?? '') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>

        <!-- ترتیب -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.sort_order')</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $gallery->sort_order) }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>

        <!-- فعال/غیرفعال -->
        <div class="mb-6">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $gallery->is_active) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span class="mr-2 text-gray-700 dark:text-gray-300 font-bold">@lang('messages.active')</span>
            </label>
        </div>

        <!-- تڼۍ -->
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">@lang('messages.update')</button>
            <a href="{{ route('admin.galleries.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">@lang('messages.back')</a>
        </div>
    </form>
</div>

<script>
    function toggleTypeFields() {
        var type = document.getElementById('type').value;
        document.getElementById('image-field').style.display = (type === 'image') ? 'block' : 'none';
        document.getElementById('video-field').style.display = (type === 'video') ? 'block' : 'none';
    }
</script>
@endsection