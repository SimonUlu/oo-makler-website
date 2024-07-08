<div id="estate-recommendation-outer-html" class="max-w-screen-xl px-4 py-8 mx-auto lg:py-16 lg:px-6">
    <div class="max-w-screen-lg mx-auto text-center">
        <h2 class="mb-4 text-4xl font-extrabold tracking-tight text-primary-600">Keine Immobilie gefunden.</h2>
        <p class="mb-8 font-medium text-gray-500 sm:text-2xl dark:text-gray-400">Für Ihre Suchanfragen haben
            wir keine Immobilie gefunden. Vielleicht finden Sie aber die folgenden Immobilien interessant.
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
                        estate: @json($estate),
                        image: {
                            src: '{{ isset($estate->get('estate_images')[0]['url']) ? $estate->get('estate_images')[0]['url'] : 'https://via.placeholder.com/300x200' }}',
                            alt: '{{ isset($estate->get('estate_images')[0]['title']) ? $estate->get('estate_images')[0]['title'] : 'Platzhalter Objekttitel' }}',
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
                    }" x-init="setImageSrcAsync($refs.image, '{{ isset($estate->get('estate_images')[0]['url']) ? $estate->get('estate_images')[0]['url'] : 'https://via.placeholder.com/300x200' }}', '{{ isset($estate->get('estate_images')[0]['title']) ? $estate->get('estate_images')[0]['title'] : 'Platzhalter Objekttitel' }}')">
                    <div class="relative w-full">
                        <div class="relative flex items-center justify-center w-auto overflow-hidden rounded-t-lg h-80 min-w-64">
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
                            <a href="/immobilien/details/{{ $estate->get('id_internal') }}">
                                <img x-ref="image"
                                     class="absolute inset-0 object-cover w-full h-full x-src object-fit-cover" />
                            </a>
                        </div>
                    </div>
                    <!-- End Image Slider -->

                    <!-- Neue Section -->
                    <div class="relative px-5 pt-2 pb-2 bg-white border rounded-b-lg shadow-lg md:pt-0">
                        <h3 class="flex justify-between mb-2.5 text-lg font-bold text-gray-900 md:mt-4">
                            <span>
                                @if ($estate->get('vermarktungsart') == 'miete' && $estate->get('warmmiete') !== null)
                                    {{ number_format($estate->get('warmmiete'), 0, ',', '.') }} €
                                @elseif ($estate->get('vermarktungsart') != 'miete' && $estate->get('kaufpreis') !== null)
                                    {{ number_format($estate->get('kaufpreis'), 0, ',', '.') }} €
                                @endif
                            </span>
                            @if ($estate->get('vermarktungsart') == 'miete')
                                <span class="capitalize inline-flex items-center rounded-full bg-primary-900 px-2.5 py-0.5 text-sm font-medium text-white">
                                    {{ $estate->get('vermarktungsart') }}
                                </span>
                            @else
                                <span class="capitalize inline-flex items-center rounded-full border border-primary text-primary px-2.5 py-0.5 text-sm font-medium">
                                    {{ $estate->get('vermarktungsart') }}
                                </span>
                            @endif
                        </h3>
                        <div class="space-y-2 text-md">
                            <div class="flex space-x-2 text-gray-700 dark:text-gray-400">
                                @php
                                    $details = [];

                                    if ($estate->get('wohnflaeche') !== null && $estate->get('wohnflaeche') !== 0.00) {
                                        $details[] = $estate->get('wohnflaeche') . ' m&sup2;';
                                    }

                                    if ($estate->get('anzahl_zimmer') !== null && $estate->get('anzahl_zimmer') !== 0) {
                                        $details[] = round($estate->get('anzahl_zimmer')) . ' Zimmer';
                                    }

                                    if ($estate->get('baujahr') !== null && $estate->get('baujahr') !== 0) {
                                        $details[] = $estate->get('baujahr');
                                    }
                                @endphp

                                @foreach ($details as $index => $detail)
                                    @if ($index > 0)
                                        <span class="ml-2"> · </span>
                                    @endif
                                    <span>{!! $detail !!}</span>
                                @endforeach
                            </div>
                            <div class="text-left" x-data="estateRecommendationComponent()">
                                <span class="capitalize">
                                    <span x-text="getTranslation('{{$estate->get('objektart')}}')"></span>
                                </span>
                                <span class="ml-1">
                                    {{ Str::limit($estate->get('ort'), 45, '...') }}
                                </span>
                            </div>
                        </div>
                        <div class="my-4 border-t border-gray-300"></div>
                        <div class="flex flex-col items-center justify-center">
                            <div class="flex items-center justify-between w-full">
                                <img class="max-w-[100px]" src="/logo_images/logo.png" alt="Ihr Kontakt">
                                <a href="/immobilien/details/{{ $estate->get('id_internal') }}"
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

    <script>
        function estateRecommendationComponent() {
            return {
                estate: {},
                estateFields: @json($estateFields),

                getTranslation(objektart) {
                    console.log(objektart)
                    if (!objektart) return '';
                    return this.estateFields.objektart.permittedvalues[objektart] || (objektart.charAt(0).toUpperCase() + objektart.slice(1));
                },
            };
        }
    </script>
</div>
