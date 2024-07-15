<div
    class="relative z-50"
    aria-labelledby="modal-title"
    x-show="openImgSlideShow"
    x-cloak
    x-data='{
        imgSrc: "",
        imgAlt: "",
        currentImgIndex: 0,
        estateImgs: @json($estateImgs),
        init() {
            if (this.estateImgs.length > 0) {
                this.imgSrc = this.estateImgs[0].url;
                this.imgAlt = this.estateImgs[0].title;
            }
        },
        showImg(index) {
            this.currentImgIndex = index;
            this.imgSrc = this.estateImgs[index].url;
            this.imgAlt = this.estateImgs[index].title;
        },
        prevImg() {
            if (this.currentImgIndex > 0) {
                this.showImg(this.currentImgIndex - 1);
            } else {
                this.showImg(this.estateImgs.length - 1);
            }
        },
        nextImg() {
            if (this.currentImgIndex < this.estateImgs.length - 1) {
                this.showImg(this.currentImgIndex + 1);
            } else {
                this.showImg(0);
            }
        },
        handleKeyDown(event) {
            switch(event.key) {
                case "ArrowLeft":
                    this.prevImg();
                    break;
                case "ArrowRight":
                    this.nextImg();
                    break;
                case "Escape":
                    if(modalOpen){
                        return;
                    }
                    openImgSlideShow=false;
                    break;
            }
        }
    }'
    x-on:keydown.window="handleKeyDown($event)"
    x-init="init">
    <!-- modalOpen added in the x-data, also openImgSlideShow -->
    <div class="fixed inset-0 transition-opacity bg-white"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex justify-center min-h-full text-center sm:p-0">
            <div @click.outside="openImgSlideShow = false"
                class="relative w-screen text-left transition-all transform bg-white rounded-lg">

                <div class="grid grid-cols-12">
                    <div class="col-span-12 pb-4">
                        <button @click="openImgSlideShow = false" type="button"
                            class="float-right mt-6 mr-6 text-gray-400 bg-white bg-opacity-75 rounded-md hover:text-gray-500 focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 focus:outline-none">
                            <span class="sr-only">Close</span>
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="col-span-12">
                        @if (count($estateImgs) > 0)
                            <style>
                                @media (min-width: 640px) {
                                    .image-grid-item {
                                        grid-template-columns: repeat(2, 1fr);
                                    }
                                }

                                @media (min-width: 1024px) {
                                    .image-grid-item {
                                        grid-template-columns: repeat(3, 1fr);
                                    }
                                }
                            </style>
                            <div x-on:keydown.escape.window.stop="modalOpen = false"
                                :class="{
                                    'overflow-hidden': modalOpen
                                }">
                                <div class="grid gap-4 px-4 overflow-y gap-y-4 image-grid-item">
                                    @foreach ($estateImgs as $estateImg)
                                        <div class="relative w-full h-64 overflow-hidden cursor-pointer"
                                            @click.prevent="modalOpen = true, imgSrc = '{{ $estateImg['url'] }}', imgAlt = '{{ $estateImg['title'] }}'">
                                            <img class="absolute top-0 left-0 object-cover w-full h-full rounded-lg"
                                                src="{{ $estateImg['url'] ?? asset('img/300x200.png')}}"
                                                alt="{{ $estateImg['title'] }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="relative w-full">
                                <!-- Carousel wrapper -->
                                <div class="relative w-auto overflow-hidden h-80 min-w-64">
                                    <div>
                                        <img src="https://via.placeholder.com/300x200"
                                            class="absolute inset-0 object-cover w-full h-full object-fit-cover">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-lg bg-white/50" x-show="modalOpen"
        @click.stop="modalOpen = false">
        <!-- Hinzufügen von Vorheriges Bild Schaltfläche -->
        <button class="absolute left-0 p-4 text-2xl text-gray-900 focus:outline-none" @click.stop="prevImg()">
            &#10094;
        </button>

        <!-- Schließen Schaltfläche verbleibt gleich -->
        <button class="absolute top-0 right-0 p-4 text-2xl text-gray-900 focus:outline-none"
            @click.stop="modalOpen = false">&times;</button>

        <div class="rounded-lg">
            <img class="w-full h-auto p-2 rounded-lg" :src="imgSrc" :alt="imgAlt">
        </div>

        <!-- Hinzufügen von Nächstes Bild Schaltfläche -->
        <button class="absolute right-0 p-4 text-2xl text-gray-900 focus:outline-none" @click.stop="nextImg()">
            &#10095;
        </button>
    </div>

</div>
