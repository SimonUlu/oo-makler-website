<div class="relative pt-8 pb-20 mx-auto lg:px-2 lg:pt-12 lg:pb-28">
    <script src="https://unpkg.com/smoothscroll-polyfill@0.4.4/dist/smoothscroll.js"></script>
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
        }" x-init="() => window.addEventListener('resize')" class="flex flex-col w-full">

        <style>
            .show-1>li {
                min-width: 100%;
            }

            .show-2>li {
                min-width: calc(100% / 2);
            }

            .show-3>li {
                min-width: calc(100% / 3);
            }
        </style>
        <div x-on:keydown.right="next" x-on:keydown.left="prev" tabindex="0" role="region" aria-labelledby="carousel-label" class="flex max-w-xl mx-auto space-x-6 lg:min-w-[32rem]">
            <h2 id="carousel-label" class="sr-only" hidden>Carousel</h2>

            <!-- Prev Button -->
            <button x-on:click="prev" class="text-6xl lg:absolute lg:top-0 lg:right-0" style="right: 100px; top: -80px" :aria-disabled="atBeginning" :tabindex="atEnd ? -1 : 0" :class="{ 'opacity-50 cursor-not-allowed': atBeginning }">
                <span aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 bg-white rounded-full text-primary-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </span>
                <span class="sr-only">Skip to previous slide page</span>
            </button>


            <span id="carousel-content-label" class="sr-only" hidden>Carousel</span>

            <ul x-ref="slider" tabindex="0" role="listbox" aria-labelledby="carousel-content-label" class="flex w-full mx-6 overflow-hidden snap-x snap-mandatory">
                <!-- Section Single Estate -->
                {{estateReferences}}
                    {{partial:pages/estate/estate-slider-item-references-small}}
                {{/estateReferences}}
                <!-- Section Single Estate -->
            </ul>
            <!-- Next Button -->
            <button x-on:click="next" class="text-6xl lg:absolute lg:top-0 lg:right-0 lg:mr-4" :aria-disabled="atEnd" style="right: 50px; top: -80px" :tabindex="atEnd ? -1 : 0" :class="{ 'opacity-50 cursor-not-allowed': atEnd }">
                <span aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 bg-white rounded-full text-primary-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
                <span class="sr-only">Skip to next slide page</span>
            </button>
        </div>
    </div>
</div>
