@extends('layouts.app')

@section('content')
<div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-center text-primary mb-12">@lang('messages.packages')</h1>
    @if($packages->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($packages as $package)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                @if($package->image)
                    <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->title['ps'] ?? '' }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">@lang('messages.no_image')</div>
                @endif
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">
                        {{ $package->title[app()->getLocale()] ?? $package->title['ps'] }}
                    </h3>
                    <div class="flex items-center text-gray-600 mb-2">
                        @if($package->destination)
                            <span class="mr-3">📍 {{ $package->destination }}</span>
                        @endif
                        @if($package->duration)
                            <span>⏱️ {{ $package->duration }}</span>
                        @endif
                    </div>
                    <p class="text-gray-600 mb-4">
                        {{ Str::limit($package->description[app()->getLocale()] ?? $package->description['ps'] ?? '', 80) }}
                    </p>
                    @if($package->price)
                        <div class="text-2xl font-bold text-green-600">${{ $package->price }}</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-10">
            {{ $packages->links() }}
        </div>
    @else
        <p class="text-center text-gray-500">@lang('messages.no_packages')</p>
    @endif
</div>
@endsection