@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">نوی کاروونکی جوړ کړئ</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-8">
        @csrf

        <!-- نوم -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">نوم *</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-md px-4 py-2" required>
        </div>

        <!-- یوزرنیم -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">یوزرنیم *</label>
            <input type="text" name="username" value="{{ old('username') }}" class="w-full border border-gray-300 rounded-md px-4 py-2" required>
        </div>

        <!-- ایمیل -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">@lang('messages.email_optional')</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-md px-4 py-2">
        </div>

        <!-- تلیفون -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">تلیفون (اختیاري)</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border border-gray-300 rounded-md px-4 py-2">
        </div>

        <!-- پاسورډ -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">پاسورډ * (لږ تر لږه ۸ توري)</label>
            <div class="relative">
                <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-md px-4 py-2 pr-12" required minlength="8" onkeyup="checkPasswordStrength()">
                <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePasswordVisibility('password', 'eyeIcon')">
                    <i id="eyeIcon" class="fas fa-eye text-gray-500 hover:text-gray-700"></i>
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
                <p id="strength-text" class="text-xs text-gray-500 mt-1">پاسورډ ولیکئ...</p>
            </div>
            {{-- د پاسورډ شرطونه --}}
            <div class="mt-2 text-xs text-gray-500">
                <p id="length-check" class="text-red-500">✗ لږ تر لږه ۸ توري</p>
                <p id="lowercase-check" class="text-red-500">✗ یو کوچنی انګلیسي حرف (a-z)</p>
                <p id="uppercase-check" class="text-red-500">✗ یو غټ انګلیسي حرف (A-Z)</p>
                <p id="number-check" class="text-red-500">✗ یو نمبر (0-9)</p>
                <p id="special-check" class="text-red-500">✗ یو ځانګړی سمبول (@$!%*?&)</p>
            </div>
        </div>

        <!-- رول -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">رول *</label>
            <select name="role" id="role" class="w-full border border-gray-300 rounded-md px-4 py-2" required>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
            </select>
        </div>

        <!-- واک (یوازې د Staff لپاره) -->
        <div class="mb-6" id="permission-field">
            <label class="block text-gray-700 font-bold mb-2">واک (د Staff لپاره)</label>
            <select name="permission" class="w-full border border-gray-300 rounded-md px-4 py-2">
                <option value="">-- ټول واکونه --</option>
                <option value="ads" {{ old('permission') == 'ads' ? 'selected' : '' }}>اعلانونه</option>
                <option value="packages" {{ old('permission') == 'packages' ? 'selected' : '' }}>پکېجونه</option>
                <option value="services" {{ old('permission') == 'services' ? 'selected' : '' }}>خدمتونه</option>
                <option value="destinations" {{ old('permission') == 'destinations' ? 'selected' : '' }}>منزلونه</option>
            </select>
        </div>

        <!-- فعال / غیرفعال -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">حالت</label>
            <select name="is_active" class="w-full border border-gray-300 rounded-md px-4 py-2">
                <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>فعال</option>
                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>غیرفعال</option>
            </select>
        </div>

        <!-- تڼۍ -->
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">خوندي کول</button>
            <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900">بېرته</a>
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
        
        lengthCheck.innerHTML = lengthValid ? '✓ لږ تر لږه ۸ توري' : '✗ لږ تر لږه ۸ توري';
        lengthCheck.className = lengthValid ? 'text-green-600' : 'text-red-500';
        
        lowercaseCheck.innerHTML = lowercaseValid ? '✓ یو کوچنی انګلیسي حرف (a-z)' : '✗ یو کوچنی انګلیسي حرف (a-z)';
        lowercaseCheck.className = lowercaseValid ? 'text-green-600' : 'text-red-500';
        
        uppercaseCheck.innerHTML = uppercaseValid ? '✓ یو غټ انګلیسي حرف (A-Z)' : '✗ یو غټ انګلیسي حرف (A-Z)';
        uppercaseCheck.className = uppercaseValid ? 'text-green-600' : 'text-red-500';
        
        numberCheck.innerHTML = numberValid ? '✓ یو نمبر (0-9)' : '✗ یو نمبر (0-9)';
        numberCheck.className = numberValid ? 'text-green-600' : 'text-red-500';
        
        specialCheck.innerHTML = specialValid ? '✓ یو ځانګړی سمبول (@$!%*?&)' : '✗ یو ځانګړی سمبول (@$!%*?&)';
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
        var texts = ['ډېر ضعیف', 'ضعیف', 'متوسط', 'قوي', 'ډېر قوي'];
        
        for (var i = 0; i < bars.length; i++) {
            bars[i].className = 'h-1 w-1/4 rounded ' + (i < strength ? colors[strength] : 'bg-gray-300');
        }
        
        if (strength === 0) {
            strengthText.innerText = 'پاسورډ ولیکئ...';
        } else {
            strengthText.innerText = texts[strength];
            strengthText.className = 'text-xs mt-1 ' + (strength >= 3 ? 'text-green-600 font-bold' : 'text-gray-500');
        }
    }

    // د Admin/Staff انتخاب سره سم د واک فیلډ ښکاره/پټول
    document.getElementById('role').addEventListener('change', function() {
        var perm = document.getElementById('permission-field');
        perm.style.display = (this.value === 'admin') ? 'none' : 'block';
    });
</script>
@endsection