<div class="py-4 md:py-8 max-w-7xl px-4 lg:px-10 mx-auto pt-16 lg:pt-32">
    @foreach($info[0]["content_with_image_replicator"] as $info)
        <div class="pt-2 lg:pt-4 grid grid-cols-1 gap-8 lg:gap-16 mb-12 lg:mb-24 lg:flex {{ $loop->iteration % 2 == 0 ? 'lg:flex-row-reverse' : '' }}">
            <div class="items-center justify-center flex lg:flex-1 relative">
                <div class="spinner" style="display: flex">
                    <svg
                        class="absolute inset-0 w-5 h-5 m-auto animate-spin"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 008 8V12A4 4 0 004 8"
                        ></path>
                    </svg>
                </div>
                <img
                    class="object-cover w-full  lazy"
                    data-src="{{$info["image"][0]["url"]}}"
                    alt="Projektbild"
                    loading="lazy"
                    onload="this.parentElement.querySelector('.spinner').style.display = 'none';"
                />
            </div>
            <div class="space-y-4 sm:space-y-6 lg:space-y-8 lg:flex-1">
                <div>
                    <h2
                    class="text-3xl font-extrabold leading-tight text-primary underline decoration-custom sm:text-4xl"
                    >
                        {{$info["header"]}}
                    </h2>

                </div>
                <div class="leading-8">
                    {{$info["description"]}}
                </div>
                @if(isset($info["list"]))
                <div
                    class="pb-4  sm:pb-6 lg:pb-8"
                >

                    <ul class="space-y-4">
                        @foreach($info["list"] as $listitem)
                        <li class="flex items-center gap-2.5">
                            <div
                                class="inline-flex items-center justify-center w-5 h-5  bg-primary-100 text-primary-600 shrink-0 dark:bg-primary-900 dark:text-primary-500"
                            >
                                <svg
                                    aria-hidden="true"
                                    class="w-6 h-6 text-secondary"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <span class="text-base font-bold text-gray-900">
                                {{$listitem["listitem"]}}
                            </span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif


                @if(isset($info["button_text"]))
                <div class="flex items-center justify-center md:justify-start gap-4">
                    <a
                        href="{{$info["button_link"]["url"]}}"
                        title=""
                        class="text-white bg-primary px-4 py-2 justify-center inline-flex items-center text-center0"
                        role="button"
                    >
                        {{$info["button_text"]}}
                        
                    </a>
                </div>
                @endif
            </div>
        </div>
    @endforeach


</div>


