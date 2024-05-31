<div class="grid w-full max-w-lg grid-cols-1 mx-auto md:flex-col md:mb-0 md:space-x-0 md:max-w-none">
    {{if elements.images | count > 0}}
    <div id="indicators-carousel-estate-columns" class="relative w-full" data-carousel="static">
        <!-- Carousel wrapper -->
        <div class="relative w-auto overflow-hidden rounded-t-lg h-72 min-w-64">
            <!-- Item 1 -->
            {{ elements.images | limit:3 }}
            {{if url}} {{url += '@600x400'}} {{/if}}
            <div x-data="{ loading: true,}">
                <div class="hidden" data-carousel-item="{{ item == 1 ? 'active' : '' }}">
                    <!-- Image -->
                    <img x-ref="img" class="absolute inset-0 object-cover w-full h-full rounded-t-lg lazy object-fit-cover" loading="lazy" data-src="{{ url ?: 'https://upload.wikimedia.org/wikipedia/commons/3/3f/Placeholder_view_vector.svg' }}" alt="{{ elements.objekttitel }}" />
                </div>

                <!-- Spinner -->
                <div class="absolute inset-0 flex items-center justify-center" x-show="loading">
                    <div class="spinner">
                        <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 008 8V12A4 4 0 004 8"></path>
                        </svg>
                    </div>
                </div>
            </div>
            {{ /elements.images }}
        </div>


        <!-- Slider indicators -->
        <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
            {{elements.images limit="3"}}
            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" :aria-label="'Slide ' + {{index}}" @click="carouselSlideTo({{index - 1}})"></button>
            {{/elements.images}}
        </div>
        <!-- Slider controls -->
        <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer focus:outline-none group" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 group-focus:ring-4 group-focus:ring-white group-focus:outline-none bg-white/30 /30 dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70 group-hover:bg-white/50">
                <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer focus:outline-none group" data-carousel-next>
            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 group-focus:ring-4 group-focus:ring-white group-focus:outline-none bg-white/30 /30 dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70 group-hover:bg-white/50">
                <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>
    {{else}}
        <div class="relative w-full">
            <!-- Carousel wrapper -->
            <div class="relative w-auto overflow-hidden h-80 min-w-64 ">
                <div>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/3/3f/Placeholder_view_vector.svg" class="absolute inset-0 object-cover w-full h-full rounded-t-lg lazy object-fit-cover" loading="lazy" data-src="https://upload.wikimedia.org/wikipedia/commons/3/3f/Placeholder_view_vector.svg" />
                </div>
            </div>
        </div>
        {{/if}}
        <!-- End IMage Slider -->


        <!-- Neue Section -->
        <div class="relative px-5 pt-2 pb-2 border rounded-b-lg md:pt-0">
            <h3 class="flex justify-between mb-2.5 text-lg font-bold text-gray-900 md:mt-4 ">
                <span>
                    {{ if elements.vermarktungsart == "miete" }}
                        {{if elements.warmmiete > 0}}
                            {{ elements.warmmiete | format_number:0:',':'.' }} €
                        {{else}}
                            Preis auf Anfrage
                        {{/if}}
                    {{ else }}
                    {{ elements.kaufpreis | format_number:0:',':'.' }} €
                    {{ /if }}
                </span>
                {{ if elements.vermarktungsart == "miete" }}
                <span class="capitalize inline-flex items-center rounded-full bg-primary-900 px-2.5 py-0.5 text-sm font-bold text-white">
                    {{ elements.vermarktungsart }}
                </span>
                {{ else }}
                <span class="capitalize inline-flex items-center rounded-full border border-primary text-primary px-2.5 py-0.5 text-sm font-bold">
                    {{ elements.vermarktungsart }}
                </span>
                {{ /if }}
            </h3>
            <div class="space-y-2 text-md">
                <div class="flex space-x-2 text-gray-700 dark:text-gray-400">
                    {{if elements.wohnflaeche}}<span><strong>{{ elements.wohnflaeche| round }}</strong> m&sup2;</span>{{/if}}
                    {{if elements.anzahl_zimmer}}<span class="ml-2"> · <strong>{{ elements.anzahl_zimmer | round }}</strong> Zimmer </span>{{/if}}
                    {{if elements.baujahr}}<span class="ml-2 hidden lg:block"> · <strong>{{ elements.baujahr }}</strong> (Baujahr)</span>{{/if}}
                </div>
                <div class="flex space-x-2 text-gray-500 dark:text-gray-400">
                    <span class="capitalize">
                        <strong>
                            {{if elements.objektart == "buero_praxen"}}
                                Büros/ Praxen
                            {{elseif elements.objektart == "hallen_lager_prod"}}
                                Hallen/ Lager/ Produktion
                            {{elseif elements.objektart == "zinshaus_renditeobjekt"}}
                                Zins und Renditeobjekt
                            {{else}}
                                {{elements.objektart | ucfirst}}
                            {{/if}}
                        </strong>
                    </span>
                    {{if elements.objektart}}
                    <span>in</span>
                    {{/if}}
                    <span>
                        <strong>{{elements.ort| truncate:45:...}}</strong>
                    </span>
                </div>
            </div>
            <div class="my-2 border-t border-gray-300"></div>
            <div class="flex flex-col items-center justify-center" x-data="{ logoUrl: '{{ $logoUrl }}' }">
                <div class="flex items-center justify-between w-full"> <!-- Add 'items-center' class here -->
                    <img loading="lazy" class="max-w-[100px]" src="/logo_images/logo.png" alt="Ihr Kontakt">
                    <a href="/immobilien/details/{{id}}" class="inline-flex justify-center items-center py-2.5 px-5 text-md font-medium text-center md:w-auto lg:col-span-12 focus:ring-4 focus:outline-none" target="_blank">Ansehen<span aria-hidden="true">&nbsp;→</span></a>
                </div>
            </div>
        </div>
        <!-- Ende Neue Section -->
</div>
