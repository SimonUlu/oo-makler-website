<div class="bg-gray-100">
    <div class="flex relative justify-between pb-6 mx-auto mb-0 -mt-36 w-full rounded xl:mb-0 xl:-mt-32"
        x-data="{
            openEstateContactModal: null,
            filterOpen: true,
            estateId: '',
            openCount: 0,
        }" x-init="() => {
            const mediaQuery = window.matchMedia('(max-width: 768px)');
            filterOpen = !mediaQuery.matches;

            mediaQuery.addListener(e => {
                filterOpen = !e.matches;
            });

            $watch('filterOpen', isOpen => {
                let bodyEl = document.body;
                if (isOpen) {
                    document.documentElement.style.overflow = 'hidden';
                    bodyEl.style.overflow = 'hidden';
                    bodyEl.classList.add('scrollbar-hide');
                } else {
                    document.documentElement.style.overflow = '';
                    bodyEl.style.overflow = '';
                    bodyEl.classList.remove('scrollbar-hide');
                }
            });
        }">

        <div class="grid grid-cols-7 w-full">

            <div class="sticky z-20 col-span-full top-[80px] md:backdrop-blur-lg md:bg-white/80">

                <div class="" x-data="{ open: true }">
                    <aside
                        class="flex gap-x-2 py-0 px-4 rounded-lg border-none transition-all duration-300 sm:py-2 sm:rounded-none sm:border-t sm:border-r sm:border-l sm:border-none md:px-0 backdrop-blur-lg bg-white/80"
                        aria-labelledby="sidebar-label" x-show="filterOpen"
                        :class="{ 'transform-gpu translate-x-full': !filterOpen }"
                        x-transition:enter="transition duration-300 ease-in"
                        x-bind:class="openCount > 0 ? 'fullscreen-on-open' : ''"
                        x-transition:enter-start="transform-gpu translate-x-full opacity-0"
                        x-transition:enter-end="transform-gpu transition-x-0 opacity-100"
                        x-transition:leave="transition duration-300 ease-out"
                        x-transition:leave-start="transform-gpu translate-x-0 opacity-100"
                        x-transition:leave-end="transform-gpu translate-x-full opacity-0" x-cloak>

                        <div class="w-full">
                            <div class="lg:px-5 filter-container">
                                <!-- Add the close button at the top of the div -->
                                <div class="flex justify-end p-3" x-show="openCount > 0">
                                    <button @click.prevent="filterOpen = false; updateFilterState(filterOpen);"
                                        class="flex justify-center items-center px-2 text-lg font-semibold text-gray-700 rounded-full border-gray-600 hover:text-gray-500 closing-x">
                                        <span class="mr-2 text-sm">Filter schließen</span>&times;
                                    </button>
                                </div>

                                <form class="w-full" wire:submit.prevent x-data="{
                                    openLocation: true,
                                    openRooms: false,
                                    openObjectType: false,
                                    openPrice: false,
                                }">
                                    @csrf
                                    <div class="grid grid-cols-12">
                                        <div class="col-span-full xl:col-span-9">
                                            <div
                                                class="grid items-center ml-0 sm:ml-0.5 md:flex md:flex-wrap md:justify-start">
                                                <div class="mb-2 w-full sm:hidden">
                                                    <div class="flex justify-center items-center w-full">
                                                        <a href="/suchauftrag"
                                                            class="flex justify-center items-center py-2.5 px-2 w-full text-sm font-semibold text-center text-white bg-green-500 shadow-sm sm:rounded-t-md hover:bg-primary-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                                            </svg>
                                                            <span class="ml-2">Updates zur Suche erhalten</span>
                                                        </a>
                                                    </div>
                                                </div>


                                                {{-- Start Locations --}}
                                                <x-multi-select wire:model="filter.ort" type="search" :multiple="true"
                                                    :placeholder="'Ort eingeben...'" :options="$this->estateLocationOptions">
                                                </x-multi-select>
                                                {{-- End Locations --}}

                                                {{-- Start Rooms --}}
                                                {{-- End Locations --}}
                                                <div>
                                                    @foreach ($filterOptions ?? [] as $label_id => $item)
                                                        <div class="grid py-1 md:flex md:justify-center md:items-center md:p-1"
                                                            x-data="{ isOpen: false }">

                                                            @if ($label_id == 'ort')
                                                                @continue;
                                                            @endif

                                                            @switch ($item['type'])
                                                                @case('numeric')
                                                                    <div class="pt-6" id="filter-section-mobile-2">
                                                                        <div class="space-y-6">
                                                                            <div class="gap-3 gap-y-4">
                                                                                @foreach ($item['numericelements'] as $element)
                                                                                    <div class="mb-4"
                                                                                        wire:key="numeric-element-{{ $key }}">

                                                                                        {{-- <input id="{{ $label_id }}" name="{{ $label_id }}"
                                                                :value="old({{ $label_id }})" label="{{ $item['label'] }}"
                                                                type="number"
                                                                class="block flex-1 py-1.5 w-full rounded-none rounded-r-md border-0 ring-1 ring-inset sm:text-sm sm:leading-6 focus:ring-2 focus:ring-inset text-primary ring-primary placeholder:text-gray-500 focus:ring-primary"
                                                                @input="updateEstates({{ $label_id }}: event.target.value)"
                                                                placeholder="{{ $element['placeholder'] }}" /> --}}
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @break

                                                                @case('varchar')
                                                                    <div class="pt-6" id="filter-section-mobile-2">
                                                                        <div class="space-y-6">
                                                                            <div class="gap-3 gap-y-4">
                                                                                <div class="mb-4">
                                                                                    {{-- <input id="{{ $label_id }}" name="{{ $item['label'] }}"
                                                            :value="old({{ $label_id }})" label="{{ $item['label'] }}"
                                                            type="text"
                                                            class="block flex-1 py-1.5 w-full rounded-none rounded-r-md border-0 ring-1 ring-inset sm:text-sm sm:leading-6 focus:ring-2 focus:ring-inset text-primary ring-primary placeholder:text-gray-500 focus:ring-primary"
                                                            @input="updateEstates({{ $label_id }}: event.target.value)"
                                                            placeholder="{{ $item['label'] }} eingeben..." /> --}}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @break

                                                                @case('multiselect')
                                                                @case('singleselect')
                                                                    <x-multi-select wire:model="filter.{{ $label_id }}"
                                                                        x-cloak type="search" :multiple="true"
                                                                        :placeholder="$item['label_filter']" :options="$this->getSelectOptionsFromLabelId(
                                                                            $label_id,
                                                                        )">
                                                                    </x-multi-select>
                                                                @break

                                                                @case('float')
                                                                    @php
                                                                        $vermarktungsArray = is_array(
                                                                            $filter[
                                                                                'vermarktungsart'
                                                                            ],
                                                                        )
                                                                            ? $filter[
                                                                                'vermarktungsart'
                                                                            ]
                                                                            : ($filter[
                                                                                'vermarktungsart'
                                                                            ] ===
                                                                            ''
                                                                                ? []
                                                                                : [
                                                                                    $filter[
                                                                                        'vermarktungsart'
                                                                                    ],
                                                                                ]);
                                                                    @endphp
                                                                    @if ($item['filter_enabled_buy_case'] && in_array('Kauf', $vermarktungsArray))
                                                                        <div class="relative" x-data="{ open: false, minValue: '', maxValue: '' }">
                                                                            <button type="button" @click="open = !open"
                                                                                class="flex py-3 px-2 w-full text-sm text-gray-600 bg-white rounded-lg border border-gray-300 dark:placeholder-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 focus:ring-primary-500 focus:border-primary-500">
                                                                                <span
                                                                                    class="block truncate">{{ $item['label_filter'] }}</span>
                                                                            </button>
                                                                            <div x-show="open" @click.away="open = false"
                                                                                class="absolute right-0 z-30 mt-1 w-full bg-white rounded-md shadow-lg min-w-[200px]">
                                                                                <div class="grid grid-cols-2 gap-2 py-2 px-2">
                                                                                    @foreach (['__von' => 'von', '__bis' => 'bis'] as $key => $range)
                                                                                        <div>
                                                                                            <input
                                                                                                id="{{ $label_id }}{{ $key }}"
                                                                                                name="filter.{{ $label_id . $key }}"
                                                                                                type="search"
                                                                                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:ring-0 focus:outline-none no-search dark:focus:border-primary-500 focus:border-primary-600"
                                                                                                wire:model.lazy="filter.{{ $label_id . $key }}"
                                                                                                placeholder="{{ $range }}">
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @elseif($item['filter_enabled_rent_case'] && in_array('Miete', $vermarktungsArray))
                                                                        <div class="relative" x-data="{ open: false, minValue: '', maxValue: '' }">
                                                                            <button type="button" @click="open = !open"
                                                                                class="flex py-3 px-2 w-full text-sm text-gray-600 bg-white rounded-lg border border-gray-300 dark:placeholder-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 focus:ring-primary-500 focus:border-primary-500">
                                                                                <span
                                                                                    class="block truncate">{{ $item['label_filter'] }}</span>
                                                                            </button>
                                                                            <div x-show="open" @click.away="open = false"
                                                                                class="absolute right-0 z-30 mt-1 w-full bg-white rounded-md shadow-lg min-w-[200px]">
                                                                                <div class="grid grid-cols-2 gap-2 py-2 px-2">
                                                                                    @foreach (['__von' => 'von', '__bis' => 'bis'] as $key => $range)
                                                                                        <div>
                                                                                            <input
                                                                                                id="{{ $label_id }}{{ $key }}"
                                                                                                name="filter.{{ $label_id . $key }}"
                                                                                                type="search"
                                                                                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:ring-0 focus:outline-none no-search dark:focus:border-primary-500 focus:border-primary-600"
                                                                                                wire:model.lazy="filter.{{ $label_id . $key }}"
                                                                                                placeholder="{{ $range }}">
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @elseif(empty($vermarktungsArray))
                                                                        <div class="relative" x-data="{ open: false, minValue: '', maxValue: '' }">
                                                                            <button type="button" @click="open = !open"
                                                                                class="flex py-3 px-2 w-full text-sm text-gray-600 bg-white rounded-lg border border-gray-300 dark:placeholder-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 focus:ring-primary-500 focus:border-primary-500">
                                                                                <span
                                                                                    class="block truncate">{{ $item['label_filter'] }}</span>
                                                                            </button>
                                                                            <div x-show="open" @click.away="open = false"
                                                                                class="absolute right-0 z-30 mt-1 w-full bg-white rounded-md shadow-lg min-w-[200px]">
                                                                                <div class="grid grid-cols-2 gap-2 py-2 px-2">
                                                                                    @foreach (['__von' => 'von', '__bis' => 'bis'] as $key => $range)
                                                                                        <div>
                                                                                            <input
                                                                                                id="{{ $label_id }}{{ $key }}"
                                                                                                name="filter.{{ $label_id . $key }}"
                                                                                                type="search"
                                                                                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:ring-0 focus:outline-none no-search dark:focus:border-primary-500 focus:border-primary-600"
                                                                                                wire:model.lazy="filter.{{ $label_id . $key }}"
                                                                                                placeholder="{{ $range }}">
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @break

                                                                @default
                                                                    <div class="pt-6" id="filter-section-mobile-1">
                                                                        <div class="space-y-6">
                                                                            @if (isset($item['textualelements']))
                                                                                @foreach ($item['textualelements'] as $element)
                                                                                    @if (isset($label_id))
                                                                                        <div class="flex items-center"
                                                                                            wire:key="textual-element-{{ $key }}">

                                                                                            {{-- <div class="flex items-center">
                                                                <input type="checkbox" id="{{ $label_id }}"
                                                                    value="{{ $label_id }}"
                                                                    x-on:input="updateEstates({key: '{{ $label_id }}', value: '{{ $label_id }}'})"
                                                                    name="category[]"
                                                                    class="w-4 h-4 rounded border-gray-300 focus:ring-indigo-500 text-primary dynamic-input" />
                                                                <label for="{{ $label_id }}"
                                                                    class="ml-3 text-sm text-gray-600 capitalize">
                                                                    {{ $label_id }}
                                                                </label>
                                                            </div> --}}
                                                                                        </div>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @break
                                                            @endswitch
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div x-data="{ openSort: false, selected: $wire.currentSortText }" @click.away="openSort = false"
                                        class="hidden relative col-span-3 mt-2 w-full xl:block">
                                        <!-- Trigger -->
                                        <button @click="openSort = !openSort" type="button"
                                            class="relative py-1.5 pr-10 pl-3 w-full text-left text-gray-900 bg-white rounded-md ring-1 ring-inset ring-gray-300 shadow-sm cursor-default cursor-pointer sm:text-sm sm:leading-6 focus:ring-2 focus:ring-indigo-600 focus:outline-none"
                                            aria-haspopup="listbox" aria-expanded="true"
                                            aria-labelledby="listbox-label">
                                            <span x-text="selected"></span>
                                            <span
                                                class="flex absolute inset-y-0 right-0 items-center pr-2 pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </button>

                                        <!-- Dropdown -->
                                        <div x-show="openSort" x-cloak
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 translate-y-1"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100 translate-y-0"
                                            x-transition:leave-end="opacity-0 translate-y-1"
                                            class="absolute left-0 mt-2 w-full rounded-md shadow-lg origin-top-left">
                                            <div class="bg-white rounded-md shadow-xs">
                                                <div class="py-1" role="menu" aria-orientation="vertical"
                                                    aria-labelledby="options-menu">
                                                    <template x-for="option in $wire.sortOptions"
                                                        :key="option.id">
                                                        <a href="#"
                                                            @click.prevent="selected = option.option_text; openSort = false; $wire.call('setSortOption', option.option_text, true);"
                                                            class="block py-2 px-4 text-sm leading-5 text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:text-gray-900 focus:bg-gray-100 focus:outline-none"
                                                            x-text="option.option_text"
                                                            :class="{
                                                                'font-semibold': selected === option
                                                                    .id,
                                                                'font-normal': selected !== option.id
                                                            }"
                                                            role="menuitem">
                                                        </a>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Active filters -->

                                    <div class="col-span-9">
                                        <div class="py-1 pr-4 pl-1 mx-auto md:flex md:items-center md:pr-6 lg:pr-8">
                                            <div class="grid grid-cols-12">
                                                <div
                                                    class="flex col-span-full justify-start items-center md:col-span-2">
                                                    <h3 class="flex text-sm font-medium text-gray-500">
                                                        Aktive Filter
                                                    </h3>
                                                    <span aria-hidden="true"
                                                        class="hidden w-px h-5 bg-gray-300 md:block md:ml-4"></span>
                                                </div>
                                                <div class="col-span-full md:col-span-10">
                                                    <div class="flex gap-x-4 mt-2 md:mt-0 md:ml-4">
                                                        <div
                                                            class="flex gap-x-1 justify-center items-center filter-info-wrapper">
                                                            @foreach ($filterInfo as $filterItem)
                                                                <div x-data="{ expanded: false }"
                                                                    class="flex flex-wrap items-center"
                                                                    wire:key="filter-item-{{ $key }}">
                                                                    <div
                                                                        class="flex items-center py-1 px-2 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200">
                                                                        <span
                                                                            x-text='expanded ? "{{ $filterItem['value'] }}" : "{{ Str::limit($filterItem['value'], 25) }}"'></span>
                                                                        <button
                                                                            wire:click="removeFilter({'key': '{{ $filterItem['key_raw'] }}', 'value': '{{ $filterItem['value_raw'] }}', 'remove': true})"
                                                                            class="ml-1 text-xl text-gray-400 cursor-pointer">&times;</button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        @php
                                                            // get all filter keys where the value is not null or empty
                                                            $filterKeys = array_keys(
                                                                array_filter(
                                                                    $this->filter,
                                                                ),
                                                            );
                                                        @endphp
                                                        @if (count($filterKeys) > 1)
                                                            <button wire:click="resetFilters()"
                                                                class="py-2.5 px-2.5 text-sm font-semibold text-white bg-red-500 rounded-md shadow-sm hover:bg-red-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                                                                <span class="text-sm">Alle Filter zurücksetzen</span>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Sort Mobile --}}
                                    <div x-data="{ openSort: false, selected: $wire.currentSortText }" @click.away="openSort = false"
                                        class="block relative col-span-6 mt-2 mb-4 w-full md:col-span-4 xl:hidden">
                                        <!-- Trigger -->
                                        <button @click="openSort = !openSort" type="button"
                                            class="relative py-1.5 pr-10 pl-3 w-full text-left text-gray-900 bg-white rounded-md ring-1 ring-inset ring-gray-300 shadow-sm cursor-default cursor-pointer sm:text-sm sm:leading-6 focus:ring-2 focus:ring-indigo-600 focus:outline-none"
                                            aria-haspopup="listbox" aria-expanded="true"
                                            aria-labelledby="listbox-label">
                                            <span x-text="selected"></span>
                                            <span
                                                class="flex absolute inset-y-0 right-0 items-center pr-2 pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </button>

                                        <!-- Dropdown -->
                                        <div x-show="openSort" x-cloak
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 translate-y-1"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100 translate-y-0"
                                            x-transition:leave-end="opacity-0 translate-y-1"
                                            class="absolute left-0 mt-2 w-full rounded-md shadow-lg origin-top-left">
                                            <div class="bg-white rounded-md shadow-xs">
                                                <div class="py-1" role="menu" aria-orientation="vertical"
                                                    aria-labelledby="options-menu">
                                                    <template x-for="option in $wire.sortOptions"
                                                        :key="option.id">
                                                        <a href="#"
                                                            @click.prevent="selected = option.option_text; openSort = false; $wire.call('setSortOption', option.option_text, true);"
                                                            class="block py-2 px-4 text-sm leading-5 text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:text-gray-900 focus:bg-gray-100 focus:outline-none"
                                                            x-text="option.option_text"
                                                            :class="{
                                                                'font-semibold': selected === option
                                                                    .id,
                                                                'font-normal': selected !== option.id
                                                            }"
                                                            role="menuitem">
                                                        </a>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Sort Mobile --}}


                                    {{-- <div class="flex col-span-3 justify-end items-center">
                                    <x-estates.sort :sort="$sort" />
                                </div> --}}
                                </form>

                                <div class="grid col-span-full py-3 border-b sm:hidden md:hidden md:justify-center md:items-center bg-primary"
                                    @click.prevent="filterOpen = false;">
                                    <!-- Closing button -->
                                    <button
                                        class="flex mx-auto h-full text-sm font-bold text-white hover:text-gray-200">
                                        <span class="mr-2">Filter anwenden</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </aside>

                    <div class="flex justify-end items-center py-2 w-full backdrop-blur-lg bg-white/80"
                        x-show="!filterOpen" x-transition:enter="transition-opacity ease-out duration-900"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <!-- Opening button -->
                        <button @click.prevent="filterOpen = true; openCount++"
                            class="flex items-center mr-4 h-full text-sm text-gray-500 hover:text-gray-700">
                            <span class="mr-2">Filter</span> <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
            @if ($showMap == 'yes')
                <div class="sticky col-span-7 p-2 mx-auto mt-8 w-full max-w-screen-2xl lg:col-span-2 lg:pl-5">
                    <div class="block sticky top-48 mb-4" wire:key="estate-map-component">
                        @livewire('estate-map-component', ['estates' => $map_estates])
                    </div>
                </div>
            @endif

            <div class="col-span-7 p-2 mx-auto mt-8 w-full max-w-screen-2xl lg:col-span-5 lg:pl-5">


                <div class="overflow-hidden relative w-full lg:grid-cols-12">
                    {{-- Estate List --}}
                    <div class="z-10 lg:col-span-12">

                        @if ($listAppearance == 'list')
                            <x-estates.list-fullrow :estates="$estates" :estateFields="$estateFields" :sort="$sort"
                                :showContactModal="$showContactModal" :openModal="$openModal" :estateContactModal="$estateContactModal" />
                        @elseif($listAppearance == 'boxes')
                            <x-estates.list-kacheln :estates="$estates" :estateFields="$estateFields" :sort="$sort"
                                :showContactModal="$showContactModal" :openModal="$openModal" :estateContactModal="$estateContactModal" />
                        @elseif($listAppearance == 'small_boxes')
                            <x-estates.list-small-kacheln :estates="$estates" :estateFields="$estateFields" :sort="$sort"
                                :showContactModal="$showContactModal" :openModal="$openModal" :estateContactModal="$estateContactModal" />
                        @endif

                        {{ $estates->links('vendor.pagination.custom_pagination') }}

                        {{-- recommendation estates when no estates available --}}
                        @if (collect($this->estateReferences)->count() > 0 && collect($this->estates)->count() == 0)
                            <x-estates.list-estates-recommendation :estates="$this->estateReferences" />
                        @endif

                        @if ($estates->count() == 0)
                            <x-estates.list-estates-recommendation :estates="$estateReferences" />
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-span-2 mt-8">
                @if ($showMap == 'no')
                    <div class="hidden sticky z-10 pt-2 w-full h-screen md:block md:pr-2 lg:top-48 lg:pr-5">
                        <x-estates.sidebar />
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
