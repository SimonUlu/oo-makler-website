<div class="w-full bg-white pb-6 lg:pb-12 max-w-7xl px-4 lg:px-10">
    <div class="relative mx-auto text-center mb-8 lg:mb-16">
        <h2 class="mb-20 lg:mb-4 text-3xl font-bold tracking-tight text-primary lg:text-5xl ">Referenzobjekte</h2>

        <div class="text-gray-600 text-xl lg:text-base font-medium pb-8">
            Sie konzentrieren sich auf Ihr Geschäft, wir auf unseres. Dabei bewahren wir in der rasanten Entwicklung 
            der Hauptstadt den Überblick und punkten mit fundierter Marktkenntnis, Zielgruppenorientierung und 
            wirtschaftlichem Verständnis. <br> <br>

            Unsere Kompetenz in der Projektentwicklung und -vermarktung haben wir erfolgreich in vielen Bauprojekten in
            der Region unter Beweis gestellt.
        </div>
    </div>
    <div class="relative pt-2 pb-20 mx-auto lg:px-2 lg:pt-4 lg:pb-28 rounded-lg">
        <div x-data="{
            skip: 1,
            slidesToShow: 1,
            atBeginning: false,
            atEnd: false,
            next() {
                this.to((current, offset) => current + (offset * this.skip))
            },
            prev() {
                this.to((current, offset) => current - (offset * this.skip))
            },
            to(strategy) {
                let slider = this.$refs.slider
                let current = slider.scrollLeft
                let offset = slider.firstElementChild.getBoundingClientRect().width
                slider.scrollTo({ left: strategy(current, offset), behavior: 'smooth' })
            },
            focusableWhenVisible: {
                'x-intersect:enter'() {
                    this.$el.removeAttribute('tabindex')
                },
                'x-intersect:leave'() {
                    this.$el.setAttribute('tabindex', '-1')
                },
            },
            disableNextAndPreviousButtons: {
                'x-intersect:enter.threshold.05'() {
                    let slideEls = this.$el.parentElement.children

                    // If this is the first slide.
                    if (slideEls[0] === this.$el) {
                        this.atBeginning = true
                    // If this is the last slide.
                    } else if (slideEls[slideEls.length-1] === this.$el) {
                        this.atEnd = true
                    }
                },
                'x-intersect:leave.threshold.05'() {
                    let slideEls = this.$el.parentElement.children

                    // If this is the first slide.
                    if (slideEls[0] === this.$el) {
                        this.atBeginning = false
                    // If this is the last slide.
                    } else if (slideEls[slideEls.length-1] === this.$el) {
                        this.atEnd = false
                    }
                },
            },
        }" class="flex flex-col w-full rounded-lg">

            <style>
                .show-1>li {
                    min-width: 100%;
                }
            </style>
            <div x-on:keydown.right="next" x-on:keydown.left="prev" tabindex="0" role="region" aria-labelledby="carousel-label" class="flex relative">
                <h2 id="carousel-label" class="sr-only" hidden="">Carousel</h2>

                <span id="carousel-content-label" class="sr-only" hidden="">Carousel</span>
                <!-- Prev Button -->
                <button x-on:click="prev" class="text-6xl p-2 rounded-full absolute top-0 right-0 opacity-50 cursor-not-allowed" style="right: 70px; top: -80px" :aria-disabled="atBeginning" :tabindex="atEnd ? -1 : 0" :class="{ 'opacity-50 cursor-not-allowed': atBeginning }" tabindex="0" aria-disabled="true">
                    <span aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8  bg-white rounded-full text-primary-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </span>
                    <span class="sr-only">Skip to previous slide page</span>
                </button>

                <ul 
                    x-ref="slider" 
                    tabindex="0" 
                    role="listbox" 
                    aria-labelledby="carousel-content-label" 
                    class="flex w-full overflow-hidden snap-x snap-mandatory show-1"
                >
                    <!-- Section Single Estate -->
                    @foreach($projekte as $projekt)
                        @include("partials.neubauprojekte.cp.item", ['projekt' => $projekt])
                    @endforeach
                    <!-- Section Single Estate -->

                </ul>
                <!-- Next Button -->
                <button x-on:click="next" class="text-6xl p-2 absolute top-0 right-0 lg:mr-4" :aria-disabled="atEnd" style="right: 0px; top: -80px" :tabindex="atEnd ? -1 : 0" :class="{ 'opacity-50 cursor-not-allowed': atEnd }" tabindex="0">
                    <span aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 bg-white rounded-full text-primary-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                    <span class="sr-only">Skip to next slide page</span>
                </button>
            </div>

        </div>
    </div>

</div>
