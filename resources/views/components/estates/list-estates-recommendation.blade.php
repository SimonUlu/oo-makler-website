    <div id="estate-recommendation-outer-html" class="max-w-screen-xl px-4 py-8 mx-auto lg:py-16 lg:px-6">
        <div class="max-w-screen-lg mx-auto text-center">
            <h2 class="mb-4 text-4xl font-extrabold tracking-tight text-primary-600">Keine Immobilie gefunden.</h2>
            <p class="mb-8 font-medium text-gray-500 sm:text-2xl dark:text-gray-400">Für Ihre Suchanfragen haben
                wir keine Immobilie gefunden. Vielleich finden Sie aber die folgenden Immobilien interessant.
            </p>

            <div class="py-4 pt-6 text-center">
                <a href="/immobilien" class="inline-flex items-center px-12 py-3 mx-2 font-bold text-center text-white rounded-lg lg:px-5 focus:ring-4 focus:outline-none bg-primary-700 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 hover:bg-primary-800 focus:ring-primary-900" target="_blank">Zu allen Immobilien<span aria-hidden="true">&nbsp;→</span></a>
            </div>

            <div class="grid grid-cols-1 estate-recommendation-wrapper lg:grid-cols-3 md:grid-cols-2 gap-x-2 gap-y-4">
                @php
                    $numItems = min(3, $estates->count());
                @endphp

                @foreach ($estates->random($numItems) as $index => $estate)
                    <div class="grid max-w-lg grid-cols-1 shadow-lg md:flex-col md:mb-0 md:space-x-0 md:max-w-none"
                        x-data="{
                            image: {
                                src: '{{ isset($estate['elements']['images'][0]['url']) ? $estate['elements']['images'][0]['url'] : asset('img/300x200.png')}}',
                                alt: '{{ isset($estate['elements']['images'][0]['title']) ? $estate['elements']['images'][0]['title'] : 'Platzhalter Objekttitel' }}',
                            },
                            setImageSrcAsync: (el, src, alt) => {
                                let img = new Image();
                                let $spinner = el.nextElementSibling;
                                img.onload = () => {
                                    el.src = src;
                                    el.alt = alt;
                                    if ($spinner) $spinner.style.display = 'none';
                                };
                                img.src = src;
                            }
                        }" x-init="setImageSrcAsync($refs.image, '{{ isset($estate['elements']['images'][0]['url']) ? $estate['elements']['images'][0]['url'] : asset('img/300x200.png')}}', '{{ isset($estate['elements']['images'][0]['title']) ? $estate['elements']['images'][0]['title'] : 'Platzhalter Objekttitel' }}')">
                        <div id="indicators-carousel-estate-columns" class="relative w-full" data-carousel="static">
                            <!-- Carousel wrapper -->
                            <div
                                class="relative flex items-center justify-center w-auto overflow-hidden rounded-t-lg h-80 min-w-64">
                                <!-- Items -->
                                <div class="spinner"
                                    style="position: absolute; inset: 0; display: flex; justify-content: center; align-items: center;">
                                    <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 008 8V12A4 4 0 004 8"></path>
                                    </svg>
                                </div>
                                <a href="/immobilien/details/{{ $estate['id'] }}">
                                    <img x-ref="image"
                                        class="absolute inset-0 object-cover w-full h-full x-src object-fit-cover" />
                                </a>
                            </div>
                        </div>
                        <!-- End IMage Slider -->

                        <!-- Neue Section -->
                        <div class="relative px-5 pt-2 pb-2 bg-white border rounded-b-lg shadow-lg md:pt-0">
                            <h3 class="flex justify-between mb-2.5 text-lg font-bold text-gray-900 md:mt-4 ">
                                <span>
                                    @if ($estate['elements']['vermarktungsart'] == 'miete')
                                        {{ number_format($estate['elements']['warmmiete'], 0, ',', '.') }} €
                                    @else
                                        {{ number_format($estate['elements']['kaufpreis'], 0, ',', '.') }} €
                                    @endif
                                </span>
                                @if ($estate['elements']['vermarktungsart'] == 'miete')
                                    <span
                                        class="capitalize inline-flex items-center rounded-full bg-primary-900 px-2.5 py-0.5 text-sm font-medium text-white">
                                        {{ $estate['elements']['vermarktungsart'] }}
                                    </span>
                                @else
                                    <span
                                        class="capitalize inline-flex items-center rounded-full border border-primary text-primary px-2.5 py-0.5 text-sm font-medium">
                                        {{ $estate['elements']['vermarktungsart'] }}
                                    </span>
                                @endif
                            </h3>
                            <div class="space-y-2 text-md">
                                <div class="flex space-x-2 text-gray-700 dark:text-gray-400">
                                    @if (isset($estate['elements']['wohnflaeche']))
                                        <span>{{ $estate['elements']['wohnflaeche'] }} m&sup2;</span>
                                        <span class="ml-2"> · {{ round($estate['elements']['anzahl_zimmer']) }}
                                            Zimmer </span>
                                        <span class="ml-2"> · {{ $estate['elements']['baujahr'] }} </span>
                                    @endif
                                </div>
                                <div class="flex space-x-2 text-gray-500 dark:text-gray-400">
                                    <span class="capitalize">
                                        {{ ucfirst($estate['elements']['objektart']) }}
                                    </span>
                                    <span class="ml-1">
                                        {{ Str::limit($estate['elements']['ort'], 45, '...') }}
                                    </span>
                                </div>
                            </div>
                            <div class="my-4 border-t border-gray-300"></div>
                            <!-- BEGIN: ed8c6549bwf9 -->
                            <div class="flex flex-col items-center justify-center">
                                <div class="flex items-center justify-between w-full">
                                    <!-- Add 'items-center' class here -->
                                    <img class="max-w-[40px]" src="/logo_images/badge-blue.png" alt="Ihr Kontakt">
                                    <a href="/immobilien/details/{{ $estate['id'] }}"
                                        class="inline-flex justify-center items-center py-2.5 px-5 text-sm font-medium text-center md:w-auto lg:col-span-12 focus:ring-4 focus:outline-none"
                                        target="_blank">Ansehen<span aria-hidden="true">&nbsp;→</span></a>
                                </div>
                            </div>
                        </div>
                        <!-- Ende Neue Section -->
                    </div>
                @endforeach

            </div>

        </div>

    </div>
