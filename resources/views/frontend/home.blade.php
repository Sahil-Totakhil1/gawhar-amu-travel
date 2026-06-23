@extends('layouts.app')

@section('content')
    {{-- ========== ۱. Hero برخه (د بکګراونډ انځور سره) ========== --}}
    <section id="home" class="relative flex flex-col items-center justify-center text-center min-h-screen py-20 px-4 hero-section" 
        @if($background) 
            style="background-image: url('{{ asset('storage/' . $background) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"
        @else 
            style="background: radial-gradient(circle at center, #1a2639 0%, var(--body-bg) 100%);"
        @endif
    >
        @if($background)
            <div class="absolute inset-0 bg-black/50"></div>
            
            {{-- ========== د موبایل لپاره ځانګړی انیمیشن – متحرک څراغونه ========== --}}
            <div class="absolute inset-0 overflow-hidden pointer-events-none mobile-particles">
                {{-- پورته برخه --}}
                <div class="absolute top-0 left-0 right-0 h-1/3 flex flex-wrap justify-around items-start pt-2 md:pt-4">
                    <div class="particle particle-1"></div>
                    <div class="particle particle-2"></div>
                    <div class="particle particle-3"></div>
                    <div class="particle particle-4"></div>
                    <div class="particle particle-5"></div>
                    <div class="particle particle-6"></div>
                    <div class="particle particle-7"></div>
                    <div class="particle particle-8"></div>
                    <div class="particle particle-9"></div>
                    <div class="particle particle-10"></div>
                    <div class="particle particle-11"></div>
                    <div class="particle particle-12"></div>
                </div>

                {{-- لاندې برخه --}}
                <div class="absolute bottom-0 left-0 right-0 h-1/3 flex flex-wrap justify-around items-end pb-2 md:pb-4">
                    <div class="particle particle-13"></div>
                    <div class="particle particle-14"></div>
                    <div class="particle particle-15"></div>
                    <div class="particle particle-16"></div>
                    <div class="particle particle-17"></div>
                    <div class="particle particle-18"></div>
                    <div class="particle particle-19"></div>
                    <div class="particle particle-20"></div>
                    <div class="particle particle-21"></div>
                    <div class="particle particle-22"></div>
                    <div class="particle particle-23"></div>
                    <div class="particle particle-24"></div>
                </div>

                {{-- منځنۍ برخه – د څپو په شکل حرکت --}}
                <div class="absolute top-1/2 left-0 right-0 -translate-y-1/2 flex justify-around opacity-30">
                    <div class="wave-particle"></div>
                    <div class="wave-particle"></div>
                    <div class="wave-particle"></div>
                    <div class="wave-particle"></div>
                    <div class="wave-particle"></div>
                    <div class="wave-particle"></div>
                    <div class="wave-particle"></div>
                    <div class="wave-particle"></div>
                </div>
            </div>
        @else
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute w-96 h-96 bg-gradient-to-r from-[#00d2ff] to-[#0066ff] rounded-full blur-[150px] opacity-20 animate-pulse"></div>
            </div>
        @endif
        <div class="relative z-10 max-w-4xl mx-auto" data-aos="fade-up">
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight" style="color: #ffffff !important;">
                {{ $companyName[app()->getLocale()] ?? $companyName['ps'] ?? __('messages.welcome') }}
            </h1>
            <p class="text-xl md:text-2xl mb-10 max-w-2xl mx-auto" style="color: #ffffff !important;">
                {{ $slogan[app()->getLocale()] ?? $slogan['ps'] ?? __('messages.slogan') }}
            </p>
            <a href="#about" class="btn-primary px-10 py-4 rounded-full text-lg font-bold shadow-lg hover:scale-105 transition duration-300 scroll-link inline-block">
                @lang('messages.more_info')
            </a>
        </div>
    </section>

    {{-- ========== ۲. زموږ په اړه ========== --}}
    <section id="about" class="py-20 px-4 scroll-mt-24">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold mb-6" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">@lang('messages.about')</h2>
            <div class="section-card text-lg leading-8">
                {{ $aboutText[app()->getLocale()] ?? $aboutText['ps'] ?? __('messages.about_short') }}
            </div>
        </div>
    </section>

    {{-- ========== ۳. خدمتونه ========== --}}
    @if($services->count() > 0)
    <section id="services" class="py-20 px-4 scroll-mt-24" style="background: var(--section-alt-bg);">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">@lang('messages.services')</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($services as $service)
                <div class="section-card text-center hover:scale-105 transition duration-300 card-3d"
                     data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                     onmousemove="tiltCard(event, this)" onmouseleave="resetTilt(this)">
                    @if($service->icon)
                        <div class="text-5xl mb-6" style="color: var(--primary);"><i class="{{ $service->icon }}"></i></div>
                    @endif
                    <h3 class="text-xl font-bold mb-3" style="color: var(--card-heading);">{{ $service->title[app()->getLocale()] ?? $service->title['ps'] }}</h3>
                    <p style="color: var(--card-text);">{{ $service->description[app()->getLocale()] ?? $service->description['ps'] ?? '' }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ========== ۴. پکېجونه ========== --}}
    @if($packages->count() > 0)
    <section id="packages" class="py-20 px-4 scroll-mt-24" style="background: var(--section-alt-bg);">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">@lang('messages.packages')</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($packages as $package)
                <div class="section-card overflow-hidden hover:scale-105 transition duration-300 card-3d"
                     data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                     onmousemove="tiltCard(event, this)" onmouseleave="resetTilt(this)">
                    @if($package->image)
                        <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->title['ps'] ?? '' }}" class="w-full h-52 object-cover">
                    @else
                        <div class="w-full h-52 flex items-center justify-center" style="background: var(--card-bg); color: var(--card-text);">@lang('messages.no_image')</div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-2" style="color: var(--card-heading);">{{ $package->title[app()->getLocale()] ?? $package->title['ps'] }}</h3>
                        <div class="flex items-center text-sm mb-3" style="color: var(--card-text);">
                            @if($package->destination) <span class="mr-4"><i class="fas fa-map-marker-alt" style="color: var(--primary);"></i> {{ $package->destination }}</span> @endif
                            @if($package->duration) <span><i class="fas fa-clock" style="color: var(--primary);"></i> {{ $package->duration }}</span> @endif
                        </div>
                        <p class="mb-4" style="color: var(--card-text);">{{ Str::limit($package->description[app()->getLocale()] ?? $package->description['ps'] ?? '', 80) }}</p>
                        @if($package->price)
                            <div class="text-2xl font-bold" style="color: var(--primary);">${{ $package->price }}</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ========== ۴.۵. منزلونه ========== --}}
    @if($destinations->count() > 0)
    <section id="destinations" class="py-20 px-4 scroll-mt-24">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">@lang('messages.our_destinations')</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($destinations as $destination)
                <div class="section-card overflow-hidden hover:scale-105 transition duration-300 card-3d"
                     data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                     onmousemove="tiltCard(event, this)" onmouseleave="resetTilt(this)">
                    @if($destination->image)
                        <img src="{{ asset('storage/' . $destination->image) }}" alt="{{ $destination->title['ps'] ?? '' }}" class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 flex items-center justify-center" style="background: var(--card-bg); color: var(--card-text);">@lang('messages.no_image')</div>
                    @endif
                    <div class="p-4 text-center">
                        <h3 class="text-lg font-bold" style="color: var(--card-heading);">{{ $destination->title[app()->getLocale()] ?? $destination->title['ps'] }}</h3>
                        @if( ($destination->description[app()->getLocale()] ?? $destination->description['ps'] ?? '') )
                            <p class="text-sm mt-2" style="color: var(--card-text);">{{ Str::limit($destination->description[app()->getLocale()] ?? $destination->description['ps'], 60) }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ========== ۵. ولې موږ؟ ========== --}}
    <section id="why-us" class="py-20 px-4 scroll-mt-24" style="background: var(--section-alt-bg);">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">@lang('messages.why_us_title')</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @for($i = 1; $i <= 4; $i++)
                <div class="section-card text-center hover:scale-105 transition duration-300 card-3d" data-aos="fade-up" data-aos-delay="{{ ($i-1)*100 }}"
                     onmousemove="tiltCard(event, this)" onmouseleave="resetTilt(this)">
                    <div class="text-5xl mb-6" style="color: var(--primary);">
                        @if($i == 1) <i class="fas fa-briefcase"></i>
                        @elseif($i == 2) <i class="fas fa-passport"></i>
                        @elseif($i == 3) <i class="fas fa-tags"></i>
                        @else <i class="fas fa-shield-alt"></i>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold mb-2" style="color: var(--card-heading);">@lang('messages.why_us_'.$i.'_title')</h3>
                    <p style="color: var(--card-text);">@lang('messages.why_us_'.$i.'_desc')</p>
                </div>
                @endfor
            </div>
        </div>
    </section>

    {{-- ========== ۵.۵. د مشتریانو نظرونه ========== --}}
    @if($testimonials->count() > 0)
    <section id="testimonials" class="py-20 px-4 scroll-mt-24">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">@lang('messages.testimonials')</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($testimonials as $testimonial)
                <div class="section-card text-center hover:scale-105 transition duration-300 card-3d"
                     data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                     onmousemove="tiltCard(event, this)" onmouseleave="resetTilt(this)">
                    @if($testimonial->image)
                        <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}" class="w-24 h-24 object-cover rounded-full mx-auto mb-6 border-4" style="border-color: var(--primary);">
                    @else
                        <div class="w-24 h-24 rounded-full mx-auto mb-6 border-4 flex items-center justify-center text-2xl" style="border-color: var(--primary); background: var(--card-bg); color: var(--card-text);">👤</div>
                    @endif
                    <div class="text-yellow-400 mb-4 text-xl">
                        @for($s = 1; $s <= 5; $s++)
                            @if($s <= $testimonial->rating) ★ @else ☆ @endif
                        @endfor
                    </div>
                    <p class="mb-4 italic" style="color: var(--card-text);">"{{ $testimonial->comment }}"</p>
                    <h3 class="text-lg font-bold" style="color: var(--card-heading);">{{ $testimonial->name }}</h3>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ========== ۶. د ټیم غړي ========== --}}
    @if($teamMembers->count() > 0)
    <section id="team" class="py-20 px-4 scroll-mt-24" style="background: var(--section-alt-bg);">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">@lang('messages.our_team')</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($teamMembers as $member)
                <div class="section-card text-center hover:scale-105 transition duration-300 card-3d"
                     data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                     onmousemove="tiltCard(event, this)" onmouseleave="resetTilt(this)">
                    @if($member->image)
                        <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}" class="w-24 h-24 object-cover rounded-full mx-auto mb-6 border-4" style="border-color: var(--primary);">
                    @else
                        <div class="w-24 h-24 rounded-full mx-auto mb-6 border-4 flex items-center justify-center text-2xl" style="border-color: var(--primary); background: var(--card-bg); color: var(--card-text);">👤</div>
                    @endif
                    <h3 class="text-lg font-bold" style="color: var(--card-heading);">{{ $member->name }}</h3>
                    <p class="text-sm mb-4" style="color: var(--card-text);">{{ $member->position }}</p>
                    @if($member->whatsapp_number)
                        <a href="https://wa.me/{{ $member->whatsapp_number }}" target="_blank" class="inline-flex items-center gap-1 text-sm bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition">
                            <i class="fab fa-whatsapp"></i> @lang('messages.whatsapp')
                        </a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ========== ۷. اعلانونه ========== --}}
    @if($ads->count() > 0)
    <section id="ads" class="py-20 px-4 scroll-mt-24">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">@lang('messages.fresh_ads')</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($ads as $ad)
                <div class="section-card overflow-hidden hover:scale-105 transition duration-300 card-3d"
                     data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                     onmousemove="tiltCard(event, this)" onmouseleave="resetTilt(this)">
                    @if($ad->video_url)
                        <div class="relative" style="padding-top: 56.25%">
                            <iframe class="absolute inset-0 w-full h-full" src="{{ $ad->video_url }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @elseif($ad->image)
                        <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title['ps'] ?? '' }}" class="w-full h-52 object-cover">
                    @else
                        <div class="w-full h-52 flex items-center justify-center" style="background: var(--card-bg); color: var(--card-text);">@lang('messages.no_image')</div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-2" style="color: var(--card-heading);">{{ $ad->title[app()->getLocale()] ?? $ad->title['ps'] ?? '' }}</h3>
                        <p class="mb-4" style="color: var(--card-text);">{{ Str::limit($ad->description[app()->getLocale()] ?? $ad->description['ps'] ?? '', 80) }}</p>
                        @if($ad->price)
                            <div class="text-2xl font-bold mb-4" style="color: var(--primary);">${{ $ad->price }}</div>
                        @endif
                        <a href="{{ route('ads.show', $ad) }}" class="btn-primary px-6 py-2 rounded-full text-sm font-semibold inline-block">@lang('messages.details')</a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('ads.index') }}" class="inline-block px-8 py-3 rounded-full text-lg font-semibold transition" style="background: var(--glass-bg); border: 1px solid var(--glass-border); color: var(--body-text);">@lang('messages.view_all_ads')</a>
            </div>
        </div>
    </section>
    @endif

    {{-- ========== ۸. FAQ ========== --}}
    @if($faqs->count() > 0)
    <section id="faqs" class="py-20 px-4 scroll-mt-24" style="background: var(--section-alt-bg);">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">@lang('messages.faq')</h2>
            <div class="space-y-6">
                @foreach($faqs as $faq)
                <div class="section-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <button class="w-full flex justify-between items-center px-6 py-4 text-right font-semibold transition rounded-xl" style="color: var(--body-text);" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('i').classList.toggle('fa-chevron-down'); this.querySelector('i').classList.toggle('fa-chevron-up');">
                        <span>{{ $faq->question[app()->getLocale()] ?? $faq->question['ps'] }}</span>
                        <i class="fas fa-chevron-down transition" style="color: var(--primary);"></i>
                    </button>
                    <div class="hidden px-6 pb-4" style="color: var(--card-text);">
                        {{ $faq->answer[app()->getLocale()] ?? $faq->answer['ps'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ========== ۹. ګالري ========== --}}
    @if($galleries->count() > 0)
    <section id="galleries" class="py-20 px-4 scroll-mt-24">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">@lang('messages.gallery')</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($galleries as $gallery)
                <div class="relative group overflow-hidden rounded-2xl section-card" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}">
                    @if($gallery->type == 'image')
                        <img src="{{ asset('storage/' . $gallery->url) }}" alt="{{ $gallery->caption['ps'] ?? '' }}" class="w-full h-48 object-contain transition transform group-hover:scale-110">
                    @else
                        <a href="{{ $gallery->url }}" target="_blank" class="block w-full h-48 flex items-center justify-center" style="background: var(--card-bg);">
                            <i class="fas fa-play-circle text-6xl hover:scale-110 transition" style="color: var(--primary);"></i>
                        </a>
                    @endif
                    @if( ($gallery->caption[app()->getLocale()] ?? $gallery->caption['ps'] ?? '') )
                    <div class="absolute bottom-0 left-0 right-0 bg-black/70 text-white text-xs px-3 py-2">
                        {{ $gallery->caption[app()->getLocale()] ?? $gallery->caption['ps'] }}
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ========== ۱۰. اړیکه ========== --}}
    <section id="contact" class="py-20 px-4 scroll-mt-24" style="background: var(--section-alt-bg);">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-6" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">@lang('messages.contact')</h2>
            <p class="text-center mb-12" style="color: var(--card-text);">@lang('messages.contact_form_title')</p>
            
            @if(session('success'))
                <div class="bg-green-500/20 border border-green-500 text-green-200 px-4 py-3 rounded-xl mb-8">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.submit') }}" method="POST" class="section-card" data-aos="fade-up">
                @csrf
                <div class="mb-6">
                    <label class="block font-medium mb-2" style="color: var(--body-text);">@lang('messages.name') *</label>
                    <input type="text" name="name" class="w-full" required>
                </div>
                <div class="mb-6">
                    <label class="block font-medium mb-2" style="color: var(--body-text);">@lang('messages.email_optional')</label>
                    <input type="email" name="email" class="w-full">
                </div>
                <div class="mb-6">
                    <label class="block font-medium mb-2" style="color: var(--body-text);">@lang('messages.phone_optional')</label>
                    <input type="text" name="phone" class="w-full">
                </div>
                <div class="mb-8">
                    <label class="block font-medium mb-2" style="color: var(--body-text);">@lang('messages.message') *</label>
                    <textarea name="message" rows="5" class="w-full" required></textarea>
                </div>
                <button type="submit" class="btn-primary w-full py-4 rounded-xl font-bold text-lg">
                    @lang('messages.send_message')
                </button>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // 3D Tilt effect for cards
    function tiltCard(event, card) {
        const rect = card.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        const halfWidth = rect.width / 2;
        const halfHeight = rect.height / 2;
        const angleX = -(y - halfHeight) / 10;
        const angleY = (x - halfWidth) / 10;
        card.style.transform = `perspective(1000px) rotateX(${angleX}deg) rotateY(${angleY}deg) scale(1.02)`;
    }
    function resetTilt(card) {
        card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)';
    }
