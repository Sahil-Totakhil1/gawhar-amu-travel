@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold dark:text-white text-gray-800">@lang('messages.message_detail')</h1>
        <a href="{{ route('admin.messages.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">← @lang('messages.back_to_list')</a>
    </div>
    
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">@lang('messages.name'):</span>
                    <p class="text-gray-900 dark:text-gray-100">{{ $message->name }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">@lang('messages.email'):</span>
                    <p class="text-gray-900 dark:text-gray-100">{{ $message->email ?? '--' }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">@lang('messages.phone'):</span>
                    <p class="text-gray-900 dark:text-gray-100">{{ $message->phone ?? '--' }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">@lang('messages.status'):</span>
                    <span class="px-2 py-1 text-xs rounded-full {{ $message->is_read ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-200' }}">
                        {{ $message->is_read ? __('messages.read') : __('messages.new') }}
                    </span>
                </div>
            </div>
            <div class="border-t dark:border-gray-700 pt-4">
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">@lang('messages.message'):</span>
                <div class="mt-2 text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $message->message }}</div>
            </div>
        </div>
        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-3 flex justify-end">
            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('@lang('messages.confirm_delete')')">
                    🗑️ @lang('messages.delete')
                </button>
            </form>
        </div>
    </div>
</div>
@endsection