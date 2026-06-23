@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">نوی خدمت جوړ کړئ</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.services.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-8">
        @csrf

        <!-- آیکون (Font Awesome) -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">آیکون (Font Awesome کلاس)</label>
            <input type="text" name="icon" value="{{ old('icon') }}" class="w-full border border-gray-300 rounded-md px-4 py-2" placeholder="مثال: fa-laptop-code">
            <p class="text-xs text-gray-500 mt-1">د Font Awesome آیکون کلاس دننه کړئ، لکه: fa-book, fa-plane</p>
        </div>

        <!-- د خدمت عنوان په دریو ژبو -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">عنوان (پښتو) *</label>
            <input type="text" name="title_ps" value="{{ old('title_ps') }}" class="w-full border border-gray-300 rounded-md px-4 py-2" required>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">عنوان (دری)</label>
            <input type="text" name="title_dr" value="{{ old('title_dr') }}" class="w-full border border-gray-300 rounded-md px-4 py-2">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Title (English)</label>
            <input type="text" name="title_en" value="{{ old('title_en') }}" class="w-full border border-gray-300 rounded-md px-4 py-2">
        </div>

        <!-- تشریح په دریو ژبو -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">تشریح (پښتو)</label>
            <textarea name="description_ps" rows="3" class="w-full border border-gray-300 rounded-md px-4 py-2">{{ old('description_ps') }}</textarea>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">تشریح (دری)</label>
            <textarea name="description_dr" rows="3" class="w-full border border-gray-300 rounded-md px-4 py-2">{{ old('description_dr') }}</textarea>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Description (English)</label>
            <textarea name="description_en" rows="3" class="w-full border border-gray-300 rounded-md px-4 py-2">{{ old('description_en') }}</textarea>
        </div>

        <!-- ترتیب -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">ترتیب (Sort Order)</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full border border-gray-300 rounded-md px-4 py-2">
        </div>

        <!-- تڼۍ -->
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">خوندي کول</button>
            <a href="{{ route('admin.services.index') }}" class="text-gray-600 hover:text-gray-900">بېرته</a>
        </div>
    </form>
</div>
@endsection