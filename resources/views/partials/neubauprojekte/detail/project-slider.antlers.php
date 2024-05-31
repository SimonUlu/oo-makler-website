<section aria-labelledby="related-heading" class="px-4 py-16 mt-10 border-t border-gray-200 sm:px-0">
    <h2 id="related-heading" class="text-xl font-bold text-gray-900">
        Weitere Neubauprojekte
    </h2>

    <div class="grid grid-cols-1 mt-8 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
        {{collection:neubauprojekte limit="4"}}
        <div>
            <div class="relative">
                <div id="indicators-carousel-estate-columns" class="relative w-full" data-carousel="static">
                    <!-- Carousel wrapper -->
                    <div class="relative w-auto overflow-hidden h-80 min-w-64">
                        <!-- Item 1 -->
                        {{images limit="3"}}
                        <div class="hidden" data-carousel-item="{{item == 0 ? 'active' :''}}">
                            <img src="{{ image.0.url ?: 'https://spaces.whynow.co.uk/2021/05/tenor.gif' }}" class="absolute inset-0 object-cover w-full h-full object-fit-cover" alt="{{ title }}" />
                        </div>
                        {{/images}}
                    </div>

                    <!-- Slider indicators -->
                    <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
                        {{ images limit="3" }} {{ if image.0.url }}
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide {{index}}" data-carousel-slide-to="{{index = index -1}}"></button>
                        {{ /if }} {{ /images }}
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
                <div class="relative mt-4">
                    <h3 class="text-sm font-medium text-gray-900">
                        {{ if title | is_empty }} {{ 'Kein Titel' }} {{ else }}
                        {{ title | truncate:25:... }} {{/if}}
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">{{ort}}</p>
                </div>
            </div>
            <div class="mt-6">
                <a href="/projekte/{{slug}}" class="relative flex items-center justify-center px-8 py-2 text-sm font-medium text-gray-900 bg-gray-100 border border-transparent rounded-md hover:bg-gray-200">Ansehen</a>
            </div>
        </div>
        {{/collection:neubauprojekte}}

        <!-- More products... -->
    </div>
</section>