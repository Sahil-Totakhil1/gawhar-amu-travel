@extends('layouts.admin')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8">
        <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6">@lang('messages.change_password')</h2>

        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('change.password') }}" method="POST">
            @csrf
            
            {{-- اوسنی پاسورډ --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">@lang('messages.current_password')</label>
                <div class="relative">
                    <input type="password" name="current_password" id="current_password" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2 pr-12" required>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePasswordVisibility('current_password', 'currentEyeIcon')">
                        <i id="currentEyeIcon" class="fas fa-eye text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-white"></i>
                    </span>
                </div>
            </div>

            {{-- نوی پاسورډ --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">@lang('messages.new_password_requirements')</label>
                <div class="relative">
                    <input type="password" name="new_password" id="new_password" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2 pr-12" required minlength="8" onkeyup="checkPasswordStrength()">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePasswordVisibility('new_password', 'newEyeIcon')">
                        <i id="newEyeIcon" class="fas fa-eye text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-white"></i>
                    </span>
                </div>
                {{-- د پاسورډ د قوت اندازه --}}
                <div class="mt-2" id="password-strength">
                    <div class="flex gap-1 mt-1">
                        <div id="strength-bar-1" class="h-1 w-1/4 bg-gray-300 rounded"></div>
                        <div id="strength-bar-2" class="h-1 w-1/4 bg-gray-300 rounded"></div>
                        <div id="strength-bar-3" class="h-1 w-1/4 bg-gray-300 rounded"></div>
                        <div id="strength-bar-4" class="h-1 w-1/4 bg-gray-300 rounded"></div>
                    </div>
                    <p id="strength-text" class="text-xs text-gray-500 dark:text-gray-400 mt-1">@lang('messages.password_write')</p>
                </div>
                {{-- د پاسورډ شرطونه --}}
                <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    <p id="length-check" class="text-red-500">✗ @lang('messages.pw_length')</p>
                    <p id="lowercase-check" class="text-red-500">✗ @lang('messages.pw_lowercase')</p>
                    <p id="uppercase-check" class="text-red-500">✗ @lang('messages.pw_uppercase')</p>
                    <p id="number-check" class="text-red-500">✗ @lang('messages.pw_number')</p>
                    <p id="special-check" class="text-red-500">✗ @lang('messages.pw_special')</p>
                </div>
            </div>

            {{-- نوی پاسورډ تایید --}}
            <div class="mb-6">
                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">@lang('messages.confirm_new_password')</label>
                <div class="relative">
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2 pr-12" required>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePasswordVisibility('new_password_confirmation', 'confirmEyeIcon')">
                        <i id="confirmEyeIcon" class="fas fa-eye text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-white"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700 transition">@lang('messages.change_password_btn')</button>
        </form>
        <p class="text-center text-gray-600 dark:text-gray-400 mt-4">
            <a href="{{ url('/dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline">@lang('messages.back_to_dashboard')</a>
        </p>
    </div>
</div>

<script>
    function togglePasswordVisibility(inputId, iconId) {
        var p = document.getElementById(inputId);
        var icon = document.getElementById(iconId);
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

    function checkPasswordStrength() {
        var password = document.getElementById('new_password').value;
        var lengthCheck = document.getElementById('length-check');
        var lowercaseCheck = document.getElementById('lowercase-check');
        var uppercaseCheck = document.getElementById('uppercase-check');
        var numberCheck = document.getElementById('number-check');
        var specialCheck = document.getElementById('special-check');
        
        var lengthValid = password.length >= 8;
        var lowercaseValid = /[a-z]/.test(password);
        var uppercaseValid = /[A-Z]/.test(password);
        var numberValid = /[0-9]/.test(password);
        var specialValid = /[@$!%*?&]/.test(password);
        
        lengthCheck.innerHTML = lengthValid ? '✓ @lang("messages.pw_length")' : '✗ @lang("messages.pw_length")';
        lengthCheck.className = lengthValid ? 'text-green-600' : 'text-red-500';
        lowercaseCheck.innerHTML = lowercaseValid ? '✓ @lang("messages.pw_lowercase")' : '✗ @lang("messages.pw_lowercase")';
        lowercaseCheck.className = lowercaseValid ? 'text-green-600' : 'text-red-500';
        uppercaseCheck.innerHTML = uppercaseValid ? '✓ @lang("messages.pw_uppercase")' : '✗ @lang("messages.pw_uppercase")';
        uppercaseCheck.className = uppercaseValid ? 'text-green-600' : 'text-red-500';
        numberCheck.innerHTML = numberValid ? '✓ @lang("messages.pw_number")' : '✗ @lang("messages.pw_number")';
        numberCheck.className = numberValid ? 'text-green-600' : 'text-red-500';
        specialCheck.innerHTML = specialValid ? '✓ @lang("messages.pw_special")' : '✗ @lang("messages.pw_special")';
        specialCheck.className = specialValid ? 'text-green-600' : 'text-red-500';
        
        var strength = 0;
        if (lengthValid) strength++;
        if (lowercaseValid && uppercaseValid) strength++;
        if (numberValid) strength++;
        if (specialValid) strength++;
        
        var bars = [
            document.getElementById('strength-bar-1'),
            document.getElementById('strength-bar-2'),
            document.getElementById('strength-bar-3'),
            document.getElementById('strength-bar-4')
        ];
        var strengthText = document.getElementById('strength-text');
        var colors = ['bg-gray-300', 'bg-red-500', 'bg-yellow-500', 'bg-green-500', 'bg-green-600'];
        var texts = [
            '@lang("messages.pw_very_weak")',
            '@lang("messages.pw_weak")',
            '@lang("messages.pw_medium")',
            '@lang("messages.pw_strong")',
            '@lang("messages.pw_very_strong")'
        ];
        for (var i = 0; i < bars.length; i++) {
            bars[i].className = 'h-1 w-1/4 rounded ' + (i < strength ? colors[strength] : 'bg-gray-300');
        }
        if (strength === 0) {
            strengthText.innerText = '@lang("messages.password_write")';
        } else {
            strengthText.innerText = texts[strength];
            strengthText.className = 'text-xs mt-1 ' + (strength >= 3 ? 'text-green-600 font-bold' : 'text-gray-500');
        }
    }
</script>
@endsection