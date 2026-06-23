@extends('layouts.app')

@section('content')
<div class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-bold text-center mb-12" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        @lang('messages.ads')
    </h1>

    @if(isset($categories))
    <div class="flex justify-center mb-12 flex-wrap gap-3">
        <a href="{{ route('ads.index') }}" 
           class="px-5 py-2 rounded-full text-sm font-medium transition duration-300 
                  {{ !request('category') ? 'btn-primary' : '' }}"
           style="{{ !request('category') ? '' : 'background: var(--glass-bg); border: 1px solid var(--glass-border); color: var(--body-text);' }}">
            @lang('messages.all')
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('ads.index', ['category' => $cat]) }}" 
           class="px-5 py-2 rounded-full text-sm font-medium transition duration-300 
                  {{ request('category') == $cat ? 'btn-primary' : '' }}"
           style="{{ request('category') == $cat ? '' : 'background: var(--glass-bg); border: 1px solid var(--glass-border); color: var(--body-text);' }}">
            {{ $cat }}
        </a>
        @endforeach
    </div>
    @endif

    @if($ads->count() > 0)
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
                    <h3 class="text-xl font-bold mb-2" style="color: var(--card-heading);">{{ $ad->title[app()->getLocale()] ?? $ad->title['ps'] ?? '' }}</h3>
                    <p class="mb-4 text-sm" style="color: var(--card-text);">{{ Str::limit($ad->description[app()->getLocale()] ?? $ad->description['ps'] ?? '', 80) }}</p>
                    <div class="flex items-center text-sm mb-4" style="color: var(--card-text);">
                        @if($ad->price) <span class="mr-4 font-bold" style="color: var(--primary);">${{ $ad->price }}</span> @endif
                        @if($ad->location) <span><i class="fas fa-map-marker-alt" style="color: var(--primary);"></i> {{ $ad->location }}</span> @endif
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t" style="border-color: var(--glass-border);">
                        <span class="text-xs" style="color: var(--card-text);">👁 {{ $ad->views }} @lang('messages.views')</span>
                        <a href="{{ route('ads.show', $ad) }}" class="btn-primary px-4 py-2 rounded-full text-sm font-semibold inline-block">@lang('messages.details')</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-12">
            {{ $ads->links() }}
        </div>
    @else
        <div class="text-center py-20">
            <div class="text-6xl mb-6" style="color: var(--card-text);">📋</div>
            <p class="text-xl" style="color: var(--card-text);">@lang('messages.no_ads')</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
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
@endpush