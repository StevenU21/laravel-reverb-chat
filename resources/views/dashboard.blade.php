<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 h-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                <div class="p-6 bg-white border-b border-gray-200 h-full flex flex-col">
                    <h1 class="text-3xl font-bold text-gray-800 leading-tight mb-4">Feed</h1>
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md flex-grow">
                        <h2 class="text-xl font-semibold text-gray-700 mb-2">User List</h2>
                        <ul class="list-disc list-inside space-y-2">
                            @foreach ($users as $user)
                                <li
                                    class="text-gray-600 flex flex-col sm:flex-row items-start sm:items-center justify-between">
                                    <span class="mb-2 sm:mb-0">{{ $user->name }}</span>
                                    <form action="{{ route('conversations.store') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-700 text-gray-100 font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105">
                                            Create Conversation
                                        </button>
                                    </form>

                                    {{-- @livewire('create-conversation', ['userId' => $user->id]) --}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
