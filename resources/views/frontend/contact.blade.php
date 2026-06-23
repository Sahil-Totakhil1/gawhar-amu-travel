@extends('layouts.app')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">زموږ سره اړیکه ونیسئ</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contact.submit') }}" method="POST" class="bg-white shadow-md rounded-lg p-8">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">نوم *</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-md px-4 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">ایمیل (اختیاري)</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-md px-4 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">تلیفون (اختیاري)</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border border-gray-300 rounded-md px-4 py-2">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">پیغام *</label>
            <textarea name="message" rows="5" class="w-full border border-gray-300 rounded-md px-4 py-2" required>{{ old('message') }}</textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">لېږل</button>
    </form>
</div>
@endsection