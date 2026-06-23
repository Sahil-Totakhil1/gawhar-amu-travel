@extends('layouts.app')

@section('content')
<div class="py-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">@lang('messages.about')</h1>
    <div class="bg-white shadow-md rounded-lg p-8 text-gray-700 leading-8 text-lg">
        {{ $aboutText[app()->getLocale()] ?? $aboutText['ps'] ?? __('messages.about_short') }}
    </div>
</div>
@endsection