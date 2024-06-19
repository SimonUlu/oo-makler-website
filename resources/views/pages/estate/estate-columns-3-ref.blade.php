
<div x-data="sliderRef()" class="relative mt-8">
    <div class="w-full grid grid-cols-3 lg:gap-6 lg:mt-6 lg:space-y-0 lg:space-x-2 space-y-10">

        <template x-for="(estate, index) in estates" :key="estate.elements.id">

            <li
                class="flex flex-col items-center justify-center w-full p-2 shrink-0 snap-start"
                role="option"
                x-show="activeSlides.includes(Number(index))"
            >
                <div  class="relative w-full" data-carousel="static">
                    <!-- Carousel wrapper -->
                    <div class="relative w-auto overflow-hidden  h-72 min-w-64">
                        <div>
                            <div class="absolute inset-0 transition-transform transform translate-x-0 z-20">
                                <img
                                    x-ref="img"
                                    class="object-cover w-full h-full"
                                    alt="1a LAGE und Renditeobjekt!!!!!"
                                    :src="estate.elements.images[0].url"
                                >
                            </div>
                        </div>


                    </div>
                </div>
                <div class="relative px-5 pt-2 pb-2 border w-full  md:pt-0 flex">
                    <div class="flex-2">
                        <h3 class="flex justify-between text-lg font-bold text-gray-900 mt-8">
                            <span class="capitalize mb-2 text-primary" x-text="estate.elements.objektart">
                            </span>
                        </h3>
                        <div class="space-y-2 text-md mb-4">
                            <div class="flex space-x-2 text-primary text-base" x-text="estate.elements.plz + ' ' +estate.elements.ort"></div>
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
        <template x-for="(page, pageIndex) in Array(Math.ceil(Object.keys(estates).length / 3)).fill()" :key="pageIndex">
            <button
                x-on:click="activeSlides = [pageIndex * 3, pageIndex * 3 + 1, pageIndex * 3 + 2], logEstates()"
                :class="{'bg-primary': activeSlides[0] === pageIndex * 3, 'bg-white': activeSlides[0] !== pageIndex * 3}"
                class="w-4 h-4 rounded-full focus:outline-none border border-gray-500"
            ></button>
        </template>
    </div>


</div>

<script>
function sliderRef() {
    return {
        estates: @json($estateReferences),
        activeSlides: [0, 1, 2], // Start mit den ersten drei Slides als aktiv
        next() {
            console.log(this.estates)
            if (this.activeSlides[2] < Object.keys(this.estates).length) {
                this.activeSlides = this.activeSlides.map(slide =>
                    (slide + 3)
                );
            }
        },
        logEstates() {
            console.log(this.estates);
        },
        prev() {

            if (this.activeSlides[0] > 0) {
                this.activeSlides = this.activeSlides.map(slide =>
                    slide - 3 < 0 ? this.estates.length - (3 - slide) : slide - 3
                );
            }

        },
    }
}
</script>
