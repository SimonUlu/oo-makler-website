<div x-data="slider()" class="grid mt-8">
    <div :class="`w-full grid ${slidesToShow === 1 ? 'grid-cols-1' : 'grid-cols-3'} lg:gap-6 lg:mt-6 lg:space-y-0 lg:space-x-2 space-y-10 items-center justify-center`">
        <button @click="prev()" type="button" class="absolute left-[-20px] z-15 flex items-center justify-center h-full px-4 cursor-pointer focus:outline-none group">
            <span class="inline-flex items-center justify-center w-12 h-12 sm:w-10 sm:h-10 group-focus:ring-4 group-focus:ring-white group-focus:outline-none bg-white/30 dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70 group-hover:bg-white/50 rounded-full">
                <svg aria-hidden="true" class="w-12 h-12 sm:w-10 sm:h-10 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <template x-for="(estate, index) in estates" :key="estate.id_internal">
            <li
                class="flex flex-col items-center justify-center w-full p-2 shrink-0 snap-start"
                role="option"
                x-show="index >= activeSlides[0] && index < activeSlides[0] + slidesToShow"
                x-data="{
                    activeSlide: 0,
                    init() {
                        this.$nextTick(() => {
                            this.initCarousel();
                        });
                    },
                    initCarousel() {
                        this.$el.querySelectorAll('[data-carousel-slide-to]').forEach(button => {
                            button.addEventListener('click', (event) => {
                                const slideIndex = event.target.getAttribute('data-carousel-slide-to');
                                this.selectedSlide(parseInt(slideIndex));
                            });
                        });
                    },
                    selectedSlide(slideIndex) {
                        this.activeSlide = slideIndex;
                    },
                    prevSlide() {
                        if (this.activeSlide > 0) {
                            this.activeSlide--;
                        } else {
                            this.activeSlide = 5 - 1;
                        }
                    },
                    nextSlide() {
                        if (this.activeSlide < 5) {
                            this.activeSlide++;
                        } else {
                            this.activeSlide = 0;
                        }
                    }
                }"
            >
                <!-- Begin New Template -->
                <div class="grid w-full max-w-lg grid-cols-1 mx-auto md:flex-col md:mb-0 md:space-x-0 md:max-w-none">
                    <template x-if="estate.estate_images.length > 0">
                        <div id="indicators-carousel-estate-columns" class="relative w-full" data-carousel="static">
                            <!-- Carousel wrapper -->
                            <div class="relative w-auto overflow-hidden h-72 min-w-64">
                                <!-- Item 1 -->
                                <template x-for="(image, imgIndex) in estate.estate_images.slice(0, 5)" :key="imgIndex">
                                    <div x-data="{ loading: true }" class="hidden" :class="{'block': activeSlide === imgIndex}" data-carousel-item="imgIndex === 0 ? 'active' : ''">
                                        <img x-ref="img" class="z-10 absolute inset-0 object-cover w-full h-full lazy object-fit-cover" loading="lazy" :data-src="image.url + '@600x400'" alt="estate.objekttitel" />
                                    </div>
                                </template>
                            </div>

                            <!-- Slider indicators -->
                            <div class="absolute z-20 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
                                <template x-for="(image, imgIndex) in estate.estate_images.slice(0, 5)" :key="imgIndex">
                                    <button
                                        type="button"
                                        class="w-3 h-3 rounded-full"
                                        :class="{'bg-white': activeSlide === imgIndex, 'bg-white/50': activeSlide !== imgIndex }"
                                        aria-current="true"
                                        :aria-label="'Slide ' + (imgIndex + 1)"
                                        :data-carousel-slide-to="imgIndex"
                                    ></button>
                                </template>
                            </div>
                            <!-- Slider controls -->
                            <button @click="prevSlide()" type="button" class="absolute top-0 left-0 z-20 flex items-center justify-center h-full px-4 cursor-pointer focus:outline-none group" data-carousel-prev>
                                <span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 group-focus:ring-4 group-focus:ring-white group-focus:outline-none bg-white/30 dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70 group-hover:bg-white/50 rounded-full">
                                    <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    <span class="sr-only">Previous</span>
                                </span>
                            </button>
                            <button @click="nextSlide()" type="button" class="absolute top-0 right-0 z-20 flex items-center justify-center h-full px-4 cursor-pointer focus:outline-none group" data-carousel-next>
                                <span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 group-focus:ring-4 group-focus:ring-white group-focus:outline-none bg-white/30 dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70 group-hover:bg-white/50 rounded-full">
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
                                        <span>
                                            <span x-text="estate.warmmiete > 0 ? `${estate.warmmiete.toLocaleString()} €` : 'Preis auf Anfrage'"></span>
                                            <template x-if="estate.warmmiete > 0">
                                                <div class="font-normal text-sm">zzgl. Provision</div>
                                            </template>
                                        </span>
                                                                    </template>
                                                                    <template x-if="estate.vermarktungsart !== 'miete'">
                                        <span>
                                            <span x-text="estate.kaufpreis > 0 ? `${estate.kaufpreis.toLocaleString()} €` : 'Preis auf Anfrage'"></span>
                                            <template x-if="estate.kaufpreis > 0">
                                                <div class="font-normal text-sm">zzgl. Provision</div>
                                            </template>
                                        </span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!-- End Image Slider -->

                    <!-- Neue Section -->
                    <div class="relative px-5 pt-2 pb-2 border md:pt-0">
                        <template x-if="estate.ort">
                            <div class="absolute top-0 left-0 bg-primary text-white p-1 text-sm">
                                <strong x-text="estate.plz"></strong> <span x-text="estate.ort"></span>
                            </div>
                        </template>
                        <h3 class="flex justify-between text-lg font-bold text-gray-900 mt-8">
                            <span class="capitalize mb-2 text-primary" x-text="getTranslation(estate.objektart)"></span>
                            <template x-if="estate.vermarktungsart === 'miete'">
                                <div class="inline-flex items-center bg-white px-2.5 py-0.5 text-sm font-bold text-primary">
                                    <template x-if="estate.warmmiete > 0">
                                        <div>
                                            <span x-text="`${estate.warmmiete.toLocaleString()} €`"></span>
                                            <p class="font-normal text-sm">zzgl. Provision</p>
                                        </div>
                                    </template>
                                    <template x-if="estate.warmmiete <= 0">
                                        <span>Preis auf Anfrage</span>
                                    </template>
                                </div>
                            </template>
                            <template x-if="estate.vermarktungsart !== 'miete'">
                                <div class="items-center text-primary px-2.5 py-0.5 text-base font-bold">
                                    <template x-if="estate.kaufpreis > 0">
                                        <div>
                                            <span x-text="`${estate.kaufpreis.toLocaleString()} €`"></span>
                                            <br>
                                            <p class="font-normal text-sm">zzgl. Provision</p>
                                        </div>
                                    </template>
                                    <template x-if="estate.kaufpreis <= 0">
                                        <span>Preis auf Anfrage</span>
                                    </template>
                                </div>
                            </template>
                        </h3>
                        <div class="space-y-2 text-md mb-4">
                            <div class="flex text-primary text-sm">
                                <template x-if="estate.wohnflaeche">
                                    <span><strong x-text="Math.round(estate.wohnflaeche)"></strong> m&sup2; Wohnflaeche</span>
                                </template>
                                <template x-if="estate.anzahl_zimmer">
                                    <span class="mx-2"> · <strong x-text="Math.round(estate.anzahl_zimmer)"></strong> Zimmer</span>
                                </template>
                            </div>
                        </div>
                        <div class="my-2 border-t border-gray-300"></div>
                        <div class="flex flex-col items-center justify-center" x-data="{ logoUrl: estate.logoUrl }">
                            <div class="flex items-center justify-between w-full"> <!-- Add 'items-center' class here -->
                                <img loading="lazy" class="max-w-[40px]" src="/logo_images/badge-blue.png" alt="Ihr Kontakt">
                                <a :href="`/immobilien/details/${estate.id_internal}`" class="inline-flex justify-center bg-secondary items-center py-2.5 px-5 text-md font-medium text-center md:w-auto lg:col-span-12 focus:ring-4 focus:outline-none text-white" target="_blank">Ansehen</a>
                            </div>
                        </div>
                    </div>
                    <!-- Ende Neue Section -->
                </div>
                <!-- End New Template -->
            </li>
        </template>
        <button @click="next()" type="button" class="absolute right-[-30px] z-20 flex items-center justify-center h-full px-4 cursor-pointer focus:outline-none group">
            <span class="inline-flex items-center justify-center w-12 h-12 sm:w-10 sm:h-10 group-focus:ring-4 group-focus:ring-white group-focus:outline-none bg-white/30 dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70 group-hover:bg-white/50 rounded-full">
                <svg aria-hidden="true" class="w-12 h-12 sm:w-10 sm:h-10 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>
</div>

<script>
    function slider() {
        return {
            estates: @json($estates),
            activeSlides: [0],
            slidesToShow: 5,
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
            }
        };
    }
</script>
