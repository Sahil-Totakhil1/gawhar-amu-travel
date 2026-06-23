@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold dark:text-white text-gray-800">@lang('messages.all_destinations')</h1>
        
        {{-- د نوی منزل تڼۍ - یوازې هغو ته چې د destinations واک لري --}}
        @if(auth()->user()->hasPermissionTo('destinations'))
            <a href="{{ route('admin.destinations.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                @lang('messages.new_destination')
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($destinations->count() > 0)
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">@lang('messages.image')</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">@lang('messages.title')</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">@lang('messages.description')</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">@lang('messages.status')</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">@lang('messages.actions')</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($destinations as $destination)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($destination->image)
                                <img src="{{ asset('storage/' . $destination->image) }}" class="h-10 w-10 object-cover rounded">
                            @else
                                <span class="text-gray-400 dark:text-gray-500">--</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $destination->title[app()->getLocale()] ?? $destination->title['ps'] ?? '' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ Str::limit($destination->description[app()->getLocale()] ?? $destination->description['ps'] ?? '', 50) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $destination->is_active ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-200' }}">
                                {{ $destination->is_active ? __('messages.active') : __('messages.inactive') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2 rtl:space-x-reverse">
                            {{-- Edit تڼۍ - یوازې که کاروونکی د destinations واک ولري --}}
                            @if(auth()->user()->hasPermissionTo('destinations'))
                                <a href="{{ route('admin.destinations.edit', $destination) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">@lang('messages.edit')</a>
                            @endif

                            {{-- Delete تڼۍ - یوازې که کاروونکی د destinations واک ولري --}}
                            @if(auth()->user()->hasPermissionTo('destinations'))
                                <form action="{{ route('admin.destinations.destroy', $destination) }}" method="POST" class="inline">
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
            {{ $destinations->links() }}
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8 text-center">
            <p class="text-gray-500 dark:text-gray-400 text-lg">@lang('messages.no_destinations')</p>
        </div>
    @endif
</div>
@endsection