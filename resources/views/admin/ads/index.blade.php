@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold dark:text-white text-gray-800">@lang('messages.all_ads')</h1>
        
        {{-- د نوي اعلان تڼۍ - یوازې هغو ته چې د ads واک لري --}}
        @if(auth()->user()->hasPermissionTo('ads'))
            <a href="{{ route('admin.ads.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                @lang('messages.new_ad')
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">@lang('messages.image')</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">@lang('messages.title')</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">@lang('messages.category')</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">@lang('messages.price')</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">@lang('messages.status')</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">@lang('messages.views')</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">@lang('messages.actions')</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($ads as $ad)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($ad->image)
                            <img src="{{ asset('storage/' . $ad->image) }}" class="h-10 w-10 object-cover rounded">
                        @else
                            <span class="text-gray-400 dark:text-gray-500">--</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                        {{ $ad->title[app()->getLocale()] ?? $ad->title['ps'] ?? '' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $ad->category }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                        {{ $ad->price ? '$' . $ad->price : '--' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ad->status == 'active' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-200' }}">
                            {{ $ad->status == 'active' ? __('messages.active') : __('messages.inactive') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $ad->views }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2 rtl:space-x-reverse">
                        {{-- View تڼۍ --}}
                        @if(auth()->user()->hasPermissionTo('ads'))
                            <a href="{{ route('admin.ads.show', $ad) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">@lang('messages.view')</a>
                        @endif

                        {{-- Edit تڼۍ - یوازې که Admin وي یا خپل اعلان وي --}}
                        @if(auth()->user()->hasPermissionTo('ads') && (auth()->user()->role === 'admin' || $ad->user_id === auth()->id()))
                            <a href="{{ route('admin.ads.edit', $ad) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">@lang('messages.edit')</a>
                        @endif

                        {{-- Delete تڼۍ - یوازې که Admin وي یا خپل اعلان وي --}}
                        @if(auth()->user()->hasPermissionTo('ads') && (auth()->user()->role === 'admin' || $ad->user_id === auth()->id()))
                            <form action="{{ route('admin.ads.destroy', $ad) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('@lang('messages.confirm_delete')')">@lang('messages.delete')</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $ads->links() }}
    </div>
</div>
@endsection