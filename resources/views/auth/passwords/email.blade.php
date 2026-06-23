@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background-color: var(--body-bg);">
    <div class="max-w-md w-full section-card p-8">
        <h2 class="text-2xl font-bold text-center mb-6" style="color: var(--body-text);">@lang('messages.forgot_password')</h2>

        @if(session('status'))
            <div class="bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block font-medium mb-2" style="color: var(--body-text);">@lang('messages.email')</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-md px-4 py-3" style="background: var(--input-bg); border-color: var(--input-border); color: var(--input-text);" required autofocus>
            </div>
            <button type="submit" class="w-full btn-primary py-3 rounded-md font-bold text-lg">@lang('messages.send_reset_link')</button>
        </form>

        <p class="text-center mt-4" style="color: var(--card-text);">
            <a href="{{ route('login') }}" class="text-sm hover:underline" style="color: var(--primary);">← @lang('messages.back_to_login')</a>
        </p>
    </div>
</div>
@endsection