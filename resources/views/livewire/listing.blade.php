<div>
@if (session('status'))
    <div x-data="{ showMsg: true }">
        <div
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="transform opacity-100"
            x-transition:leave-end="transform opacity-0"
            x-show="showMsg"
            class="p-4 mt-4 bg-white rounded-md"
        >
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium leading-5 text-green-800">
                        {{ session('status') }}
                    </p>
                </div>
                <div class="pl-3 ml-auto">
                    <div class="-mx-1.5 -my-1.5">
                        <button @click="showMsg = false" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:bg-green-100 transition ease-in-out duration-150">
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
    <div class="flex h-screen overflow-hidden bg-gray-100">
        <div class="hidden sm:flex sm:flex-shrink-0">
            <div class="flex flex-col w-64 pt-5 pb-4">
                <div class="flex flex-col mt-5 overflow-y-auto">
                    <div class="mb-4">
                        <label for="player-count" class="block text-sm font-medium leading-5 text-gray-700">
                            Player Count
                        </label>
                        <select
                            id="player-count"
                            wire:model="filter.players"
                            wire:change="loadList"
                            class="block w-full py-2 pl-3 pr-10 mt-1 text-base leading-6 border-gray-300 form-select focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5"
                        >
                            <option selected>All</option>
                        @for ($i = 1; $i < 6; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                            <option value="6">6+</option>
                        </select>
                    </div>
                    <div>
                        <label for="playtime" class="block text-sm font-medium leading-5 text-gray-700">
                            Playtime
                        </label>
                        <select
                            id="playtime"
                            wire:model="filter.playtime"
                            wire:change="loadList"
                            class="block w-full py-2 pl-3 pr-10 mt-1 text-base leading-6 border-gray-300 form-select focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5"
                        >
                            <option selected>Any</option>
                            <option value="29">less than 30 min</option>
                            <option value="59">less than 1 hour</option>
                            <option value="119">less than 2 hours</option>
                        </select>
                    </div>
                    <span class="inline-flex mt-5 rounded-md shadow-sm">
                        <button
                            type="button"
                            wire:click="resetFilters"
                            class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150"
                        >
                            Reset
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <main class="relative z-0 flex-1 overflow-y-auto focus:outline-none" tabindex="0" x-data="{ modalOpen: {{ $modal_open ? 'true' : 'false' }} }">
            <div class="pt-2 pb-6 md:py-6">
                <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">
                    <ul class="grid grid-cols-1 gap-5 mt-3 sm:gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($games as $game)
                        <li
                            wire:click="viewGame({{ $game->id }})"
                            class="flex items-center col-span-1 p-2 overflow-hidden transition duration-150 ease-in-out bg-white border border-gray-200 rounded-md shadow-sm cursor-pointer hover:border-gray-400"
                        >
                            <div class="flex items-center flex-shrink-0 w-16 h-16">
                                <img class="w-full h-16 object-contain" src="{{ $game->image }}" alt="">
                            </div>
                            <div class="flex-1 px-4 truncate">
                                <p class="text-sm font-medium leading-5 text-gray-900 transition duration-150 ease-in-out hover:text-gray-600">{{ $game->title }}</p>
                                <p class="text-sm leading-5 text-gray-500">
                                    <x-heroicon-o-user-group class="inline w-5 h-5 mr-1 text-gray-400"/>
                                    <span class="font-semibold">{{ $game->players_range }}</span> players
                                </p>
                                <p class="text-sm leading-5 text-gray-500">
                                    <x-heroicon-o-clock class="inline w-5 h-5 mr-1 text-gray-400"/>
                                    <span class="font-semibold">{{ $game->playtime_range }}</span> minutes
                                </p>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        @if ($modal_open)
            <div x-show="modalOpen" class="fixed inset-x-0 bottom-0 px-4 pb-6 sm:inset-0 sm:p-0 sm:flex sm:items-center sm:justify-center" x-cloak>
                <div
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 transition-opacity"
                >
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <div
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    @click.away="@this.set('modal_open', false)"
                    class="px-4 pt-5 pb-4 overflow-hidden transition-all transform bg-white rounded-lg shadow-xl sm:max-w-6xl sm:w-full sm:p-6"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="modal-headline"
                >
                <div class="flex justify-between w-full p-6 space-x-6">
                    <div class="flex-shrink-0">
                        <img class="mb-6" src="{{ $selected_game->image }}" alt="">
                        <div class="mb-2">
                            <a
                                href="{{ route('edit', ['game' => $selected_game->id]) }}"
                                class="text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out hover:text-indigo-500 focus:outline-none active:text-indigo-800"
                            >
                                <x-heroicon-o-pencil class="inline w-4 h-4 mr-1"/> Edit
                            </a>
                        </div>
                        <div>
                            <button
                                wire:click="removeGame"
                                type="button"
                                class="text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out hover:text-red-500 focus:outline-none active:text-red-800"
                            >
                                <x-heroicon-o-trash class="inline w-4 h-4 mr-1"/> Remove
                            </button>
                        </div>
                    </div>
                    <div>
                        <h3 class="mb-4 text-lg font-medium leading-5 text-gray-900">{{ $selected_game->title }} <span class="text-gray-500">({{ $selected_game->year }})</span></h3>
                        <div class="mt-1 space-x-6 text-sm leading-5 text-gray-500">
                            <span>
                                <x-heroicon-o-user-group class="inline w-6 h-6 mr-1"/>
                                <span class="font-semibold">{{ $selected_game->players_range }}</span> players
                            </span>
                            <span>
                                <x-heroicon-o-clock class="inline w-6 h-6 mr-1"/>
                                <span class="font-semibold">{{ $selected_game->playtime_range }}</span> minutes
                            </span>
                        @if ($selected_game->rating)
                            <span>
                                <x-heroicon-o-fire class="inline w-6 h-6 mr-1"/>
                                <span class="font-semibold">{{ $selected_game->rating }}</span>/10 rating
                            </span>
                        @endif
                        @if ($selected_game->rating)
                            <span>
                                <x-heroicon-o-puzzle class="inline w-6 h-6 mr-1"/>
                                <span class="font-semibold">{{ $selected_game->complexity }}</span>/5 complexity
                            </span>
                        @endif
                        </div>
                        <div class="mt-4 space-x-6 text-sm leading-5 text-gray-500">
                            <span class="font-semibold">Categories:</span> {{ $selected_game->category_display }}
                        </div>
                        <p class="hidden mt-4 text-sm leading-4 text-gray-500 sm:block">{!! nl2br(e($selected_game->description)) !!}</p>
                    </div>
                    <x-heroicon-o-x @click="@this.set('modal_open', false)" class="absolute w-6 h-6 cursor-pointer top-4 right-4 hover:text-gray-500"/>
                </div>
            </div>
        @endif
        </main>
    </div>
</div>
