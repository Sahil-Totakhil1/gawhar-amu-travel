@extends('layouts.app')

@section('content')
<div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-center text-primary mb-12">@lang('messages.services')</h1>
    @if($services->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($services as $service)
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-xl transition" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                @if($service->icon)
                    <div class="text-4xl text-blue-600 mb-4"><i class="{{ $service->icon }}"></i></div>
                @endif
                <h3 class="text-xl font-semibold text-gray-800 mb-2">
                    {{ $service->title[app()->getLocale()] ?? $service->title['ps'] }}
                </h3>
                <p class="text-gray-600">
                    {{ $service->description[app()->getLocale()] ?? $service->description['ps'] ?? '' }}
                </p>
            </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-500">@lang('messages.no_services')</p>
    @endif
</div>
@endsection