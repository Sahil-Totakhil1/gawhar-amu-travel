@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background-color: var(--body-bg);">
    <div class="max-w-md w-full section-card p-8">
        <h2 class="text-2xl font-bold text-center mb-6" style="color: var(--body-text);">@lang('messages.login')</h2>

        @if ($errors->any())
            <div class="bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-medium mb-2" style="color: var(--body-text);">@lang('messages.login_field')</label>
                <input type="text" name="login" value="{{ old('login') }}" class="w-full border rounded-md px-4 py-3" style="background: var(--input-bg); border-color: var(--input-border); color: var(--input-text);" required autofocus>
            </div>

            <div class="mb-6">
                <label class="block font-medium mb-2" style="color: var(--body-text);">@lang('messages.password')</label>
                <div class="relative">
                    <input type="password" name="password" id="password" class="w-full border rounded-md px-4 py-3 pr-12" style="background: var(--input-bg); border-color: var(--input-border); color: var(--input-text);" required>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePasswordVisibility()">
                        <i id="eyeIcon" class="fas fa-eye" style="color: var(--card-text);"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="w-full btn-primary py-3 rounded-md font-bold text-lg">@lang('messages.login')</button>
        </form>

        <p class="text-center mt-4" style="color: var(--card-text);">
            <a href="{{ route('password.request') }}" class="text-sm hover:underline" style="color: var(--primary);">@lang('messages.forgot_password')</a>
        </p>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        var p = document.getElementById('password');
        var icon = document.getElementById('eyeIcon');
        if (p.type === 'password') {
            p.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            p.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection