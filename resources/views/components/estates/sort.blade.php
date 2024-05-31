<div class="py-1 text-right" x-data="{ openSort: false }">
    <div @click.outside="openSort = false" class="flex items-center justify-end">
        <div class="relative inline-block pr-2 sm:pr-4">
            <div class="flex">
                <button type="button" @click="openSort = !openSort"
                    class="inline-flex justify-center py-2 text-sm font-medium text-gray-700 sm:py-0 group hover:text-gray-900"
                    id="menu-button" aria-expanded="false" aria-haspopup="true">
                    Immobilien sortieren
                    <svg class="flex-shrink-0 w-5 h-5 ml-1 -mr-1 text-gray-400 group-hover:text-gray-500"
                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <div x-show="openSort"
                class="absolute z-10 w-48 mt-2 ml-2 origin-top-right bg-white rounded-md shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="py-1 text-left" role="none">
                    @if (isset($filters['vermarktungsart']) && $filters['vermarktungsart'] == 'kauf')
                        <a href="{{ request()->merge(['sort' => 'lowestPrice'])->merge(['page' => 1])->fullUrlWithQuery(request()->query()) }}"
                            name="" x-bind:class="'{{ $sort == 'lowestPrice' ? 'text-white bg-primary' : '' }}'"
                            class="block px-4 py-2 text-sm text-gray-500" role="menuitem" tabindex="-1"
                            id="menu-item-0">
                            Niedrigster Preis zuerst
                        </a>
                        <a x-bind:class="'{{ $sort == 'highestPrice' ? 'text-white bg-primary' : '' }}'"
                            href="{{ request()->merge(['sort' => 'highestPrice'])->merge(['page' => 1])->fullUrlWithQuery(request()->query()) }}"
                            class="block px-4 py-2 text-sm text-gray-500" role="menuitem" tabindex="-1"
                            id="menu-item-1">
                            Höchster Preis zuerst
                        </a>
                    @elseif(isset($filters['vermarktungsart']) && $filters['vermarktungsart'] == 'miete')
                        <a href="{{ request()->merge(['sort' => 'lowestRent'])->merge(['page' => 1])->fullUrlWithQuery(request()->query()) }}"
                            name="" class="block px-4 py-2 text-sm text-gray-500"
                            x-bind:class="'{{ $sort == 'lowestRent' ? 'text-white bg-primary' : '' }}'" role="menuitem"
                            tabindex="-1" id="menu-item-0">
                            Niedrigster Preis zuerst
                        </a>
                        <a href="{{ request()->merge(['sort' => 'highestRent'])->merge(['page' => 1])->fullUrlWithQuery(request()->query()) }}"
                            x-bind:class="'{{ $sort == 'highestRent' ? 'text-white bg-primary' : '' }}'"
                            class="block px-4 py-2 text-sm text-gray-500" role="menuitem" tabindex="-1"
                            id="menu-item-1">
                            Höchster Preis zuerst
                        </a>
                    @endif
                    <a href="{{ request()->merge(['sort' => 'newestObjects'])->merge(['page' => 1])->fullUrlWithQuery(request()->query()) }}"
                        x-bind:class="'{{ $sort == 'newestObjects' ? 'text-white bg-primary' : '' }}'"
                        class="block px-4 py-2 text-sm text-gray-500" role="menuitem" tabindex="-1" id="menu-item-2">
                        Neueste Objekte zuerst
                    </a>
                    <a href="{{ request()->merge(['sort' => 'biggestObjects'])->merge(['page' => 1])->fullUrlWithQuery(request()->query()) }}"
                        x-bind:class="'{{ $sort == 'biggestObjects' ? 'text-white bg-primary' : '' }}'"
                        class="block px-4 py-2 text-sm text-gray-500" role="menuitem" tabindex="-1" id="menu-item-2">
                        Größte Fläche zuerst
                    </a>
                    <a href="{{ request()->merge(['sort' => 'smallestObjects'])->merge(['page' => 1])->fullUrlWithQuery(request()->query()) }}"
                        x-bind:class="'{{ $sort == 'smallestObjects' ? 'text-white bg-primary' : '' }}'"
                        class="block px-4 py-2 text-sm text-gray-500" role="menuitem" tabindex="-1" id="menu-item-2">
                        Kleinste Fläche zuerst
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