</script>

<style>
    /* ==================== د موبایل لپاره بکګراونډ عکس ==================== */
    @media (max-width: 767px) {
        .hero-section {
            background-size: contain !important;
            background-color: #0a0f1d !important;
        }
    }

    /* ==================== د متحرک څراغونو انیمیشن ==================== */
    .particle {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: linear-gradient(135deg, #00d2ff, #0066ff);
        box-shadow: 0 0 15px rgba(0, 210, 255, 0.5);
        animation: floatParticle 4s ease-in-out infinite;
        opacity: 0;
    }

    /* د هر ذرې لپاره ځانګړی ځنډ او اندازه */
    .particle-1 { animation-delay: 0s; width: 8px; height: 8px; }
    .particle-2 { animation-delay: 0.4s; width: 5px; height: 5px; }
    .particle-3 { animation-delay: 0.8s; width: 10px; height: 10px; background: linear-gradient(135deg, #ff6b6b, #ffd93d); }
    .particle-4 { animation-delay: 1.2s; width: 6px; height: 6px; }
    .particle-5 { animation-delay: 1.6s; width: 4px; height: 4px; background: linear-gradient(135deg, #6bcb77, #00d2ff); }
    .particle-6 { animation-delay: 2s; width: 9px; height: 9px; }
    .particle-7 { animation-delay: 2.4s; width: 5px; height: 5px; background: linear-gradient(135deg, #ffd93d, #ff6b6b); }
    .particle-8 { animation-delay: 2.8s; width: 7px; height: 7px; }
    .particle-9 { animation-delay: 0.6s; width: 3px; height: 3px; background: linear-gradient(135deg, #0066ff, #00d2ff); }
    .particle-10 { animation-delay: 1s; width: 11px; height: 11px; }
    .particle-11 { animation-delay: 1.8s; width: 5px; height: 5px; background: linear-gradient(135deg, #ff6b6b, #ffd93d); }
    .particle-12 { animation-delay: 2.2s; width: 8px; height: 8px; }

    .particle-13 { animation-delay: 0.2s; width: 7px; height: 7px; }
    .particle-14 { animation-delay: 0.6s; width: 4px; height: 4px; background: linear-gradient(135deg, #6bcb77, #00d2ff); }
    .particle-15 { animation-delay: 1s; width: 10px; height: 10px; }
    .particle-16 { animation-delay: 1.4s; width: 5px; height: 5px; }
    .particle-17 { animation-delay: 1.8s; width: 8px; height: 8px; background: linear-gradient(135deg, #ffd93d, #ff6b6b); }
    .particle-18 { animation-delay: 2.2s; width: 3px; height: 3px; }
    .particle-19 { animation-delay: 2.6s; width: 9px; height: 9px; background: linear-gradient(135deg, #00d2ff, #0066ff); }
    .particle-20 { animation-delay: 0.4s; width: 6px; height: 6px; }
    .particle-21 { animation-delay: 1.2s; width: 4px; height: 4px; background: linear-gradient(135deg, #ff6b6b, #ffd93d); }
    .particle-22 { animation-delay: 1.6s; width: 11px; height: 11px; }
    .particle-23 { animation-delay: 2.4s; width: 5px; height: 5px; background: linear-gradient(135deg, #6bcb77, #00d2ff); }
    .particle-24 { animation-delay: 2.8s; width: 7px; height: 7px; }

    @keyframes floatParticle {
        0% {
            opacity: 0;
            transform: translateY(20px) scale(0.3) rotate(0deg);
        }
        25% {
            opacity: 0.8;
            transform: translateY(-10px) scale(1) rotate(90deg);
        }
        50% {
            opacity: 1;
            transform: translateY(-30px) scale(1.2) rotate(180deg);
        }
        75% {
            opacity: 0.6;
            transform: translateY(-15px) scale(0.8) rotate(270deg);
        }
        100% {
            opacity: 0;
            transform: translateY(20px) scale(0.3) rotate(360deg);
        }
    }

    /* ==================== د څپو انیمیشن ==================== */
    .wave-particle {
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: rgba(0, 210, 255, 0.4);
        animation: waveMove 5s ease-in-out infinite;
    }
    .wave-particle:nth-child(1) { animation-delay: 0s; }
    .wave-particle:nth-child(2) { animation-delay: 0.5s; }
    .wave-particle:nth-child(3) { animation-delay: 1s; }
    .wave-particle:nth-child(4) { animation-delay: 1.5s; }
    .wave-particle:nth-child(5) { animation-delay: 2s; }
    .wave-particle:nth-child(6) { animation-delay: 2.5s; }
    .wave-particle:nth-child(7) { animation-delay: 3s; }
    .wave-particle:nth-child(8) { animation-delay: 3.5s; }

    @keyframes waveMove {
        0% {
            opacity: 0.1;
            transform: translateY(0) scale(0.5);
        }
        25% {
            opacity: 0.6;
            transform: translateY(-20px) scale(1.5);
        }
        50% {
            opacity: 0.3;
            transform: translateY(0) scale(1);
        }
        75% {
            opacity: 0.7;
            transform: translateY(20px) scale(1.8);
        }
        100% {
            opacity: 0.1;
            transform: translateY(0) scale(0.5);
        }
    }

    /* ==================== د موبایل لپاره ځانګړی تنظیم ==================== */
    @media (max-width: 767px) {
        .particle {
            width: 4px !important;
            height: 4px !important;
        }
        .particle-3, .particle-7, .particle-10, .particle-15, .particle-19, .particle-22 {
            width: 6px !important;
            height: 6px !important;
        }
        .wave-particle {
            width: 3px !important;
            height: 3px !important;
        }
        .mobile-particles .absolute {
            opacity: 1;
        }
        @keyframes floatParticle {
            0% {
                opacity: 0;
                transform: translateY(15px) scale(0.5);
            }
            30% {
                opacity: 0.7;
                transform: translateY(-5px) scale(1);
            }
            60% {
                opacity: 0.9;
                transform: translateY(-20px) scale(1.1);
            }
            100% {
                opacity: 0;
                transform: translateY(15px) scale(0.5);
            }
        }
    }

    /* د کمپیوټر لپاره انیمیشن پټول (که وغواړئ) – خو دلته ساتل شوی */
    @media (min-width: 768px) {
        .mobile-particles .particle,
        .mobile-particles .wave-particle {
            opacity: 0.3;
        }
        .mobile-particles .particle:hover {
            opacity: 0.8;
        }
    }
</style>
@endpush