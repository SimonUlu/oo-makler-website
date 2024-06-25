<div x-data="sliderRef()" class="relative mt-8">
    <div class="w-full grid grid-cols-3 lg:gap-6 lg:mt-6 lg:space-y-0 lg:space-x-2 space-y-10">
{{--        <template x-for="(estate, index) in estates" :key="estate.id_internal">--}}
        <template x-for="(estate, index) in estates">
            <li
                class="flex flex-col items-center justify-center w-full p-2 shrink-0 snap-start"
                role="option"
                x-show="activeSlides.includes(Number(index))"
            >
                <div class="relative w-full" data-carousel="static">
                    <!-- Carousel wrapper -->
                    <div class="relative w-auto overflow-hidden h-72 min-w-64">
                        <div>
                            <div class="absolute inset-0 transition-transform transform translate-x-0 z-20">
                                <img
                                    x-ref="img"
                                    class="object-cover w-full h-full"
                                    alt="estate.objekttitel"
                                    :src="estate.estate_images.length > 0 ? estate.estate_images[0].url : 'https://upload.wikimedia.org/wikipedia/commons/3/3f/Placeholder_view_vector.svg'"
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative px-5 pt-2 pb-2 border w-full md:pt-0 flex">
                    <div class="flex-2">
                        <h3 class="flex justify-between text-lg font-bold text-gray-900 mt-8">
                            <span class="capitalize mb-2 text-primary" x-text="getTranslation(estate.objektart)">
                            </span>
                        </h3>
                        <div class="space-y-2 text-md mb-4">
                            <div class="flex space-x-2 text-primary text-base" x-text="estate.plz + ' ' + estate.ort"></div>
                        </div>
                    </div>
                    <div class="flex-1 flex items-center justify-end">
                        <span class="bg-secondary text-white py-1 px-5 text-md">
                            verkauft
                        </span>
                    </div>
                </div>
            </li>
        </template>
    </div>
    <div class="flex justify-center space-x-2 mt-4">
        <template x-for="(page, pageIndex) in Array(Math.ceil(estates.length / slidesToShow)).fill()" :key="pageIndex">
            <button
                x-on:click="activeSlides = Array.from({ length: slidesToShow }, (_, i) => pageIndex * slidesToShow + i), logEstates()"
                :class="{'bg-primary': activeSlides[0] === pageIndex * slidesToShow, 'bg-white': activeSlides[0] !== pageIndex * slidesToShow}"
                class="w-4 h-4 rounded-full focus:outline-none border border-gray-500"
            ></button>
        </template>
    </div>
</div>

<script>
    function sliderRef() {
        return {
            estates: @json($estates),
            estateFields: @json($estateFields),
            activeSlides: [0, 1, 2], // Start with the first three slides as active
            slidesToShow: 3, // Number of slides to show


            init() {
            console.log(this.estates);
                this.updateSlidesToShow();
                window.addEventListener('resize', () => {
                    this.updateSlidesToShow();
                    this.adjustActiveSlides();
                });
            },

            getTranslation(objektart) {
                return this.estateFields.objektart.permittedvalues[objektart] || (objektart.charAt(0).toUpperCase() + objektart.slice(1));
            },

            updateSlidesToShow() {
                // Show 1 slide if the screen is smaller than 768px, otherwise show 3
                this.slidesToShow = window.innerWidth < 768 ? 1 : 3;
            },

            adjustActiveSlides() {
                // Ensure activeSlides is correctly set after updating slidesToShow
                if (this.activeSlides[0] + this.slidesToShow > this.estates.length) {
                    // Reset if the last active slide is outside the new range
                    this.activeSlides = Array.from({ length: this.slidesToShow }, (_, i) => i);
                }
            },

            next() {
                if (this.activeSlides[this.slidesToShow - 1] < this.estates.length - 1) {
                    this.activeSlides = this.activeSlides.map(slide => slide + this.slidesToShow);
                } else {
                    this.activeSlides = Array.from({ length: this.slidesToShow }, (_, i) => i);
                }
            },

            prev() {
                if (this.activeSlides[0] > 0) {
                    this.activeSlides = this.activeSlides.map(slide => slide - this.slidesToShow < 0 ? this.estates.length - (this.slidesToShow - slide) : slide - this.slidesToShow);
                }
            },

            logEstates() {
                console.log(this.estates);
            }
        }
    }
</script>
