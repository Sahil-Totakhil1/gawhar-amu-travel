@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-8 dark:text-white text-gray-800">
        @lang('messages.edit_testimonial_title'): {{ $testimonial->name }}
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

    <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8">
        @csrf
        @method('PUT')

        <!-- نوم -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.name') *</label>
            <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" required>
        </div>

        <!-- نظر -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.comment_label')</label>
            <textarea name="comment" rows="4" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" required>{{ old('comment', $testimonial->comment) }}</textarea>
        </div>

        <!-- اوسنی انځور -->
        @if($testimonial->image)
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.current_image')</label>
            <img src="{{ asset('storage/' . $testimonial->image) }}" alt="Current Image" class="h-20 w-20 object-cover rounded-full border dark:border-gray-600">
        </div>
        @endif

        <!-- نوی انځور (اختیاري) -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.new_image_optional')</label>
            <input type="file" name="image" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" accept="image/*">
        </div>

        <!-- ستوري -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.rating_label')</label>
            <select name="rating" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" required>
                <option value="5" {{ old('rating', $testimonial->rating) == '5' ? 'selected' : '' }}>@lang('messages.rating_5')</option>
                <option value="4" {{ old('rating', $testimonial->rating) == '4' ? 'selected' : '' }}>@lang('messages.rating_4')</option>
                <option value="3" {{ old('rating', $testimonial->rating) == '3' ? 'selected' : '' }}>@lang('messages.rating_3')</option>
                <option value="2" {{ old('rating', $testimonial->rating) == '2' ? 'selected' : '' }}>@lang('messages.rating_2')</option>
                <option value="1" {{ old('rating', $testimonial->rating) == '1' ? 'selected' : '' }}>@lang('messages.rating_1')</option>
            </select>
        </div>

        <!-- فعال/غیرفعال -->
        <div class="mb-6">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span class="mr-2 text-gray-700 dark:text-gray-300 font-bold">@lang('messages.active')</span>
            </label>
        </div>

        <!-- تڼۍ -->
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">@lang('messages.update')</button>
            <a href="{{ route('admin.testimonials.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">@lang('messages.back')</a>
        </div>
    </form>
</div>
@endsection