<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@lang('messages.welcome') - @lang('messages.company_short')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#00d2ff',
                        secondary: '#0066ff',
                    },
                }
            }
        }
    </script>

    @php
        $locale = app()->getLocale();
        $logo = \App\Models\Setting::get('logo');
        $background = \App\Models\Setting::get('background');
        $socialFacebook = \App\Models\Setting::get('social_facebook');
        $socialInstagram = \App\Models\Setting::get('social_instagram');
        $socialWhatsapp = \App\Models\Setting::get('social_whatsapp');
        $contactPhone = \App\Models\Setting::get('contact_phone');
        $contactWhatsapp = \App\Models\Setting::get('contact_whatsapp');
        $contactEmail = \App\Models\Setting::get('contact_email');
        $contactAddress = \App\Models\Setting::get('contact_address');
    @endphp
    
    <style>
        :root {
            --primary: #00d2ff;
            --secondary: #0066ff;
            --bg-dark: #0a0f1d;
            --bg-light: #f8fafc;
            --text-light: #ffffff;
            --text-dark: #1e293b;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --font-pashto: 'Amiri', serif;
            --font-english: 'Inter', sans-serif;
            --card-bg: rgba(255, 255, 255, 0.05);
            --card-border: rgba(255, 255, 255, 0.1);
            --card-heading: #ffffff;
            --card-text: #e2e8f0;
            --input-bg: rgba(255, 255, 255, 0.05);
            --input-border: rgba(255, 255, 255, 0.1);
            --input-text: #ffffff;
            --btn-primary-bg: linear-gradient(45deg, #00d2ff, #0066ff);
            --btn-primary-text: #ffffff;
            --footer-bg: #050811;
            --footer-text: #a0a5b5;
            --nav-bg: rgba(10, 15, 29, 0.7);
            --nav-text: #ffffff;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
            font-family: {{ $locale == 'en' ? 'var(--font-english)' : 'var(--font-pashto)' }};
            overflow-x: hidden;
            line-height: 1.6;
        }
        body.light-mode {
            background-color: var(--bg-light);
            color: var(--text-dark);
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --card-heading: #0f172a;
            --card-text: #334155;
            --input-bg: #ffffff;
            --input-border: #cbd5e1;
            --input-text: #1e293b;
            --footer-bg: #e2e8f0;
            --footer-text: #475569;
            --nav-bg: rgba(255, 255, 255, 0.8);
            --nav-text: #1e293b;
            --glass-bg: #ffffff;
            --glass-border: #e2e8f0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; scroll-behavior: smooth; }

        .glass-nav {
            position: sticky; top: 0; width: 100%; padding: 15px 30px;
            display: flex; justify-content: space-between; align-items: center; z-index: 1000;
            background: var(--nav-bg); backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
        }
        @media (max-width: 1023px) {
            .glass-nav { padding: 15px 20px; }
        }
        .nav-logo { font-size: 1.8rem; font-weight: bold; background: linear-gradient(45deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-links { display: flex; gap: 25px; align-items: center; }
        .nav-links a { 
            color: var(--nav-text); 
            text-decoration: none; 
            font-size: 1rem; 
            transition: all 0.3s ease; 
            white-space: nowrap; 
            position: relative;
            padding: 6px 12px;
            border-radius: 8px;
            border: 2px solid transparent;
        }
        .nav-links a:hover { 
            color: var(--primary); 
        }
        @media (min-width: 1024px) {
            .nav-links a {
                border: 2px solid transparent;
                transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            }
            .nav-links a:hover {
                border-color: rgba(0, 210, 255, 0.15);
                transform: translateY(-2px) scale(1.02);
                box-shadow: 0 0 8px rgba(0, 210, 255, 0.08), inset 0 0 8px rgba(0, 210, 255, 0.02);
                background: rgba(0, 210, 255, 0.02);
            }
            .nav-links a::before {
                content: '';
                position: absolute;
                top: -2px;
                left: -2px;
                right: -2px;
                bottom: -2px;
                border-radius: 10px;
                background: linear-gradient(45deg, rgba(0, 210, 255, 0.15), rgba(0, 102, 255, 0.15), rgba(0, 210, 255, 0.15), rgba(0, 102, 255, 0.15));
                background-size: 300% 300%;
                z-index: -1;
                animation: borderGlowNav 5s ease-in-out infinite;
                opacity: 0;
                transition: opacity 0.4s ease;
            }
            .nav-links a:hover::before {
                opacity: 0.3;
            }
            @keyframes borderGlowNav {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
        }

        .nav-actions { display: flex; align-items: center; gap: 15px; }
        .lang-select { background: var(--glass-bg); border: 1px solid var(--glass-border); color: var(--nav-text); padding: 6px 12px; border-radius: 8px; cursor: pointer; outline: none; font-family: inherit; }
        .lang-select option { background: #1e293b; color: #fff; }
        body.light-mode .lang-select option { background: #fff; color: #000; }
        .btn-glass { background: var(--glass-bg); border: 1px solid var(--glass-border); color: var(--nav-text); padding: 8px 16px; border-radius: 8px; text-decoration: none; transition: all 0.3s; font-size: 0.9rem; }
        .btn-glass:hover { background: rgba(255,255,255,0.1); border-color: var(--primary); }
        .btn-primary { background: var(--btn-primary-bg); color: var(--btn-primary-text); border: none; padding: 8px 18px; border-radius: 8px; cursor: pointer; font-weight: bold; transition: transform 0.2s; text-decoration: none; display: inline-block; }
        .btn-primary:hover { transform: translateY(-2px); }
        .btn-danger { background: #ef4444; color: #fff; border: none; padding: 8px 18px; border-radius: 8px; cursor: pointer; font-weight: bold; }
        .mode-toggle { background: none; border: none; color: var(--nav-text); font-size: 1.4rem; cursor: pointer; padding: 5px; }

        /* ==================== د لوګو 3D انیمیشن ==================== */
        .logo-wrapper {
            display: inline-block;
            position: relative;
            perspective: 800px;
            padding: 4px;
        }
        .logo-3d {
            display: block;
            height: 40px;
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            transform-style: preserve-3d;
            position: relative;
            border-radius: 8px;
            padding: 2px;
        }
        .logo-3d img {
            display: block;
            height: 40px;
            width: auto;
            border-radius: 6px;
            position: relative;
            z-index: 2;
            transition: all 0.4s ease;
        }
        /* د ۴ اړخیز 3D چوکاټ */
        .logo-3d::before {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 10px;
            background: linear-gradient(45deg, #00d2ff, #0066ff, #ff6b6b, #ffd93d, #6bcb77, #00d2ff);
            background-size: 300% 300%;
            z-index: 0;
            animation: logoBorderGlow 4s ease-in-out infinite;
            opacity: 0.7;
            transition: opacity 0.4s ease;
        }
        .logo-3d::after {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 12px;
            background: linear-gradient(45deg, rgba(0, 210, 255, 0.2), rgba(0, 102, 255, 0.2), rgba(255, 107, 107, 0.2), rgba(255, 217, 61, 0.2), rgba(107, 203, 119, 0.2), rgba(0, 210, 255, 0.2));
            background-size: 300% 300%;
            z-index: -1;
            animation: logoBorderGlow 4s ease-in-out infinite;
            filter: blur(8px);
            opacity: 0.5;
            transition: opacity 0.4s ease;
        }
        .logo-wrapper:hover .logo-3d {
            transform: rotateY(15deg) rotateX(5deg) scale(1.08);
        }
        .logo-wrapper:hover .logo-3d::before {
            opacity: 1;
        }
        .logo-wrapper:hover .logo-3d::after {
            opacity: 0.8;
            filter: blur(12px);
        }
        .logo-wrapper:hover .logo-3d img {
            transform: scale(1.05);
            filter: brightness(1.1) drop-shadow(0 0 15px rgba(0, 210, 255, 0.3));
        }

        @keyframes logoBorderGlow {
            0% { background-position: 0% 50%; }
            25% { background-position: 50% 0%; }
            50% { background-position: 100% 50%; }
            75% { background-position: 50% 100%; }
            100% { background-position: 0% 50%; }
        }

        /* د موبایل لپاره د لوګو اندازه */
        @media (max-width: 768px) {
            .logo-3d img {
                height: 32px;
            }
            .logo-3d {
                height: 32px;
            }
            .logo-3d::before {
                inset: -2px;
            }
            .logo-3d::after {
                inset: -4px;
                filter: blur(6px);
            }
        }
        /* ======================================================================== */

        .section-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            padding: 2rem;
            color: var(--card-text);
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
        }
        .section-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            border-radius: 1.6rem;
            background: linear-gradient(45deg, rgba(0, 210, 255, 0.15), rgba(0, 102, 255, 0.15), rgba(0, 210, 255, 0.15), rgba(0, 102, 255, 0.15));
            background-size: 300% 300%;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.5s ease;
            animation: borderGlowCard 5s ease-in-out infinite;
        }
        .section-card:hover::before {
            opacity: 0.3;
        }
        .section-card:hover {
            transform: translateY(-6px) scale(1.01);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2), 0 0 20px rgba(0, 210, 255, 0.04);
            border-color: rgba(0, 210, 255, 0.15);
        }
        @keyframes borderGlowCard {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        body.light-mode .section-card::before {
            background: linear-gradient(45deg, rgba(0, 102, 255, 0.15), rgba(0, 210, 255, 0.15), rgba(0, 102, 255, 0.15), rgba(0, 210, 255, 0.15));
            background-size: 300% 300%;
        }
        .section-card img {
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94), filter 0.4s ease;
        }
        .section-card:hover img {
            transform: scale(1.05);
            filter: brightness(1.05);
        }

        .section-card h2, .section-card h3 { color: var(--card-heading); }
        input, textarea, select {
            background: var(--input-bg); border: 1px solid var(--input-border); color: var(--input-text);
            border-radius: 0.75rem; padding: 0.75rem 1rem; outline: none; transition: border-color 0.2s;
            width: 100%;
        }
        input:focus, textarea:focus, select:focus { border-color: var(--primary); }

        .site-footer {
            background: var(--footer-bg); color: var(--footer-text); padding: 40px 20px; text-align: center;
            border-top: 1px solid var(--glass-border);
        }
        .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto 30px; text-align: {{ $locale == 'en' ? 'left' : 'right' }}; }
        .footer-grid h3 { color: var(--primary); margin-bottom: 15px; }
        .footer-grid a, .footer-grid p { color: var(--footer-text); text-decoration: none; display: block; margin-bottom: 8px; }
        .footer-grid a:hover { color: #fff; }
        body.light-mode .footer-grid a:hover { color: var(--secondary); }
        .social-icons { display: flex; gap: 15px; font-size: 1.5rem; justify-content: {{ $locale == 'en' ? 'flex-start' : 'flex-end' }}; }
        .social-icons a { color: var(--footer-text); }
        .social-icons a:hover { color: var(--primary); }

        /* د موبایل مینو بټنونه */
        .mobile-menu-link {
            display: inline-block;
            width: 100%;
            padding: 8px 0;
            font-size: 1.3rem;
            font-weight: 500;
            text-align: center;
            text-decoration: none;
            color: var(--nav-text);
            transition: all 0.3s ease;
            position: relative;
            background: none;
            border: none;
            letter-spacing: 1px;
        }
        .mobile-menu-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .mobile-menu-link:hover {
            color: var(--primary);
            transform: scale(1.05);
        }
        .mobile-menu-link:hover::after {
            width: 60%;
        }
        body.light-mode .mobile-menu-link {
            color: var(--text-dark);
        }
        body.light-mode .mobile-menu-link:hover {
            color: var(--secondary);
        }

        .mobile-menu-select {
            width: 100%;
            padding: 8px 0;
            background: transparent;
            border: none;
            border-bottom: 2px solid var(--glass-border);
            color: var(--nav-text);
            font-size: 1.1rem;
            text-align: center;
            outline: none;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }
        .mobile-menu-select:hover {
            border-color: var(--primary);
        }
        .mobile-menu-select option {
            background: #1e293b;
            color: #fff;
        }
        body.light-mode .mobile-menu-select option {
            background: #fff;
            color: #000;
        }

        .mobile-mode-toggle {
            background: none;
            border: 2px solid var(--primary);
            border-radius: 12px;
            color: var(--nav-text);
            font-size: 1.8rem;
            cursor: pointer;
            padding: 10px 20px;
            transition: all 0.3s ease;
            position: relative;
            animation: borderGlow 3s ease-in-out infinite;
        }
        .mobile-mode-toggle:hover {
            transform: rotate(20deg) scale(1.1);
            animation-play-state: paused;
        }
        body.light-mode .mobile-mode-toggle {
            border-color: var(--secondary);
        }
        @keyframes borderGlow {
            0% { border-color: var(--primary); box-shadow: 0 0 5px var(--primary); }
            25% { border-color: #ff6b6b; box-shadow: 0 0 15px #ff6b6b; }
            50% { border-color: #ffd93d; box-shadow: 0 0 20px #ffd93d; }
            75% { border-color: #6bcb77; box-shadow: 0 0 15px #6bcb77; }
            100% { border-color: var(--primary); box-shadow: 0 0 5px var(--primary); }
        }
        body.light-mode @keyframes borderGlow {
            0% { border-color: var(--secondary); box-shadow: 0 0 5px var(--secondary); }
            25% { border-color: #ff6b6b; box-shadow: 0 0 15px #ff6b6b; }
            50% { border-color: #ffd93d; box-shadow: 0 0 20px #ffd93d; }
            75% { border-color: #6bcb77; box-shadow: 0 0 15px #6bcb77; }
            100% { border-color: var(--secondary); box-shadow: 0 0 5px var(--secondary); }
        }

        .mobile-menu-btn-primary,
        .mobile-menu-btn-danger {
            width: 100%;
            padding: 10px 0;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }
        .mobile-menu-btn-primary {
            background: var(--btn-primary-bg);
            color: var(--btn-primary-text);
        }
        .mobile-menu-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,210,255,0.3);
        }
        .mobile-menu-btn-danger {
            background: #ef4444;
            color: #fff;
        }
        .mobile-menu-btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }
    </style>

    @if($locale == 'ps' || $locale == 'dr')
        <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    @else
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @endif

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @stack('styles')
</head>
<body>
    <header class="glass-nav">
        <div class="flex items-center gap-3">
            {{-- لوګو د 3D انیمیشن سره --}}
            <div class="logo-wrapper">
                <div class="logo-3d">
                    @if($logo) 
                        <img src="{{ asset('storage/' . $logo) }}" alt="Logo"> 
                    @else
                        <img src="{{ asset('images/default-logo.png') }}" alt="Logo" style="height:40px;">
                    @endif
                </div>
            </div>
            <a href="{{ url('/') }}" class="nav-logo">@lang('messages.company_short')</a>
        </div>

        {{-- د کمپیوټر مینو (په موبایل کې پټ) --}}
        <div class="nav-links hidden lg:flex">
            <a href="{{ url('/#home') }}" class="scroll-link">@lang('messages.home')</a>
            <a href="{{ url('/#about') }}" class="scroll-link">@lang('messages.about')</a>
            <a href="{{ url('/#services') }}" class="scroll-link">@lang('messages.services')</a>
            <a href="{{ url('/#packages') }}" class="scroll-link">@lang('messages.packages')</a>
            <a href="{{ url('/#ads') }}" class="scroll-link">@lang('messages.ads')</a>
            <a href="{{ url('/#contact') }}" class="scroll-link">@lang('messages.contact')</a>
        </div>

        {{-- د کمپیوټر لپاره د ژبې انتخاب، تیاره/روښانه، او ننوتل --}}
        <div class="nav-actions hidden lg:flex">
            <button onclick="toggleMode()" class="mode-toggle" id="modeIcon"><i class="fas fa-sun"></i></button>
            <select onchange="window.location.href=this.value" class="lang-select">
                <option value="{{ route('lang.switch', 'ps') }}" {{ $locale == 'ps' ? 'selected' : '' }}>پښتو</option>
                <option value="{{ route('lang.switch', 'dr') }}" {{ $locale == 'dr' ? 'selected' : '' }}>دری</option>
                <option value="{{ route('lang.switch', 'en') }}" {{ $locale == 'en' ? 'selected' : '' }}>English</option>
            </select>
            @if(Auth::check())
                <a href="{{ url('/dashboard') }}" class="btn-primary">@lang('messages.dashboard')</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf <button type="submit" class="btn-danger">@lang('messages.logout')</button>
                </form>
            @else
                <a href="{{ url('/login') }}" class="btn-glass">@lang('messages.login')</a>
            @endif
        </div>

        {{-- همبرګر تڼۍ (یوازې په موبایل کې ښکاري) --}}
        <button id="menuToggle" class="lg:hidden text-2xl" style="background: none; border: none; color: var(--nav-text); cursor: pointer;">☰</button>
    </header>

    {{-- د موبایل لپاره سلیډینګ مینو --}}
    <div id="mobileMenu" class="hidden fixed top-[70px] left-0 right-0 bottom-0 z-50 flex-col items-center gap-3 pt-10 px-6 lg:hidden" style="background: var(--nav-bg); backdrop-filter: blur(15px); overflow-y: auto;">
        <a href="{{ url('/#home') }}" class="mobile-menu-link" onclick="closeMobileMenu()">@lang('messages.home')</a>
        <a href="{{ url('/#about') }}" class="mobile-menu-link" onclick="closeMobileMenu()">@lang('messages.about')</a>
        <a href="{{ url('/#services') }}" class="mobile-menu-link" onclick="closeMobileMenu()">@lang('messages.services')</a>
        <a href="{{ url('/#packages') }}" class="mobile-menu-link" onclick="closeMobileMenu()">@lang('messages.packages')</a>
        <a href="{{ url('/#ads') }}" class="mobile-menu-link" onclick="closeMobileMenu()">@lang('messages.ads')</a>
        <a href="{{ url('/#contact') }}" class="mobile-menu-link" onclick="closeMobileMenu()">@lang('messages.contact')</a>
        
        {{-- د موبایل مینو تڼۍ --}}
        <div class="w-full max-w-xs flex flex-col items-center gap-4 mt-6">
            <select onchange="window.location.href=this.value" class="mobile-menu-select">
                <option value="{{ route('lang.switch', 'ps') }}" {{ $locale == 'ps' ? 'selected' : '' }}>پښتو</option>
                <option value="{{ route('lang.switch', 'dr') }}" {{ $locale == 'dr' ? 'selected' : '' }}>دری</option>
                <option value="{{ route('lang.switch', 'en') }}" {{ $locale == 'en' ? 'selected' : '' }}>English</option>
            </select>
            
            <button onclick="toggleMode()" class="mobile-mode-toggle" id="modeIconMobile">
                <i class="fas fa-sun"></i>
            </button>

            @if(Auth::check())
                <a href="{{ url('/dashboard') }}" class="mobile-menu-btn-primary">@lang('messages.dashboard')</a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf <button type="submit" class="mobile-menu-btn-danger">@lang('messages.logout')</button>
                </form>
            @else
                <a href="{{ url('/login') }}" class="mobile-menu-btn-primary">@lang('messages.login')</a>
            @endif
        </div>
    </div>

    <main class="w-full min-h-screen"> @yield('content') </main>
    
    <footer class="site-footer">
        <div class="footer-grid">
            <div>
                <h3>@lang('messages.company_name')</h3>
                <p>@lang('messages.slogan')</p>
            </div>
            <div>
                <h3>@lang('messages.contact')</h3>
                @if($contactPhone) <p><i class="fas fa-phone"></i> {{ $contactPhone }}</p> @endif
                @if($contactWhatsapp) <p><i class="fab fa-whatsapp"></i> {{ $contactWhatsapp }}</p> @endif
                @if($contactEmail) <p><i class="fas fa-envelope"></i> {{ $contactEmail }}</p> @endif
                @if($contactAddress) <p><i class="fas fa-map-marker-alt"></i> {{ $contactAddress }}</p> @endif
            </div>
            <div>
                <h3>@lang('messages.follow_us')</h3>
                <div class="social-icons">
                    @if($socialFacebook) <a href="{{ $socialFacebook }}"><i class="fab fa-facebook"></i></a> @endif
                    @if($socialInstagram) <a href="{{ $socialInstagram }}"><i class="fab fa-instagram"></i></a> @endif
                    @if($socialWhatsapp) <a href="https://wa.me/{{ $socialWhatsapp }}"><i class="fab fa-whatsapp"></i></a> @endif
                </div>
            </div>
        </div>
        <p class="pt-4 border-t border-white/10">&copy; {{ date('Y') }} @lang('messages.company_name') - @lang('messages.slogan')</p>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, easing: 'ease-in-out', once: true });
        const body = document.body;
        const modeIcon = document.getElementById('modeIcon');
        const modeIconMobile = document.getElementById('modeIconMobile');
        function updateIcons() {
            if (body.classList.contains('light-mode')) {
                if (modeIcon) modeIcon.innerHTML = '<i class="fas fa-moon"></i>';
                if (modeIconMobile) modeIconMobile.innerHTML = '<i class="fas fa-moon"></i>';
            } else {
                if (modeIcon) modeIcon.innerHTML = '<i class="fas fa-sun"></i>';
                if (modeIconMobile) modeIconMobile.innerHTML = '<i class="fas fa-sun"></i>';
            }
        }
        if(localStorage.getItem('theme') === 'light') { body.classList.add('light-mode'); }
        updateIcons();
        function toggleMode() {
            body.classList.toggle('light-mode');
            localStorage.setItem('theme', body.classList.contains('light-mode') ? 'light' : 'dark');
            updateIcons();
        }
        // موبایل مینو
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            menuToggle.innerHTML = mobileMenu.classList.contains('hidden') ? '☰' : '✕';
        });
        function closeMobileMenu() { 
            mobileMenu.classList.add('hidden'); 
            menuToggle.innerHTML = '☰';
        }
        // Smooth scroll
        document.querySelectorAll('.scroll-link').forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href.startsWith(window.location.origin) || href.startsWith('/')) {
                    const url = new URL(href, window.location.origin);
                    if (url.hash) {
                        const target = document.querySelector(url.hash);
                        if (target) {
                            e.preventDefault();
                            window.scrollTo({ top: target.offsetTop - 80, behavior: 'smooth' });
                        }
                    }
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>