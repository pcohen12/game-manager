<div>
    <h2 class="py-8 text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
      Add Game
    </h2>
    <form wire:submit.prevent="addGame" class="w-full mb-12">
        <div class="grid grid-cols-2 row-gap-6 col-gap-4 mb-4 sm:grid-cols-12">
            <div class="col-span-2 sm:col-span-6">
                <label for="game-title" class="form-input-label">
                    Title *
                </label>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <input type="text" id="game-title" wire:keydown.debounce.500ms="getGameTitles($event.target.value)" wire:model.lazy="title" class="form-input form-text-input" aria-describedby="game-title-description">
                @if ($game_suggestions)
                    <div class="w-full mt-1 bg-white rounded-md shadow-lg" x-data="{ selected: null }">
                        <ul
                            tabindex="-1"
                            role="listbox"
                            class="py-1 overflow-auto text-base leading-6 rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5"
                            @keydown.arrow-up.prevent="selected = selected - 1"
                            @keydown.arrow-down.prevent="selected = selected + 1"
                        >
                    @foreach ($game_suggestions as $idx => $game)
                            <li
                                wire:click="chooseGame({{ $game['id'] }})"
                                wire:keydown.enter="chooseGame({{ $game['id'] }})"
                                @mouseenter="selected = {{ $idx }}"
                                @mouseleave="selected = null"
                                :class="{ 'text-white bg-indigo-600': {{ $idx }} === selected, 'text-gray-900': {{ $idx }} !== selected }"
                                class="relative py-2 pl-3 transition-none cursor-pointer select-none pr-9"
                            >
                                <div class="flex space-x-2">
                                    <span :class="{ 'font-semibold': {{ $idx }} === selected, 'font-normal': {{ $idx }} !== selected }" class="truncate transition-none">
                                        {{ $game['label'] }}
                                    </span>
                                @if ($game['year'])
                                    <span :class="{ 'text-indigo-200': {{ $idx }} === selected, 'text-gray-500': {{ $idx }} !== selected }" class="truncate transition-none" >
                                        {{ $game['year'] }}
                                    </span>
                                @endif
                                </div>
                            </li>
                    @endforeach
                        </ul>
                    </div>
                @endif
                </div>
                <p class="mt-2 text-sm text-gray-500" id="game-title-description">Type at least 3 characters to return results from BGG's database.</p>
                @error('title') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div class="sm:col-span-3">
                <label for="game-year" class="form-input-label">
                    Year
                </label>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <input type="text" id="game-year" wire:model.lazy="year" class="form-input form-text-input">
                </div>
            </div>
            <div class="sm:col-span-3">
                <label for="bgg-id" class="form-input-label">
                    BGG ID
                </label>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <input type="text" id="bgg-id" wire:model.lazy="bgg_id" class="form-input form-text-input">
                </div>
            </div>
            <div class="col-span-2 sm:col-span-12">
                <label for="image-url" class="form-input-label">
                    Image URL
                </label>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <input type="text" id="image-url" wire:model.lazy="image" class="form-input form-text-input">
                </div>
                @if ($this->hasImage)
                    <img src="{{ $image }}" class="mt-4 rounded-md">
                @endif
            </div>
            <div class="col-span-2 sm:col-span-12">
                <label for="description" class="form-input-label">
                    Description
                </label>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <textarea id="description" wire:model.lazy="description" rows="10" class="form-textarea form-text-input"></textarea>
                </div>
            </div>
            <div class="sm:col-span-2">
                <label for="min-players" class="form-input-label">
                    Min Players
                </label>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <input id="min-players" type="text" wire:model.lazy="players_min" class="form-input form-text-input">
                </div>
            </div>
            <div class="sm:col-span-2">
                <label for="max-players" class="form-input-label">
                    Max Players
                </label>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <input id="max-players" type="text" wire:model.lazy="players_max" class="form-input form-text-input">
                </div>
            </div>
            <div class="sm:col-span-2">
                <label for="min-playtime" class="form-input-label">
                    Min Playtime
                </label>
                <div class="relative flex mt-1 rounded-md shadow-sm">
                    <input id="min-playtime" type="text" wire:model.lazy="playtime_min" class="rounded-r-none form-input form-text-input">
                    <span class="inline-flex items-center px-3 text-gray-500 border border-l-0 border-gray-300 rounded-r-md bg-gray-50 sm:text-sm">
                        minutes
                    </span>
                </div>
            </div>
            <div class="sm:col-span-2">
                <label for="max-playtime" class="form-input-label">
                    Max Playtime
                </label>
                <div class="relative flex mt-1 rounded-md shadow-sm">
                    <input id="max-playtime" type="text" wire:model.lazy="playtime_max" class="rounded-r-none form-input form-text-input">
                    <span class="inline-flex items-center px-3 text-gray-500 border border-l-0 border-gray-300 rounded-r-md bg-gray-50 sm:text-sm">
                        minutes
                    </span>
                </div>
            </div>
            <div class="sm:col-span-2">
                <label for="complexity" class="form-input-label">
                    Complexity
                </label>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <input id="complexity" type="text" wire:model.lazy="complexity" class="form-input form-text-input">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <span class="text-gray-500 sm:text-sm sm:leading-5">
                            /5
                        </span>
                    </div>
                </div>
            </div>
            <div class="sm:col-span-2">
                <label for="rating" class="form-input-label">
                    Rating
                </label>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <input id="rating" type="text" wire:model.lazy="rating" class="form-input form-text-input">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <span class="text-gray-500 sm:text-sm sm:leading-5">
                            /10
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-span-2 sm:col-span-12">
                <label for="categories" class="form-input-label">
                    Categories
                </label>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <input id="categories" type="text" wire:model.lazy="categories" class="form-input form-text-input">
                </div>
            </div>
            <div class="col-span-2 sm:col-span-12">
                <label for="notes" class="form-input-label">
                    Notes
                </label>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <textarea id="notes" wire:model.lazy="notes" rows="3" class="form-textarea form-text-input"></textarea>
                </div>
            </div>
        </div>
        <span class="inline-flex rounded-md shadow-sm">
            <button type="submit" class="inline-flex items-center px-4 py-2 mt-4 text-base font-medium leading-6 text-white transition duration-150 ease-in-out bg-indigo-500 border border-transparent rounded-md hover:bg-indigo-400 focus:outline-none focus:border-indigo-600 focus:shadow-outline-indigo active:bg-indigo-600">
                Save
            </button>
        </span>
        <a href="{{ route('home') }}" class="ml-5">Cancel</a>
    </form>
</div>