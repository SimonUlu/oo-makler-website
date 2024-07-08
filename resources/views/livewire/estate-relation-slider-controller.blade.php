
<div class="relative pt-8 pb-20 mx-auto lg:px-2 lg:pt-36 lg:pb-28 max-w-7xl">
    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl mb-8 lg:mb-12 ml-6"> Verfügbare Wohneinheiten</p>
    <script src="https://unpkg.com/smoothscroll-polyfill@0.4.4/dist/smoothscroll.js"></script>
    <div x-data="{
            skip: 1,
            slidesToShow: 1,
            atBeginning: false,
            atEnd: false,
            next() {
                this.to((current, offset) => current + (offset * this.skip))
            },
            prev() {
                this.to((current, offset) => current - (offset * this.skip))
            },
            to(strategy) {
                let slider = this.$refs.slider
                let current = slider.scrollLeft
                let offset = slider.firstElementChild.getBoundingClientRect().width
                slider.scrollTo({ left: strategy(current, offset), behavior: 'smooth' })
            },
            focusableWhenVisible: {
                'x-intersect:enter'() {
                    this.$el.removeAttribute('tabindex')
                },
                'x-intersect:leave'() {
                    this.$el.setAttribute('tabindex', '-1')
                },
            },
            disableNextAndPreviousButtons: {
                'x-intersect:enter.threshold.05'() {
                    let slideEls = this.$el.parentElement.children

                    // If this is the first slide.
                    if (slideEls[0] === this.$el) {
                        this.atBeginning = true
                    // If this is the last slide.
                    } else if (slideEls[slideEls.length-1] === this.$el) {
                        this.atEnd = true
                    }
                },
                'x-intersect:leave.threshold.05'() {
                    let slideEls = this.$el.parentElement.children

                    // If this is the first slide.
                    if (slideEls[0] === this.$el) {
                        this.atBeginning = false
                    // If this is the last slide.
                    } else if (slideEls[slideEls.length-1] === this.$el) {
                        this.atEnd = false
                    }
                },
            },
        }" x-init="() => window.addEventListener('resize')"  class="flex flex-col w-full">
        <style>
            .show-1>li {
                min-width: 100%;
            }

            .show-2>li {
                min-width: calc(100% / 2);
            }

            .show-3>li {
                min-width: calc(100% / 3);
            }
        </style>
        <div x-on:keydown.right="next" x-on:keydown.left="prev" tabindex="0" role="region" aria-labelledby="carousel-label" class="relative flex mx-auto space-x-6 lg:min-w-[32rem]">
            <h2 id="carousel-label" class="sr-only" hidden>Carousel</h2>

            <!-- Prev Button -->
            <button x-on:click="prev" class="text-6xl absolute top-0 right-0" style="right: 100px; top: -80px" :aria-disabled="atBeginning" :tabindex="atEnd ? -1 : 0" :class="{ 'opacity-50 cursor-not-allowed': atBeginning }">
                <span aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 bg-white rounded-full text-primary-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </span>
                <span class="sr-only">Skip to previous slide page</span>
            </button>


            <span id="carousel-content-label" class="sr-only" hidden>Carousel</span>

            <ul x-ref="slider" tabindex="0" role="listbox" aria-labelledby="carousel-content-label" class="flex w-full mx-6 overflow-hidden snap-x snap-mandatory">
                <!-- Section Single Estate -->
                @foreach($subestates as $estate)
                    <li x-bind="disableNextAndPreviousButtons" class="flex flex-col items-center justify-center w-full  p-2 md:w-1/2 lg:w-1/3 shrink-0 snap-start" wire:key="estate-{{ $estate['id'] }}" role="option">
                        <div class="p-0 space-y-4 bg-white border-l border-r border-gray-200 rounded-lg shadow-md borter-t border-b-none sm:border dark:border-gray-700"
                             wire:loading.class="animate-pulse" x-data="{ estateId: {{ $estate['id'] }} }">
                            <div class="grid w-full max-w-lg grid-cols-1 mx-auto md:flex-col md:mb-0 md:space-x-0 md:max-w-none">
                                <a href="{{ url('immobilien/details/' . strval($estate['id'])) }}" alt="zur Immobilie" target="_blank">
                                    <div class="relative" wire:key="estate-img-container-{{ $estate['id'] }}">
                                        <img class="object-cover w-full shadow-none  sm:shadow-t-lg sm:shadow-r-lg sm:shadow-l-lg h-72 lazy"
                                             target="_blank"
                                             data-src="{{ isset($estate['elements']['images'][0]['url']) ? $estate['elements']['images'][0]['url'] . '@800x600' : 'https://via.placeholder.com/300x200' }}"
                                             alt="{{ isset($estate['elements']['images'][0]['title']) ? $estate['elements']['images'][0]['title'] : 'Platzhalter Objekttitel' }}"
                                             loading="lazy" />
                                        <div class="absolute transform -translate-x-1/2 -translate-y-1/2 spinner top-1/2 left-1/2">
                                            <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 008 8V12A4 4 0 004 8"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </a>

                                <div class="flex flex-col h-full p-5">
                                    <div class="flex-grow space-y-4">
                                        <div class="flex items-center justify-between gap-6">
                                            <div class="flex items-center gap-2 h-[50px]">
                                            <span class="text-lg font-bold text-gray-900 ">
                                                <a href="{{ url('immobilien/details/' . strval($estate['id'])) }}" target="_blank">
                                                    @if ($estate['elements']['objekttitel'])
                                                        {{ $estate['elements']['objekttitel'] }} <span class="font-medium"> in </span>{{$estate['elements']['ort']}}
                                                        {{--                                                    {{ str_limit($estate['elements']['objekttitel'], 30) }} <span class="font-medium"> in </span>{{$estate['elements']['ort']}}--}}
                                                    @else
                                                        Kein Titel
                                                    @endif
                                                </a>
                                            </span>
                                            </div>
                                            {{-- <span class="text-xs font-normal text-right text-gray-500 dark:text-gray-400">
                                                bereits  mal angesehen
                                            </span> --}}
                                        </div>
                                        <div class="w-full h-0.5 mt-1 rounded-full dark:bg-gray-700">
                                            <div class="h-0.5 rounded-full bg-primary-600" style="width: 100%"></div>
                                        </div>
                                        <div class="grid grid-cols-2">
                                            <div class="flex items-center">
                                                <h3 class="text-lg font-bold leading-tight text-gray-900 ">
                                                    @if ($estate['elements']['vermarktungsart'] == 'kauf')
                                                        @if ($estate['elements']['kaufpreis'] == 0.0)
                                                            Preis auf Anfrage
                                                        @else
                                                            {{ number_format(round($estate['elements']['kaufpreis']), 0, ',', '.') }} €
                                                        @endif
                                                    @else
                                                        @if ($estate['elements']['warmmiete'] > 0.0)
                                                            {{ number_format(round($estate['elements']['warmmiete']), 0, ',', '.') }} € <span class="text-gray-500 dark:text-gray-400"> (Warmmiete) </span>
                                                        @elseif ($estate['elements']['kaltmiete'] > 0.0)
                                                            {{ number_format(round($estate['elements']['kaltmiete']), 0, ',', '.') }} €
                                                        @else
                                                            Preis auf Anfrage
                                                        @endif
                                                    @endif
                                                </h3>
                                            </div>
                                            <span>
                                            <div class="flex justify-end space-x-2">
                                                @if ($estate['elements']['vermarktungsart'] == 'kauf')
                                                    <span
                                                        class="capitalize inline-flex items-center rounded-full bg-primary-900 px-2.5 py-0.5 text-sm font-medium text-white">
                                                        {{ $estate['elements']['vermarktungsart'] }}
                                                    </span>
                                                @elseif($estate['elements']['vermarktungsart'] == 'miete')
                                                    <span
                                                        class="capitalize inline-flex items-center rounded-full border border-primary text-primary px-2.5 py-0.5 text-sm font-medium">
                                                        {{ $estate['elements']['vermarktungsart'] }}
                                                    </span>
                                                @endif
                                            </div>
                                        </span>
                                        </div>

                                        <div class="grid grid-cols-6">

                                            <div class="col-span-6">
                                                <div class="grid lg:grid-cols-2">

                                                    <div class="my-2">
                                                        <div class="flex space-x-2 items-center text-gray-500 dark:text-gray-400">
                                                            <span class="">Wohnfl&auml;che</span>
                                                            <span class="font-bold">·</span>
                                                            @if ($estate['elements']['wohnflaeche'] !== '0.00')
                                                                <span class="block  text-sm font-bold text-black">
                                                            {{ round($estate['elements']['wohnflaeche']) }}
                                                            m&sup2;</span>
                                                            @else
                                                                <span class="hidden text-sm xl:block font-bold text-black">
                                                            nach Anfrage</span>
                                                                <span class="block text-sm  xl:hidden font-bold text-black">
                                                            n. Anfrage</span>
                                                            @endif
                                                        </div>
                                                    </div>


                                                    <div class="my-2">
                                                        <div class="flex space-x-2  items-center text-gray-500 dark:text-gray-400">
                                                            <span class="">Zimmer</span>
                                                            <span class="font-bold">·</span>
                                                            @if ($estate['elements']['anzahl_zimmer'] !== '0.00')
                                                                <span
                                                                    class="block text-sm font-bold text-black">
                                                            {{ round($estate['elements']['anzahl_zimmer']) }}
                                                        </span>
                                                            @else
                                                                <span class="hidden text-sm  xl:block font-bold text-black">
                                                            nach Anfrage</span>
                                                                <span class="block text-sm  xl:hidden font-bold text-black">
                                                            n. Anfrage</span>

                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 sm:grid-cols-3">
                                        <div
                                            class="flex flex-col justify-end w-full gap-4 mt-4 md:mt-2 col-span-full lg:justify-center sm:col-span-2 sm:flex-row md:flex-col lg:flex-row lg:items-center lg:col-span-3">
                                            <a href="{{ url('immobilien/details/' . strval($estate['id'])) }}" target="_blank"
                                               title="Sehen Sie sich diese Immbolie an"
                                               class="text-white w-full bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                               role="button">
                                                Jetzt ansehen
                                            </a>

                                            <a wire:click="openModal({{ $estate['id'] }})"
                                               class="inline-flex items-center justify-center w-full px-5 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                               role="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                                </svg>
                                                Anfragen
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </li>
                @endforeach
                <!-- Section Single Estate -->
            </ul>
            <!-- Next Button -->
            <button x-on:click="next" class="text-6xl absolute top-0 right-0 mr-4" :aria-disabled="atEnd" style="right: 50px; top: -80px" :tabindex="atEnd ? -1 : 0" :class="{ 'opacity-50 cursor-not-allowed': atEnd }">
                <span aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 bg-white rounded-full text-primary-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
                <span class="sr-only">Skip to next slide page</span>
            </button>
        </div>
    </div>
</div>
