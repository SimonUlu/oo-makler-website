<div x-data="slider()" class="relative mt-8">
    <div :class="`w-full grid ${slidesToShow === 1 ? 'grid-cols-1' : 'grid-cols-3'} lg:gap-6 lg:mt-6 lg:space-y-0 lg:space-x-2 space-y-10`">
        <template x-for="(estate, index) in estates" :key="estate.id_internal">
            <li
                class="flex flex-col items-center justify-center w-full p-2 shrink-0 snap-start"
                role="option"
                x-show="index >= activeSlides[0] && index < activeSlides[0] + slidesToShow"
            >
                <!-- Begin New Template -->
                <div class="grid w-full max-w-lg grid-cols-1 mx-auto md:flex-col md:mb-0 md:space-x-0 md:max-w-none">
                    <template x-if="estate.estate_images.length > 0">
                        <div id="indicators-carousel-estate-columns" class="relative w-full" data-carousel="static">
                            <!-- Carousel wrapper -->
                            <div class="relative w-auto overflow-hidden h-72 min-w-64">
                                <!-- Item 1 -->
                                <template x-for="(image, imgIndex) in estate.estate_images.slice(0, 3)" :key="imgIndex">
                                    <div x-data="{ loading: true }" class="hidden" :data-carousel-item="imgIndex === 0 ? 'active' : ''">
                                        <img x-ref="img" class="z-10 absolute inset-0 object-cover w-full h-full lazy object-fit-cover" loading="lazy" :data-src="image.url + '@600x400'" alt="estate.objekttitel" />
                                        <!-- Price Info Box -->
                                        <div class="absolute bottom-0 right-0 m-2 p-2 bg-white bg-opacity-70 backdrop-blur-sm rounded text-sm font-bold text-gray-900 z-10">
                                            <template x-if="estate.vermarktungsart === 'miete'">
                                                <span x-text="estate.warmmiete > 0 ? `${estate.warmmiete.toLocaleString()} €` : 'Preis auf Anfrage'"></span>
                                            </template>
                                            <template x-if="estate.vermarktungsart !== 'miete'">
                                                <span x-text="`${estate.kaufpreis.toLocaleString()} €`"></span>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Slider indicators -->
                            <div class="absolute z-10 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
                                <template x-for="(image, imgIndex) in estate.estate_images.slice(0, 3)" :key="imgIndex">
                                    <button type="button" class="w-3 h-3" aria-current="true" :aria-label="'Slide ' + (imgIndex + 1)" @click="carouselSlideTo(imgIndex)"></button>
                                </template>
                            </div>
                            <!-- Slider controls -->
                            <button type="button" class="absolute top-0 left-0 z-10 flex items-center justify-center h-full px-4 cursor-pointer focus:outline-none group" data-carousel-prev>
                                <span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 group-focus:ring-4 group-focus:ring-white group-focus:outline-none bg-white/30 /30 dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70 group-hover:bg-white/50">
                                    <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    <span class="sr-only">Previous</span>
                                </span>
                            </button>
                            <button type="button" class="absolute top-0 right-0 z-10 flex items-center justify-center h-full px-4 cursor-pointer focus:outline-none group" data-carousel-next>
                                <span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 group-focus:ring-4 group-focus:ring-white group-focus:outline-none bg-white/30 /30 dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70 group-hover:bg-white/50">
                                    <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    <span class="sr-only">Next</span>
                                </span>
                            </button>
                        </div>
                    </template>
                    <template x-if="estate.estate_images.length === 0">
                        <div class="relative w-full">
                            <!-- Carousel wrapper -->
                            <div class="relative w-auto overflow-hidden h-80 min-w-64 ">
                                <div>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/3/3f/Placeholder_view_vector.svg" class="absolute z-10 inset-0 object-cover w-full h-full lazy object-fit-cover" loading="lazy" data-src="https://upload.wikimedia.org/wikipedia/commons/3/3f/Placeholder_view_vector.svg" />
                                </div>
                                <!-- Price Info Box -->
                                <div class="absolute bottom-0 right-0 m-2 p-2 bg-white bg-opacity-70 backdrop-blur-sm rounded text-sm font-bold text-gray-900 z-10">
                                    <template x-if="estate.vermarktungsart === 'miete'">
                                        <span x-text="estate.warmmiete > 0 ? `${estate.warmmiete.toLocaleString()} €` : 'Preis auf Anfrage'"></span>
                                    </template>
                                    <template x-if="estate.vermarktungsart !== 'miete'">
                                        <span x-text="`${estate.kaufpreis.toLocaleString()} €`"></span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!-- End Image Slider -->

                    <!-- Neue Section -->
                    <div class="relative px-5 pt-2 pb-2 border md:pt-0">
                        <h3 class="flex justify-between mb-2.5 text-lg font-bold text-gray-900 md:mt-4 ">
{{--                            <span x-text="estate.objekttitel.length > 30 ? estate.objekttitel.substring(0, 30) + '...' : estate.objekttitel"></span>--}}
                            <span x-text="estate.objekttitel"></span>
                            <template x-if="estate.vermarktungsart === 'miete'">
                                <span class="capitalize inline-flex items-center bg-primary-900 px-2.5 py-0.5 text-sm font-bold text-white">
                                    <span x-text="estate.vermarktungsart"></span>
                                </span>
                            </template>
                            <template x-if="estate.vermarktungsart !== 'miete'">
                                <span class="capitalize inline-flex items-center border border-primary text-primary px-2.5 py-0.5 text-sm font-bold">
                                    <span x-text="estate.vermarktungsart"></span>
                                </span>
                            </template>
                        </h3>
                        <div class="space-y-2 text-md">
                            <div class="flex space-x-2 text-gray-700 dark:text-gray-400">
                                <template x-if="estate.wohnflaeche">
                                    <span><strong x-text="Math.round(estate.wohnflaeche)"></strong> m&sup2; · </span>
                                </template>
                                <template x-if="estate.anzahl_zimmer">
                                    <span class="ml-2"> <strong x-text="Math.round(estate.anzahl_zimmer)"></strong> Zimmer · </span>
                                </template>
                                <template x-if="estate.baujahr">
                                    <span class="ml-2 hidden lg:block">  <strong x-text="estate.baujahr"></strong> (Baujahr)</span>
                                </template>
                            </div>
                            <div class="flex space-x-2 text-gray-500 dark:text-gray-400">
                                <span class="capitalize">
                                    <strong>
                                        <span x-text="getTranslation(estate.objektart)"></span>
                                    </strong>
                                </span>
                                <template x-if="estate.objektart">
                                    <span>in</span>
                                </template>
                                <span>
                                    <strong x-text="estate.ort.length > 30 ? estate.ort.substring(0, 30) + '...' : estate.ort"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="my-2 border-t border-gray-300"></div>
                        <div class="flex flex-col items-center justify-center" x-data="{ logoUrl: estate.logoUrl }">
                            <div class="flex items-center justify-center w-full my-2">
                                <a
                                    :href="`/immobilien/details/${estate.id_internal}`"
                                    class="inline-flex text-white bg-primary justify-center items-center py-2.5 px-5 text-md font-medium text-center md:w-auto lg:col-span-12 focus:ring-4 focus:outline-none"
                                    target="_blank"
                                >
                                    Ansehen<span aria-hidden="true">&nbsp;→</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Ende Neue Section -->
                </div>
                <!-- End New Template -->
            </li>
        </template>
    </div>
    <div class="flex justify-center space-x-2 mt-4">
        <template x-for="(page, pageIndex) in buttonCount" :key="pageIndex">
            <button
                x-on:click="activeSlides = [pageIndex * slidesToShow]"
                :class="{'bg-primary': activeSlides[0] === pageIndex * slidesToShow, 'bg-white': activeSlides[0] !== pageIndex * slidesToShow}"
                class="w-4 h-4 focus:outline-none border border-gray-700"
            ></button>
        </template>
    </div>
