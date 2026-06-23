@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-8 dark:text-white text-gray-800">@lang('messages.create_gallery_title')</h1>

    @if ($errors->any())
        <div class="bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8">
        @csrf

        <!-- ډول -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.type') *</label>
            <select name="type" id="type" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" required onchange="toggleTypeFields()">
                <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>@lang('messages.image')</option>
                <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>@lang('messages.video')</option>
            </select>
        </div>

        <!-- د انځور برخه -->
        <div id="image-field" class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.image')</label>
            <input type="file" name="image" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" accept="image/*">
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">@lang('messages.image_requirements')</p>
        </div>

        <!-- د ویډیو برخه -->
        <div id="video-field" class="mb-6" style="display: none;">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.video_url')</label>
            <input type="url" name="video_url" value="{{ old('video_url') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" placeholder="@lang('messages.video_url_placeholder')">
        </div>

        <!-- توضیح (Caption) په دریو ژبو -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.caption_ps')</label>
            <input type="text" name="caption_ps" value="{{ old('caption_ps') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.caption_dr')</label>
            <input type="text" name="caption_dr" value="{{ old('caption_dr') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.caption_en')</label>
            <input type="text" name="caption_en" value="{{ old('caption_en') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>

        <!-- ترتیب -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.sort_order')</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>

        <!-- تڼۍ -->
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">@lang('messages.save')</button>
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
    // د پخواني انتخاب پر بنسټ د پاڼې د بارېدو پر مهال حالت
    document.addEventListener('DOMContentLoaded', function() {
        toggleTypeFields();
    });
</script>
@endsection