<li x-bind="disableNextAndPreviousButtons" class="flex flex-col items-center justify-center w-full p-2 shrink-0 snap-start" role="option">
    <div class="grid w-full max-w-lg grid-cols-1 md:flex-col md:mb-0 md:space-x-0 md:max-w-none">
        <!-- Start IMage Slider -->
        {{if elements.images | count > 1}}
        <div id="indicators-carousel-estate-slider" class="relative w-full" data-carousel="static">
            <!-- Carousel wrapper -->
            <div class="relative w-auto overflow-hidden rounded-t-lg h-80 min-w-64">
                <!-- Carousel Items -->
                {{elements.images limit="3"}}
                {{if url}} {{url += '@600x400'}} {{/if}}
                <div data-carousel-item="{{{item} == 0 ? 'active' :''}}">
                        <img data-src="{{url ?: asset('img/300x200.png')}}"
                        alt="{{ title ?: 'Bild Referenz' }}"
                            class="absolute inset-0 object-cover w-full h-full rounded-t-lg object-fit-cover lazy"
                            loading="lazy"/>
                            <div class="absolute transform -translate-x-1/2 -translate-y-1/2 spinner top-1/2 left-1/2">
                        <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 008 8V12A4 4 0 004 8"></path>
                        </svg>
                    </div>
                    </div>
                {{/elements.images}}
            </div>
            <!-- Slider indicators -->
            {{if elements.images | count > 1}}
                <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
                    {{elements.images limit="3"}}
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="{{ index - 1 }}"></button>
                    {{/elements.images}}
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
            {{/if}}
        </div>
        {{elseif elements.images | count == 1}}
        <div class="relative w-auto overflow-hidden rounded-t-lg h-80 min-w-64">
            {{elements.images limit="3"}}
            {{if url}} {{url += '@600x400'}} {{/if}}
                <img data-src="{{url ?: asset('img/300x200.png')}}"
                        alt="{{ title ?: 'Bild Referenz' }}"
                            class="absolute inset-0 object-cover w-full h-full rounded-t-lg object-fit-cover lazy"
                            loading="lazy"/>
                            <div class="absolute transform -translate-x-1/2 -translate-y-1/2 spinner top-1/2 left-1/2">
                        <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 008 8V12A4 4 0 004 8"></path>
                        </svg>
                    </div>
            {{/elements.images}}
        </div>
        {{else}}
        <div class="relative w-full ">
                    <!-- Carousel wrapper -->
                <div class="relative w-auto overflow-hidden h-80 min-w-64">
                    <div>
                        <img data-src="https://upload.wikimedia.org/wikipedia/commons/3/3f/Placeholder_view_vector.svg" class="absolute inset-0 object-cover w-full h-full rounded-t-lg object-fit-cover lazy" loading="lazy"/>
                        <div class="absolute transform -translate-x-1/2 -translate-y-1/2 spinner top-1/2 left-1/2">
                        <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 008 8V12A4 4 0 004 8"></path>
                        </svg>
                    </div>
                    </div>
                </div>
            </div>
            {{/if}}
            <!-- End IMage Slider -->

            {{if references_slider_type == "references_type_2"}}
            <!-- Verspieltere Section -->
            <div class="px-5 pt-2 pb-2 space-y-2 border rounded-b-lg md:pt-0">
                <a href="/immobilien/details/{{Id}}" class="space-y-3" target="_blank">
                    <div class="space-y-2 text-md mb-2.5 text-lg h-14 font-bold text-gray-900 md:mt-4 ">
                        <div class="grid grid-cols-2 space-x-0 text-gray-500 md:space-y-0 md:space-x-2 dark:text-gray-400">
                            <div class="flex space-x-2 text-gray-500 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                <span>{{elements.objektart | ucfirst}}</span>
                            </div>
                            <div class="ml-2">
                                <div class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512 301.55">
                                        <path fill-rule="nonzero" d="m31.69 154.31 191.77 114.61-.88-10.31c-.4-4.93 3.27-9.27 8.19-9.67 4.93-.4 9.27 3.27 9.67 8.19l2.7 31.8c.4 4.93-3.27 9.26-8.19 9.67l-31.21 2.64c-4.92.4-9.26-3.26-9.66-8.19-.4-4.93 3.26-9.27 8.19-9.67l9.22-.78L23.32 170.13l2.39 8.94c1.28 4.78-1.56 9.69-6.34 10.97-4.77 1.27-9.68-1.57-10.96-6.34l-8.1-30.25c-1.28-4.77 1.56-9.69 6.33-10.96l30.82-8.26c4.77-1.27 9.69 1.57 10.96 6.34 1.28 4.77-1.56 9.69-6.34 10.96l-10.39 2.78zm271.7 38.46-11.94-11.94c-3.5-3.49-3.5-9.17 0-12.67s9.18-3.5 12.68 0l15.02 15.02 109.48-66.64-64.78-36.93-86.08 62.19 6 6c3.49 3.49 3.49 9.17 0 12.67-3.5 3.5-9.18 3.5-12.68 0l-8.04-8.04-12.54 9.06c-4 2.88-9.58 1.97-12.46-2.03-2.88-4-1.98-9.59 2.03-12.47l106.72-77.1-88.9-50.68-46.69 26.36 36.57 32.38c.75.57 1.43 1.26 1.99 2.07 2.82 4.06 1.82 9.65-2.24 12.47l-92.35 64.22 40 23.9 24.53-20.06c3.82-3.13 9.47-2.56 12.6 1.26 3.14 3.83 2.57 9.48-1.25 12.61l-19.52 15.96 48.34 28.88 43.51-26.49zm147.5-68.85L264.58 237.33a8.893 8.893 0 0 1-9.24.04L64.39 123.29a9.055 9.055 0 0 1-3.18-3.29c-2.41-4.29-.89-9.74 3.4-12.15L253.05 1.46c2.71-1.77 6.29-2 9.3-.29l188.17 107.27c1.34.73 2.5 1.8 3.34 3.19 2.57 4.21 1.24 9.72-2.97 12.29zM194.76 54.85l-108 60.98 51.54 30.79 89.67-62.36-33.21-29.41zm124.09 229.1c4.77 1.26 7.63 6.16 6.37 10.93-1.25 4.77-6.15 7.63-10.93 6.37l-30.27-8c-4.78-1.26-7.63-6.16-6.38-10.93l8.16-30.85c1.26-4.77 6.16-7.62 10.93-6.37 4.77 1.26 7.62 6.16 6.37 10.93l-2.83 10.72 179.61-103.61-9.96-2.67c-4.78-1.28-7.62-6.19-6.34-10.96 1.27-4.78 6.19-7.62 10.96-6.34l30.82 8.26c4.77 1.27 7.61 6.19 6.33 10.96l-8.1 30.25c-1.28 4.77-6.19 7.61-10.96 6.34-4.78-1.28-7.62-6.19-6.34-10.97l2.52-9.42-178.66 103.06 8.7 2.3z" />
                                    </svg>
                                    <span class="ml-2">{{elements.wohnflaeche | round}} &#x33A1;</span>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 space-x-0 text-gray-500 md:space-y-0 md:space-x-2 dark:text-gray-400">
                            <div class="flex space-x-2 text-gray-500 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                <span class="ml-2">{{elements.ort| truncate:15:...}}</span>
                            </div>
                            <div class="flex">
                                {{if elements.vermarktungsart == 'miete'}}
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" width="25" height="25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.879 110.328" enable-background="new 0 0 122.879 110.328" xml:space="preserve">
                                    <g>
                                        <path d="M11.098,5.322l5.111-4.927c0.55-0.529,1.419-0.524,1.964,0l5.178,4.994c0.289,0.277,0.434,0.649,0.434,1.021v4.77 l92.819,0.006l4.864,0.028c0.781,0.002,1.412,0.64,1.41,1.42c-0.001,0.218-0.052,0.425-0.142,0.609l-4.991,10.331 c-0.243,0.506-0.749,0.801-1.276,0.801l-22.511,0.001v3.383h-6.882v-3.383l-40.771,0.001v3.381h-6.882v-3.381H23.787l0.003,81.802 c0,1.136-0.47,2.173-1.219,2.924c-0.757,0.755-1.797,1.225-2.929,1.225h-4.904c-1.139,0-2.178-0.468-2.929-1.219l-0.089-0.097 c-0.698-0.743-1.13-1.742-1.13-2.833V24.379H4.148c-1.138,0-2.177-0.47-2.928-1.221C0.47,22.408,0,21.369,0,20.231v-4.904 c0-1.139,0.467-2.178,1.219-2.93c0.75-0.75,1.787-1.218,2.929-1.218h6.442V6.41C10.59,5.973,10.788,5.583,11.098,5.322 L11.098,5.322z M54.915,47.739l-0.076,2.939h1.724l2.94-0.076l0.279,0.354l-0.305,3.701l-3.269-0.076h-1.47v0.329l0.202,5.323 h-5.094l0.253-4.814l-0.253-11.583h10.948l0.279,0.354l-0.329,3.701l-4.055-0.152H54.915L54.915,47.739z M69.795,43.532 c2.383,0,4.224,0.706,5.525,2.116c1.301,1.411,1.951,3.401,1.951,5.968c0,2.839-0.715,5.035-2.142,6.59 c-1.428,1.554-3.451,2.331-6.07,2.331c-2.381,0-4.223-0.713-5.523-2.141c-1.301-1.429-1.952-3.451-1.952-6.07 c0-2.805,0.714-4.972,2.142-6.5C65.154,44.297,67.177,43.532,69.795,43.532L69.795,43.532z M69.34,47.587 c-0.659,0-1.158,0.114-1.496,0.342c-0.338,0.229-0.578,0.63-0.723,1.204c-0.143,0.575-0.214,1.411-0.214,2.509 c0,1.403,0.075,2.467,0.228,3.193c0.152,0.727,0.409,1.233,0.773,1.521c0.362,0.287,0.898,0.431,1.608,0.431 c0.659,0,1.157-0.114,1.495-0.343s0.579-0.633,0.722-1.216c0.145-0.583,0.216-1.424,0.216-2.522c0-1.385-0.076-2.441-0.229-3.167 c-0.151-0.727-0.409-1.234-0.772-1.521C70.585,47.731,70.049,47.587,69.34,47.587L69.34,47.587z M90.378,53.771 c1.217,1.893,2.433,3.649,3.65,5.271l-0.076,0.559c-1.724,0.523-3.422,0.835-5.095,0.937l-0.48-0.405l-0.305-0.634 c-0.135-0.271-0.406-0.84-0.811-1.71c-0.406-0.87-0.761-1.686-1.065-2.446h-1.698l0.179,4.891h-5.095l0.254-4.814l-0.254-11.583 l7.78-0.025c1.842,0,3.261,0.434,4.257,1.305c0.998,0.87,1.496,2.125,1.496,3.764c0,0.962-0.24,1.866-0.723,2.711 C91.911,52.437,91.24,53.163,90.378,53.771L90.378,53.771z M87.768,49.387c0-0.675-0.173-1.179-0.52-1.507 c-0.346-0.33-0.907-0.512-1.685-0.545L84.65,47.41l-0.101,4.232l1.849,0.102c0.474-0.221,0.82-0.516,1.04-0.887 C87.658,50.484,87.768,49.994,87.768,49.387L87.768,49.387z M52.64,77.692c1.217,1.893,2.433,3.648,3.65,5.271l-0.076,0.559 c-1.724,0.523-3.422,0.835-5.095,0.938l-0.48-0.406l-0.305-0.634c-0.135-0.271-0.406-0.84-0.811-1.71 c-0.406-0.87-0.76-1.686-1.065-2.445H46.76l0.178,4.891h-5.094l0.254-4.814l-0.254-11.583l7.78-0.024 c1.843,0,3.261,0.435,4.258,1.305c0.998,0.87,1.496,2.125,1.496,3.764c0,0.963-0.24,1.866-0.723,2.712 C54.173,76.357,53.502,77.083,52.64,77.692L52.64,77.692z M50.03,73.308c0-0.676-0.173-1.179-0.52-1.508 c-0.346-0.33-0.907-0.511-1.685-0.544l-0.913,0.075l-0.101,4.232l1.849,0.102c0.473-0.221,0.82-0.516,1.039-0.888 C49.92,74.405,50.03,73.915,50.03,73.308L50.03,73.308z M69.712,80.1l0.279,0.354l-0.305,3.7H58.13l0.254-4.814L58.13,67.757 h11.759l0.279,0.354l-0.329,3.701L65.81,71.66h-2.611l-0.05,2.307h2.509l2.636-0.076l0.278,0.354l-0.305,3.7l-2.939-0.075h-2.281 l-0.024,0.962l0.051,1.419h2.433L69.712,80.1L69.712,80.1z M86.81,78.807l0.202,5.348h-5.524l-4.612-8.77H76.57l-0.025,2.84 l0.203,5.93h-4.612l0.253-4.814l-0.253-11.583h5.524l4.612,8.77h0.304l-0.151-8.591l4.663-0.279L86.81,78.807L86.81,78.807z M101.904,68.111l-0.278,3.701l-3.347-0.152h-0.304l-0.126,7.172l0.202,5.322h-5.068l0.254-4.814l-0.127-7.68h-0.33l-3.37,0.152 l-0.304-0.354l0.278-3.701h12.241L101.904,68.111L101.904,68.111z M37.906,31.007h66.599c2.104,0,4.02,0.866,5.406,2.251 c1.396,1.397,2.26,3.313,2.26,5.415v50.646c0,2.098-0.865,4.012-2.255,5.404l-0.01,0.011c-1.394,1.388-3.306,2.252-5.401,2.252 H37.906c-2.101,0-4.017-0.864-5.408-2.253c-1.393-1.395-2.258-3.311-2.258-5.414V38.673c0-2.109,0.862-4.027,2.25-5.416 S35.797,31.007,37.906,31.007L37.906,31.007z M104.505,34.797H37.906c-1.065,0-2.036,0.437-2.738,1.139 c-0.701,0.701-1.139,1.672-1.139,2.737v50.646c0,1.064,0.438,2.037,1.137,2.739c0.704,0.7,1.677,1.138,2.74,1.138h66.599 c1.065,0,2.034-0.437,2.733-1.137c0.706-0.706,1.143-1.675,1.143-2.74V38.673c0-1.063-0.437-2.036-1.138-2.74 C106.541,35.234,105.569,34.797,104.505,34.797L104.505,34.797z" />
                                    </g>
                                </svg>
                                <div class="ml-2">{{ elements.warmmiete| round }} &nbsp;&euro;</div>
                                {{else}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 7.756a4.5 4.5 0 100 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="ml-2">{{elements.kaufpreis | round}} &nbsp;&euro;</div>
                                    {{/if}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Ende verspieltere Section -->
            {{else}}
            <!-- Neue Section -->
            <div class="relative px-5 pt-2 pb-2 border rounded-b-lg md:pt-0">
                <div class="space-y-2 text-md mb-2.5 text-lg font-bold text-gray-900 md:mt-4 ">
                    <div class="flex space-x-2 text-gray-700 dark:text-gray-400">
                        {{if elements.wohnflaeche != 0.00}}<span>{{ elements.wohnflaeche }} m&sup2;</span>
                        <span class="mx-1">
                            ·
                        </span>
                        {{/if}}
                        {{if elements.anzahl_zimmer != 0}}
                            <span class="ml-2">{{ elements.anzahl_zimmer | round }} Zimmer </span>
                        {{/if}}
                        {{if elements.baujahr != 0}}<span class="mx-1">
                                ·
                            </span><span class="ml-2">Baujahr: {{ elements.baujahr }} </span>{{/if}}
                    </div>
                    <div class="grid grid-cols-4">
                        <div class="flex col-span-3 space-x-2 text-gray-500 dark:text-gray-400">
                        <span class="capitalize">
                                {{elements.objektart | ucfirst}}
                            </span>
                            {{if !elements.ort AND !elements.objektart}}
                            <span>Kein Ort angegeben</span>
                            {{/if}}
                            {{if elements.ort}}
                            <span class="mx-1">
                                ·
                            </span>
                            <span class="ml-2">
                                {{elements.ort| truncate:35:...}}
                            </span>
                            {{/if}}
                        </div>
                        <div class="text-right invisible sm:visible">
                        {{if elements.vermarktungsart}}
                        {{if elements.vermarktungsart == 'kauf'}}
                        <span class="capitalize inline-flex hidden lg:block items-center rounded-full bg-primary-900 px-2.5 py-0.5 text-sm font-medium text-white">
                                        verkauft
                                    </span>
                        {{/if}}
                        {{if elements.vermarktungsart == 'miete'}}
                        <span class="capitalize inline-flex hidden lg:block items-center rounded-full border border-primary text-primary px-2.5 py-0.5 text-sm font-medium">
                                        miete
                                    </span>
                        {{/if}}
                        {{/if}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ende Neue Section -->
            {{/if}}
        </div>
</li>