</div>

<script>

    function slider() {

        return {
            estates: @json($estates),
            activeSlides: [0],
            slidesToShow: 3,
            buttonCount: 0,
            estateFields: @json($estateFields),

            init() {
                this.updateSlidesToShow();
                this.updateButtonCount();
                window.addEventListener('resize', () => {
                    this.updateSlidesToShow();
                    this.adjustActiveSlides();
                    this.updateButtonCount();
                });
            },

            getTranslation(objektart) {
                return this.estateFields.objektart.permittedvalues[objektart] || (objektart.charAt(0).toUpperCase() + objektart.slice(1));
            },

            updateButtonCount() {
                this.buttonCount = Array(Math.ceil(Object.keys(this.estates).length / this.slidesToShow)).fill();
            },

            updateSlidesToShow() {
                // Show 1 slide if the screen is smaller than 768px, otherwise show 3
                this.slidesToShow = window.innerWidth < 768 ? 1 : 3;
            },

            adjustActiveSlides() {
                // Ensure activeSlides is correctly set after updating slidesToShow
                if (this.activeSlides[0] + this.slidesToShow > this.estates.length) {
                    // Reset if the last active slide is outside the new range
                    this.activeSlides = [0];
                }
            },

            next() {
                let maxStartIndex = Object.keys(this.estates).length - this.slidesToShow;
                let newStartIndex = this.activeSlides[0] + this.slidesToShow;
                if (newStartIndex > maxStartIndex) {
                    this.activeSlides = [0]; // Go back to the first slide
                } else {
                    this.activeSlides = [newStartIndex];
                }
            },

            prev() {
                let newStartIndex = this.activeSlides[0] - this.slidesToShow;
                this.activeSlides = [Math.max(newStartIndex, 0)];
            },
        };
    }
</script>
