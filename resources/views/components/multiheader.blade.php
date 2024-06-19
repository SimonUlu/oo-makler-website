@if(!empty($estate['elements']['images']) && count($estate['elements']['images']) > 3)
<div class="relative w-full h-full -mt-[60px]">

        <!-- Header Multi Images Image gallery -->
        <div class="px-2 pt-10 mx-auto sm:px-4 sm:pt-0 lg:grid lg:grid-cols-3 lg:gap-x-4 mt-[40px] md:mt-[80px]">
            <div class="hidden overflow-hidden rounded-lg lg:block aspect-w-3 aspect-h-4">
                <img @click="openImgSlideShow = !openImgSlideShow" id="first_picture"
                    src="{{ $estate['elements']['images'][0]['url'] ?? asset('img/300x200.png')}}"
                    alt="{{ $estate['elements']['images'][0]['title'] ?? '' }}"
                    class="object-cover object-center w-full h-full transition-transform duration-1000 cursor-pointer hover:scale-[1.015]">
            </div>
            <div class="hidden lg:grid lg:grid-cols-1 lg:gap-y-4">
                <div class="overflow-hidden rounded-lg aspect-w-3 aspect-h-2">
                    <img id="second_picture" @click="openImgSlideShow = !openImgSlideShow"
                        src="{{ $estate['elements']['images'][1]['url'] ?? asset('img/300x200.png')}}"
                        alt="{{ $estate['elements']['images'][1]['title'] ?? '' }}"
                        class="object-cover object-center w-full h-full transition-transform duration-1000 cursor-pointer hover:scale-[1.015]">
                </div>
                <div class="overflow-hidden rounded-lg aspect-w-3 aspect-h-2">
                    <img id="third_picture" @click="openImgSlideShow = !openImgSlideShow"
                        src="{{ $estate['elements']['images'][2]['url'] ?? asset('img/300x200.png')}}"
                        alt="{{ $estate['elements']['images'][2]['title'] ?? '' }}"
                        class="object-cover object-center w-full h-full transition-transform duration-1000 cursor-pointer hover:scale-[1.015]">
                </div>
            </div>
            <div class="overflow-hidden relative rounded-lg aspect-w-3 aspect-h-4">
                <img id="fourth_picture" @click="openImgSlideShow = !openImgSlideShow"
                    src="{{ $estate['elements']['images'][3]['url'] ?? asset('img/300x200.png')}}"
                    alt="{{ $estate['elements']['images'][3]['title'] ?? '' }}"
                    class="object-cover object-center w-full h-full transition-transform duration-1000 cursor-pointer hover:scale-[1.015]">
                <button @click="openImgSlideShow = !openImgSlideShow" data-open="Fotos" aria-label="Fotos"
                    class="absolute right-4 bottom-4 py-1 px-3 font-medium text-white bg-transparent rounded-xl border-2 border-white border-solid cursor-pointer hover:text-gray-900 no-aspect max-w-[150px] hover:bg-slate-50">
                    <svg class="inline-flex w-4 hover:text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h-.008v.008h.008V10.5z" />
                    </svg>
                    <span class="text-sm hover:text-gray-900"> Alle Bilder </span>
                </button>
                <button @click="shareOpen = !shareOpen" data-open="Fotos" aria-label="Fotos"
                    class="absolute bottom-4 right-36 py-1 px-3 font-medium text-white bg-transparent rounded-xl border-2 border-white border-solid cursor-pointer hover:text-gray-900 no-aspect max-w-[150px] hover:bg-slate-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="inline-flex w-4 hover:text-gray-900">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                    </svg>
                    <span class="text-sm hover:text-gray-900"> Teilen</span>
                </button>
            </div>
        </div>
</div>
@else
    <div class="w-full max-h-screen bg-white">
        <div class="relative px-2 pt-10 mx-auto sm:px-6 max-h-[480px] lg:max-h-[600px] overflow-hidden">
            <div class="relative inset-0 rounded-lg max-h-screen">
                <div class="absolute inset-0 bg-black bg-opacity-20 rounded-lg"></div>
                <img
                    class='max-h-screen rounded-lg object-cover w-full hover:scale-[1.005] transition-transform duration-1000'
                    src="{{ $titelbild ?? asset('img/300x200.png')}}"
                    alt="Hero Bild der Immobilie"
                >
                <button @click="openImgSlideShow = !openImgSlideShow" data-open="Fotos" aria-label="Fotos"
                    class="absolute right-8 bottom-40 py-1 px-3 font-medium text-white bg-transparent rounded-xl border-2 border-white border-solid cursor-pointer hover:text-gray-900 no-aspect max-w-[150px] hover:bg-slate-50">
                    <svg class="inline-flex w-4 hover:text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h-.008v.008h.008V10.5z" />
                    </svg>
                    <span class="text-sm hover:text-gray-900"> Alle Bilder </span>
                </button>
                <button @click="shareOpen = !shareOpen" data-open="Fotos" aria-label="Fotos"
                    class="absolute bottom-40 right-40 py-1 px-3 font-medium text-white bg-transparent rounded-xl border-2 border-white border-solid cursor-pointer hover:text-gray-900 no-aspect max-w-[150px] hover:bg-slate-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="inline-flex w-4 hover:text-gray-900">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                    </svg>
                    <span class="text-sm hover:text-gray-900"> Teilen</span>
                </button>
            </div>
        </div>
    </div>
@endif
<!-- Add script to handle the slideshow state -->
@if(!empty($estate['elements']['images']))
    <x-estates.image-slideshow :estateImgs="$estate['elements']['images']" />
@endif
