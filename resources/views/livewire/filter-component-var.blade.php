<div x-data="{ openPanel: false }" @keydown.escape.window="openPanel = false">
    <!-- Trigger button to open the slide-over panel -->

    <div class="relative z-30" aria-labelledby="slide-over-title" role="dialog" aria-modal="true" x-show="openPanel" x-cloak>
        <!-- Background backdrop, show/hide based on slide-over state. -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="openPanel = false"></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">

                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 z-40"
                     @click.away="openPanel = false"
                     x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full">
                    <div class="pointer-events-auto w-screen max-w-md">
                        <div class="flex h-full flex-col overflow-y-scroll bg-white py-6 shadow-xl">
                            <div class="px-4 sm:px-6">
                                <div class="flex items-start justify-between">
                                    <h2 class="text-base font-semibold leading-6 text-gray-900" id="slide-over-title">Wählen Sie Ihren Immobilienfilter</h2>
                                    <div class="ml-3 flex h-7 items-center">
                                        <button type="button" @click="openPanel = false" class="relative rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            <span class="absolute -inset-2.5"></span>
                                            <span class="sr-only">Close panel</span>
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="relative mt-6 flex-1 px-4 sm:px-6 space-y-4">

                                <div class="space-y-2">
                                    <h3 class="text-sm text-gray-500 ml-4">
                                        Filtern nach&nbsp;<span class="text-sm font-semibold leading-5 text-gray-900">Ort:</span>
                                    </h3>

                                    <x-multi-select
                                        wire:model.lazy="filter.ort"
                                        type="search"
                                        :multiple="true"
                                        class="py-0 border-none"
                                        :placeholder="'Ort eingeben...'"
                                        :options="$estateLocationOptions">
                                    </x-multi-select>
                                </div>

                                <div class="space-y-2">
                                    <h3 class="text-sm text-gray-500 ml-4">
                                        Filtern nach&nbsp;<span class="text-sm font-semibold leading-5 text-gray-900">Umkreis:</span>
                                    </h3>
                                    @if($this->isRadiusFilterActive)
                                        <div class="min-h-[65px] hidden md:flex flex-col space-y-2 px-6" x-data="{
        sliderValue: @entangle('filter.radius').defer,
        radiusZipCode: @entangle('filter.radiusZipCode').defer,
        showZipError: false,
        showSliderError: false,
        validateAndSetValues() {
            if (this.radiusZipCode && this.radiusZipCode.length === 5 && !isNaN(this.radiusZipCode) && this.sliderValue !== null && this.sliderValue !== '') {
                this.showZipError = false;
                this.showSliderError = false;
                $wire.set('filter.radiusZipCode', this.radiusZipCode);
                $wire.set('filter.radius', this.sliderValue);
            } else {
                if (!this.radiusZipCode || this.radiusZipCode.length !== 5 || isNaN(this.radiusZipCode)) {
                    this.showZipError = true;
                } else {
                    this.showZipError = false;
                }
                if (this.sliderValue === null || this.sliderValue === '') {
                    this.showSliderError = true;
                } else {
                    this.showSliderError = false;
                }
            }
        }
    }">
                                            <div class="flex items-center space-x-4">
                                                <input id="radius-zip-code-input-slide-over" type="text"
                                                       class="text-base placeholder-gray-600 border-none focus:border-none focus:ring-0 w-20 text-gray-600"
                                                       placeholder="Plz..."
                                                       x-model="radiusZipCode"
                                                       @blur="validateAndSetValues()"
                                                       wire:loading.attr="disabled">
                                                <div class="w-full">
                                                    <label for="labels-range-input" class="sr-only">Labels range</label>
                                                    <input id="labels-range-input" type="range" min="0" max="100"
                                                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                                                           x-model="sliderValue"
                                                           @change="validateAndSetValues()"
                                                           wire:loading.attr="disabled">
                                                    <div class="flex justify-between mt-2">
                                                        <span class="text-sm text-gray-500 dark:text-gray-400">Umkreis</span>
                                                        <span class="text-sm text-gray-500 dark:text-gray-400"><strong x-text="sliderValue"></strong> km</span>
                                                        <span class="text-sm text-gray-500 dark:text-gray-400">100</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div x-show="showZipError" class="text-red-500 text-sm mt-1">Bitte geben Sie eine gültige PLZ ein.</div>
                                            <div x-show="showSliderError" class="text-red-500 text-sm mt-1">Bitte wählen Sie einen Umkreis.</div>
                                            <div wire:loading class="text-gray-500 text-sm mt-1">Laden...</div>
                                        </div>
                                    @endif
                                </div>

                                @foreach ($filterOptions ?? [] as $label_id => $item)
                                    @if ($label_id == 'ort')
                                        @continue
                                    @endif

                                    @if($item['type'] == 'numeric')
                                        <div class="pt-6" id="filter-section-mobile-{{ $label_id }}">
                                            <div class="space-y-6">
                                                <div class="gap-3 gap-y-4">
                                                    @foreach ($item['numericelements'] as $element)
                                                        <div class="mb-4" wire:key="numeric-element-{{ $label_id }}">
                                                            <input id="{{ $label_id }}" name="{{ $label_id }}" type="number"
                                                                   class="block flex-1 py-1.5 w-full rounded-none rounded-r-md border-0 ring-1 ring-inset sm:text-sm sm:leading-6 focus:ring-2 focus:ring-inset text-primary ring-primary placeholder:text-gray-500 focus:ring-primary"
                                                                   wire:model.lazy="filter.{{ $label_id }}" placeholder="{{ $element['placeholder'] }}"/>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($item['type'] == 'varchar')
                                        <div class="pt-6" id="filter-section-mobile-{{ $label_id }}">
                                            <div class="space-y-6">
                                                <div class="gap-3 gap-y-4">
                                                    <div class="mb-4">
                                                        <input id="{{ $label_id }}" name="{{ $label_id }}" type="text"
                                                               class="block flex-1 py-1.5 w-full rounded-none rounded-r-md border-0 ring-1 ring-inset sm:text-sm sm:leading-6 focus:ring-2 focus:ring-inset text-primary ring-primary placeholder:text-gray-500 focus:ring-primary"
                                                               wire:model.lazy="filter.{{ $label_id }}" placeholder="{{ $item['label'] }} eingeben..."/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($item['type'] == 'singleselect' || $item['type'] == 'multiselect')
                                        <div class="space-y-2">
                                            <h3 class="text-sm text-gray-500 ml-4">
                                                Filtern nach&nbsp;<span class="text-sm font-semibold leading-5 text-gray-900">{{$item['label_filter']}}:</span>
                                            </h3>
                                            <x-multi-select
                                                wire:model="filter.{{ $label_id }}"
                                                x-cloak
                                                class="py-0 border-none"
                                                type="search"
                                                :multiple="true"
                                                :placeholder="$item['label_filter']"
                                                :options="$this->getSelectOptionsFromLabelId($label_id)">
                                            </x-multi-select>
                                        </div>
                                    @endif

                                    @if($item['type'] == 'float')
                                        @php
                                            $isRent = $isRent ?? false;
                                            $isEmpty = $isEmpty ?? false;
                                        @endphp

                                        <div class="relative ml-4 space-y-2" x-data="{ open: false, minValue: '', maxValue: '' }">
                                            <h3 class="text-sm text-gray-500">
                                                Filtern nach&nbsp;<span class="text-sm font-semibold leading-5 text-gray-900">{{$item['label_filter']}}:</span>
                                            </h3>
                                            <button type="button" @click="open = !open"
                                                    class="flex py-3 px-2 w-full text-sm text-gray-600 bg-white rounded-lg border border-gray-300 dark:placeholder-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 focus:ring-primary-500 focus:border-primary-500">
                                                <span class="block truncate">{{ $item['label_filter'] }}</span>
                                            </button>
                                            <div x-show="open" @click.away="open = false"
                                                 class="absolute right-0 z-30 mt-1 w-full bg-white rounded-md shadow-lg min-w-[200px]">
                                                <div class="grid grid-cols-2 gap-2 py-2 px-2">
                                                    @foreach (['__von' => 'von', '__bis' => 'bis'] as $key => $range)
                                                        <div x-init="formatInput($el.querySelector('input'), {{ $item['fieldMeasureFormat'] == 'DATA_TYPE_MONETARY' ? 'true' : 'false' }})">
                                                            <input id="{{ $label_id }}{{ $key }}" name="filter.{{ $label_id . $key }}" type="{{ $isRent ? 'number' : 'text' }}" step="0.5"
                                                                   class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:ring-0 focus:outline-none no-search dark:focus:border-primary-500 focus:border-primary-600"
                                                                   wire:model.lazy="filter.{{ $label_id . $key }}" placeholder="{{ $range }}"
                                                                   oninput="formatInput(this, {{ $item['fieldMeasureFormat'] == 'DATA_TYPE_MONETARY' ? 'true' : 'false' }})">
                                                            @if(!$isRent)
                                                                <input id="{{ $label_id }}{{ $key }}_hidden" name="filter_hidden.{{ $label_id . $key }}" type="hidden" />
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        @if($isEmpty)
                                            <div class="grid grid-cols-2 gap-2">
                                                @foreach (['__von' => 'von', '__bis' => 'bis'] as $key => $range)
                                                    @if(!empty($this->filter[$label_id.$key]))
                                                        <div class="inline-flex items-baseline rounded-full px-2.5 py-0.5 text-sm font-medium bg-primary-600 text-white md:mt-2 lg:mt-0">
                                                        <span>{{ $range }}
                                                            @if($filterOptions[$label_id]['fieldMeasureFormat'] == 'DATA_TYPE_MONETARY')
                                                                {{ number_format($this->convertToFloat($this->filter[$label_id.$key]), 0, '', '.') }} €
                                                            @else
                                                                {{$this->filter[$label_id.$key]}}
                                                            @endif
                                                        </span>
                                                            <a type="button" wire:click="clearFilter('{{ $label_id }}{{ $key }}')" class="ml-2 text-white">
                                                                &times;
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100">

        <div
            class="sticky top-0 z-20 px-4 py-2 bg-white grid grid-cols-12"
            :class="{
                'backdrop-blur-md bg-white/90 border-t-[5px] border-primary': !showNavigation
            }"
            aria-labelledby="sidebar-label">

            <div class="divide-x space-x-4 flex items-center justify-between md:justify-start col-span-6 md:col-span-10">
                <div class="min-h-[65px]">
                    <h2 class="text-base font-semibold leading-6 text-gray-900" id="sidebar-label">Wählen Sie Ihren Immobilienfilter</h2>
                    <span class="text-sm text-gray-500">
                        {{ trans_choice('messages.estate_count', count($estates), ['count' => count($estates)]) }}
                    </span>
                </div>
                <div class="min-h-[65px] min-w-[180px] hidden md:flex space-x-4">
                    <x-multi-select
                        wire:model.lazy="filter.ort"
                        type="search"
                        :multiple="true"
                        :placeholder="'Ort eingeben...'"
                        :options="$estateLocationOptions">
                    </x-multi-select>
                </div>

                @if($this->isRadiusFilterActive)
                    <div class="min-h-[65px] hidden md:flex flex-col space-y-2 px-6" x-data="{
        sliderValue: @entangle('filter.radius').defer,
        radiusZipCode: @entangle('filter.radiusZipCode').defer,
        showZipError: false,
        showSliderError: false,
        validateAndSetValues() {
            if (this.radiusZipCode && this.radiusZipCode.length === 5 && !isNaN(this.radiusZipCode) && this.sliderValue !== null && this.sliderValue !== '') {
                this.showZipError = false;
                this.showSliderError = false;
                $wire.set('filter.radiusZipCode', this.radiusZipCode);
                $wire.set('filter.radius', this.sliderValue);
            } else {
                if (!this.radiusZipCode || this.radiusZipCode.length !== 5 || isNaN(this.radiusZipCode)) {
                    this.showZipError = true;
                } else {
                    this.showZipError = false;
                }
                if (this.sliderValue === null || this.sliderValue === '') {
                    this.showSliderError = true;
                } else {
                    this.showSliderError = false;
                }
            }
        }
    }">
                        <div class="flex items-center space-x-4">
                            <input id="radius-zip-code-input-slide-over" type="text"
                                   class="text-base placeholder-gray-600 border-none focus:border-none focus:ring-0 w-20 text-gray-600"
                                   placeholder="Plz..."
                                   x-model="radiusZipCode"
                                   @blur="validateAndSetValues()"
                                   wire:loading.attr="disabled">
                            <div class="w-full">
                                <label for="labels-range-input" class="sr-only">Labels range</label>
                                <input id="labels-range-input" type="range" min="0" max="100"
                                       class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                                       x-model="sliderValue"
                                       @change="validateAndSetValues()"
                                       wire:loading.attr="disabled">
                                <div class="flex justify-between mt-2">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Umkreis</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400"><strong x-text="sliderValue"></strong> km</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">100</span>
                                </div>
                            </div>
                        </div>
                        <div x-show="showZipError" class="text-red-500 text-sm mt-1">Bitte geben Sie eine gültige PLZ ein.</div>
                        <div x-show="showSliderError" class="text-red-500 text-sm mt-1">Bitte wählen Sie einen Umkreis.</div>
                        <div wire:loading class="text-gray-500 text-sm mt-1">Laden...</div>
                    </div>
                @endif
                <div class="min-h-[65px] hidden md:flex space-x-4">
                    <x-multi-select
                        wire:model="filter.vermarktungsart"
                        x-cloak
                        type="search"
                        :multiple="true"
                        :placeholder="'Vermarktungsart wählen...'"
                        :options="$this->getSelectOptionsFromLabelId('vermarktungsart')">
                    </x-multi-select>
                </div>

                <div class="min-h-[65px] hidden md:flex space-x-4">
                    <x-multi-select
                        wire:model="filter.objektart"
                        x-cloak
                        type="search"
                        :multiple="true"
                        :placeholder="'Objektart wählen...'"
                        :options="$this->getSelectOptionsFromLabelId('objektart')">
                    </x-multi-select>
                </div>
            </div>

            <div class="min-h-[65px] flex items-center justify-start col-span-6 md:col-span-2">
                <div class="space-x-4 ml-2">
                    <button @click="openPanel = true"
                            class="z-30 flex justify-center items-center rounded-md bg-black px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-neutral-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-3 size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                        </svg>

                        Filter
                    </button>
                </div>
                @if(!empty(array_filter($this->filter)))
                    <div class="space-x-4 ml-2">
                        <button wire:click="resetFilter"
                                class="z-30 flex justify-center items-center rounded-md bg-red-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex relative justify-between pb-6 mx-auto mb-0 w-full rounded xl:mb-0">

            <div class="grid grid-cols-7 w-full">
                <div class="sticky col-span-7 p-2 mx-auto mt-8 w-full max-w-screen-2xl lg:col-span-2 lg:pl-5">
                    <div class="block sticky top-28 mb-4 space-y-2">
                        @livewire('estate-map-component', ['estates' => $estates])
                    </div>
                </div>
                <div class="col-span-7 p-2 mx-auto mt-8 w-full max-w-screen-2xl lg:col-span-5 lg:pl-5">
                    <div class="overflow-hidden relative w-full lg:grid-cols-12">
                        <div class="z-10 lg:col-span-12">
                            <x-estates.list-kacheln :estates="$estatesPaginator" :estateFields="$estateFields" :sort="$sort"
                                                    :showContactModal="$showContactModal" :openModal="$openModal"
                                                    :estateContactModal="$estateContactModal"/>
                            @if (!empty($estatesPaginator) && $estatesPaginator->count() > 0)
                                {{ $estatesPaginator->links('vendor.pagination.custom_pagination') }}
                            @endif
                            {{-- Recommendation estates when no estates available --}}
                            @if (!empty($estateRecommendation) && $estateRecommendation->count() > 0 && $estatesPaginator->count() == 0)
                                <x-estates.list-estates-recommendation :estates="$estateRecommendation"/>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function formatInput(input, isMonetary) {
            // Get the current value of the input field
            let value = input.value;

            if (isMonetary) {
                // Remove any non-numeric characters except for comma and dot
                value = value.replace(/[^\d,]/g, '');

                // Replace dot with comma for European format
                value = value.replace('.', ',');

                // Format the number with a comma as the decimal separator
                let parts = value.split(',');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                // Join the parts back together
                value = parts.join(',');

                // Add the Euro symbol
                input.value = value + ' €';

                // Also update the hidden input with a plain numeric value
                let numericValue = value.replace(/\./g, '').replace(',', '.').replace(' €', '');
                document.getElementById(input.id + '_hidden').value = numericValue;
            } else {
                // For non-monetary values, just update the hidden input with the plain numeric value
                let numericValue = value.replace(/\./g, '').replace(',', '.').replace(' €', '');
                document.getElementById(input.id + '_hidden').value = numericValue;
            }
        }

        function prepareForSubmit() {
            // Ensure the hidden input is updated before form submission
            document.querySelectorAll('input[type="text"]').forEach(input => {
                let numericValue = input.value.replace(/\./g, '').replace(',', '.').replace(' €', '');
                document.getElementById(input.id + '_hidden').value = numericValue;
            });
        }
    </script>
</div>
