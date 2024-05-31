<li>
    <div class="group relative flex flex-col overflow-hidden border border-gray-200 bg-white rounded-lg">
        <div
            id="indicators-carousel-estate-columns"
            class="relative w-full h-full"
            data-carousel="static"
        >
            <!-- Carousel wrapper -->
            <div class="relative w-auto overflow-hidden h-80 min-w-64">
                <!-- Item 1 -->
                @foreach(collect($projekt['elements']['images'])->take(3) as $index => $image)
                <div
                    class="hidden"
                    data-carousel-item="{{$index == 0 ? 'active' :''}}"
                >
                    <img
                        src="{{ $image['url'] }}"
                        class="absolute inset-0 object-cover w-full h-full object-fit-cover"
                        alt="{{ $projekt['elements']['objekttitel'] }}"
                    />
                </div>
                @endforeach
            </div>

            <!-- Slider indicators -->
            <div
                class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2"
            >
                @foreach(collect($projekt['elements']['images'])->take(3) as $index => $image)
                <button
                    type="button"
                    class="w-3 h-3 rounded-full"
                    aria-current="true"
                    aria-label="Slide {{$index}}"
                    data-carousel-slide-to="{{$index = $index -1}}"
                ></button>
                @endforeach
            </div>
            <!-- Slider controls -->
            <button
                type="button"
                class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer focus:outline-none group"
                data-carousel-prev
            >
                <span
                    class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 group-focus:ring-4 group-focus:ring-white group-focus:outline-none bg-white/30 /30 dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70 group-hover:bg-white/50"
                >
                    <svg
                        aria-hidden="true"
                        class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7"
                        ></path>
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button
                type="button"
                class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer focus:outline-none group"
                data-carousel-next
            >
                <span
                    class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 group-focus:ring-4 group-focus:ring-white group-focus:outline-none bg-white/30 /30 dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70 group-hover:bg-white/50"
                >
                    <svg
                        aria-hidden="true"
                        class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5l7 7-7 7"
                        ></path>
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
        <div class="flex min-h-[210px] py-6 px-6">
            <div class="flex flex-1 flex-col space-y-2">
                <h3 class="text-3xl font-medium text-gray-900">
                    <a href="#">
                    <span aria-hidden="true" class="absolute inset-0"></span>
                    {{$projekt['elements']['objekttitel']}}
                    </a>
                </h3>
                <div class="flex flex-1 flex-col justify-end">
                    <p class="text-base italic text-gray-500">
                        {{ \Illuminate\Support\Str::limit($projekt['elements']['objektbeschreibung'], 400, $end='...') }}
                    </p>
                </div>
            </div>
            <div>
                <div class="mb-4 md:px-8">
                    <img
                        class="max-w-[100px] py-4"
                        src="/logo_images/logo.png"
                        alt="Ihr Kontakt"
                    />
                </div>
            </div>
        </div>

    </div>
</li>
