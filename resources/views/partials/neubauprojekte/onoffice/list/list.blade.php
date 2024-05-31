<div class="w-full bg-white lg:pt-10 pb-6 lg:pb-12 max-w-7xl px-4 lg:px-10 mt-16">
    <div class="relative mx-auto">
        <h2 class="mb-20 lg:mb-4 text-3xl font-bold tracking-tight text-left text-gray-900 lg:text-5xl ">Unsere {{$art}}</h2>
    </div>
    <div class="relative pt-2 pb-20 mx-auto lg:px-2 lg:pt-4 lg:pb-28 rounded-lg">
        <div x-data="{
            skip: 1,
            slidesToShow: 3,
            atBeginning: false,
            atEnd: false,
            updateSlidesToShow() {
                var width = window.innerWidth
                if (width > 1350) {
                    this.slidesToShow = 3
                } else if (width > 900) {
                    this.slidesToShow = 2
                } else {
                    this.slidesToShow = 1
                }
                this.skip = this.slidesToShow

                // Add the CSS class according to slidesToShow
                this.$refs.slider.classList.remove('show-1', 'show-2', 'show-3')
                this.$refs.slider.classList.add(`show-${this.slidesToShow}`)
            },
            next() {
                this.updateSlidesToShow()
                this.to((current, offset) => current + (offset * this.skip))
            },
            prev() {
                this.updateSlidesToShow()
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
        }" x-init="updateSlidesToShow(); () => window.addEventListener('resize', updateSlidesToShow)" class="flex flex-col w-full rounded-lg">

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
            <div x-on:keydown.right="next" x-on:keydown.left="prev" tabindex="0" role="region" aria-labelledby="carousel-label" class="flex relative">
                <h2 id="carousel-label" class="sr-only" hidden="">Carousel</h2>

                <span id="carousel-content-label" class="sr-only" hidden="">Carousel</span>
                <!-- Prev Button -->
                <button x-on:click="prev" class="text-6xl p-2 rounded-full border absolute top-0 right-0 opacity-50 cursor-not-allowed hover:border-black" style="right: 70px; top: -80px" :aria-disabled="atBeginning" :tabindex="atEnd ? -1 : 0" :class="{ 'opacity-50 cursor-not-allowed': atBeginning }" tabindex="0" aria-disabled="true">
                    <span aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8  bg-white rounded-full text-primary-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </span>
                    <span class="sr-only">Skip to previous slide page</span>
                </button>

                <ul x-ref="slider" tabindex="0" role="listbox" aria-labelledby="carousel-content-label" class="flex w-full overflow-hidden snap-x snap-mandatory show-3">
                    <!-- Section Single Estate -->
                    @foreach($projekte as $projekt)
                        @include("partials.neubauprojekte.onoffice.item.item", ['projekt' => $projekt])
                    @endforeach
                    <!-- Section Single Estate -->

                </ul>
                <!-- Next Button -->
                <button x-on:click="next" class="text-6xl p-2 rounded-full border absolute top-0 right-0 lg:mr-4 hover:border-black" :aria-disabled="atEnd" style="right: 0px; top: -80px" :tabindex="atEnd ? -1 : 0" :class="{ 'opacity-50 cursor-not-allowed': atEnd }" tabindex="0">
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
