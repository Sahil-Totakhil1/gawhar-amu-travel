@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-8 dark:text-white text-gray-800">@lang('messages.new_user_title')</h1>

    @if ($errors->any())
        <div class="bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8">
        @csrf

        <!-- نوم -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.name') *</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" required>
        </div>

        <!-- یوزرنیم -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.username') *</label>
            <input type="text" name="username" value="{{ old('username') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" required>
        </div>

        <!-- ایمیل -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.email_optional')</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>

        <!-- تلیفون -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.phone_optional')</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
        </div>

        <!-- پاسورډ -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.password_requirements')</label>
            <div class="relative">
                <input type="password" name="password" id="password" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2 pr-12" required minlength="8" onkeyup="checkPasswordStrength()">
                <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePasswordVisibility('password', 'eyeIcon')">
                    <i id="eyeIcon" class="fas fa-eye text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-white"></i>
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

        <!-- رول -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.role') *</label>
            <select name="role" id="role" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2" required>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>@lang('messages.admin')</option>
                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>@lang('messages.staff')</option>
            </select>
        </div>

        <!-- واک (یوازې د Staff لپاره) -->
        <div class="mb-6" id="permission-field">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.permission_for_staff')</label>
            <select name="permission" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
                <option value="">@lang('messages.all_permissions_select')</option>
                <option value="ads" {{ old('permission') == 'ads' ? 'selected' : '' }}>@lang('messages.ads')</option>
                <option value="packages" {{ old('permission') == 'packages' ? 'selected' : '' }}>@lang('messages.packages')</option>
                <option value="services" {{ old('permission') == 'services' ? 'selected' : '' }}>@lang('messages.services')</option>
                <option value="destinations" {{ old('permission') == 'destinations' ? 'selected' : '' }}>@lang('messages.destinations')</option>
            </select>
        </div>

        <!-- فعال / غیرفعال -->
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">@lang('messages.status')</label>
            <select name="is_active" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
                <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>@lang('messages.active')</option>
                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>@lang('messages.inactive')</option>
            </select>
        </div>

        <!-- تڼۍ -->
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">@lang('messages.save')</button>
            <a href="{{ route('admin.users.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">@lang('messages.back')</a>
        </div>
    </form>
</div>

<script>
    // د سترګې آیکون: پاسورډ ښکاره/پټول
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

    // د پاسورډ د قوت چک کول
    function checkPasswordStrength() {
        var password = document.getElementById('password').value;
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

    document.getElementById('role').addEventListener('change', function() {
        var perm = document.getElementById('permission-field');
        perm.style.display = (this.value === 'admin') ? 'none' : 'block';
    });
</script>
@endsection