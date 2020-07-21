@extends('layouts.base')

@section('body')
    <nav class="bg-gray-700">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex items-center flex-shrink-0">
                        <a href="{{ route('home') }}" class="text-xl font-semibold text-white">Game Manager</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="flex-shrink-0 hidden md:block">
                        <span class="rounded-md shadow-sm">
                            <a href="{{ route('add') }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-indigo-500 border border-transparent rounded-md hover:bg-indigo-400 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-600 active:bg-indigo-600">
                                <svg class="w-5 h-5 mr-2 -ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                <span>Add Game</span>
                            </a>
                        </span>
                    </div>
                    <div class="md:ml-4 md:flex-shrink-0 md:flex md:items-center">
                        <!-- Profile dropdown -->
                        <div class="relative ml-3" x-data="{ isOpen: false }">
                            <div>
                                <button @click="isOpen = !isOpen" class="flex text-sm text-white transition duration-150 ease-in-out rounded-full focus:outline-none focus:text-green-300 hover:text-green-300" id="user-menu" aria-label="User menu" aria-haspopup="true">
                                    <x-heroicon-o-user-circle class="w-8 h-8"/>
                                </button>
                            </div>
                            <div
                                x-show="isOpen"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                @click.away="isOpen = false"
                                class="absolute right-0 z-50 w-48 mt-2 origin-top-right rounded-md shadow-lg"
                                x-cloak
                            >
                                <div class="py-1 bg-white rounded-md shadow-xs" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                                    <div class="px-4 py-2">
                                        <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                                        <div class="text-xs font-medium text-gray-400">{{ Auth::user()->email }}</div>
                                    </div>
                                    <a @click.prevent="$refs.logoutForm.submit();" href="{{ route('logout') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100" role="menuitem">Sign out</a>
                                    <form x-ref="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        @yield('content')
    </div>
@endsection
