<li x-bind="disableNextAndPreviousButtons" class="flex flex-col items-center justify-center w-full p-2 md:w-1/2 lg:w-1/3 shrink-0 snap-start" role="option">
    <div class="grid w-full max-w-lg grid-cols-1 md:flex-col md:mb-0 md:space-x-0 md:max-w-none">
        <!-- Start IMage Slider -->
        {{if images | count > 2}}
        <div id="indicators-carousel-estate-slider" class="relative w-full" data-carousel="static">
            <!-- Carousel wrapper -->
            <div class="relative w-auto overflow-hidden rounded-t-lg h-80 min-w-64">
                <!-- Carousel Items -->
                {{images limit="3"}}
                {{if url}} {{url += '@600x400'}} {{/if}}
                <div data-carousel-item="{{{item} == 0 ? 'active' :''}}">
                        <img src="{{ url ?: 'https://upload.wikimedia.org/wikipedia/commons/3/3f/Placeholder_view_vector.svg' }}"
                            class="absolute inset-0 object-cover w-full h-full object-fit-cover" alt="{{ title }}" />
                    </div>
                {{/images}}
            </div>
            <!-- Slider indicators -->
            <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
                {{images limit="3"}}
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="{{index -1}}"></button>
                {{/images}}
            </div>
            <!-- Slider controls -->
            <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 /30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 /30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
        {{else}}
        <div class="relative w-full" >
            <!-- Carousel wrapper -->
            <div class="relative w-auto overflow-hidden h-80 min-w-64">
                <div >
                    <img src="https://upload.wikimedia.org/wikipedia/commons/3/3f/Placeholder_view_vector.svg"
                        class="absolute inset-0 object-cover w-full h-full object-fit-cover">
                </div>
            </div>
        </div>
        {{/if}}
        <!-- End IMage Slider -->

            <!-- Neue Section -->
            <div class="relative px-5 pt-2 pb-2 border rounded-b-lg md:pt-0">
                <h3
                    class="mb-2.5 text-lg font-bold text-gray-900 md:mt-4 "
                >
                {{ if vermarktungsart == "miete" }}
                    {{ warmmiete | round }} €
                {{ else }}
                    {{ kaufpreis | round }} €
                {{ /if }}
                </h3>
                <div class="space-y-2 text-md">
                    <div class="flex space-x-2 text-gray-700 dark:text-gray-400">
                        <span>{{ wohnflaeche }} m&sup2;</span>
                        <span class="ml-2"> · {{ anzahl_zimmer | round }} Zimmer </span>
                        <span class="ml-2"> · {{ baujahr }} </span>
                    </div>
                    <div class="flex space-x-2 text-gray-500 dark:text-gray-400">
                        <span class="capitalize">
                            {{objektart | ucfirst}}
                        </span>
                        <span class="ml-2">
                            {{ort| truncate:13:...}}
                        </span>
                    </div>
                </div>
                <div class="my-4 border-t border-gray-300"></div>
                <div class="flex flex-col items-center justify-center hidden sm:flex sm:col-span-2" x-data="{ logoUrl: '{{ $logoUrl }}' }">
                    <div class="flex items-center justify-between w-full"> <!-- Add 'items-center' class here -->
                        <img class="max-w-[50px]" src="/logo_images/badge-blue.png" alt="Ihr Kontakt">
                        {{# <a href="/immobilien/details/{{Id}}" class="inline-flex justify-center items-center py-2.5 px-5 text-sm font-medium text-center text-white md:w-auto lg:col-span-12 focus:ring-4 focus:outline-none bg-primary-700 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 hover:bg-primary-800 focus:ring-primary-300">Ansehen<span aria-hidden="true">&nbsp;→</span></a> #}}
                        <a href="/immobilien/details/{{Id}}" class="inline-flex justify-center items-center py-2.5 px-5 text-sm font-medium text-center md:w-auto lg:col-span-12 focus:ring-4 focus:outline-none" target="_blank">Ansehen<span aria-hidden="true">&nbsp;→</span></a>
                    </div>
                </div>
            </div>
            <!-- Ende Neue Section -->
    </div>
</li>
