
<div x-data="slider()" class="relative mt-8">
    <div class="w-full grid grid-cols-3 lg:gap-6 lg:mt-6 lg:space-y-0 lg:space-x-2 space-y-10">
        
        <template x-for="(estate, index) in estates" :key="estate.id">
            <li 
                class="flex flex-col items-center justify-center w-full p-2 shrink-0 snap-start" 
                role="option" 
                x-show="activeSlides.includes(Number(index))"
            >
                <div
                    x-data="{ hover: false }"
                    @mouseover="hover = true"
                    @mouseout="hover = false"
                    class="bg-cover bg-no-repeat bg-center w-full h-[28rem] relative cursor-pointer"
                    :style="'background-image: url(' + estate.elements.images[0].url + ')'"
                >
                    <a target="_blank">
                        <div
                            :class="{ 'h-1/3': !hover, 'h-3/4': hover }"
                            class="transition-all w-full bg-primary-800 flex flex-col justify-end p-4 absolute bottom-0 overflow-hidden"
                            :style="{'background-color': hover ? 'rgba(0,103,177, 0.8)' : 'rgba(0,103,177, 0.6)'}"
                        >
                            <div
                                :class="{ 'translate-y-0': !hover, '-translate-y-1/4': hover }"
                                class="transition-transform"
                            >
                                <img
                                    x-show="hover"
                                    src="/logo_images/logo_white.png"
                                    class="h-12 mr-3 pb-4"
                                    alt="Test"
                                />
                                <h3 class="text-white font-bold text-xl" x-text="estate.elements.objekttitel"></h3>
                                <p class="text-white text-md" x-text="estate.elements.plz + ' ' + estate.elements.plz"></p>
                                <p x-show="hover" class="text-white text-sm pt-2" x-text="estate.elements.objektbeschreibung.substring(0, 150)"></p>
                            </div>
                        </div>
                    </a>
                </div>
            </li>
        </template>
    </div>
    <div class="flex justify-center space-x-2 mt-4">
        <template x-for="(page, pageIndex) in Array(Math.ceil(Object.keys(estates).length / 3)).fill()" :key="pageIndex">
            <button 
                x-on:click="activeSlides = [pageIndex * 3, pageIndex * 3 + 1, pageIndex * 3 + 2]" 
                :class="{'bg-primary': activeSlides[0] === pageIndex * 3, 'bg-white': activeSlides[0] !== pageIndex * 3}" 
                class="w-4 h-4 rounded-full focus:outline-none"
            ></button>
        </template>
    </div>

    
</div>

<script>
function slider() {
    return {
        estates: @json($estates),
        activeSlides: [0, 1, 2], // Start mit den ersten drei Slides als aktiv        
        next() {
            console.log(this.estates)
            if (this.activeSlides[2] < Object.keys(this.estates).length) {
                this.activeSlides = this.activeSlides.map(slide => 
                    (slide + 3)
                );
            }
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