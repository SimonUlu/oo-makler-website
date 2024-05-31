<div class="bg-white">
    <div class="mx-auto max-w-2xl px-4 py-24 sm:px-6 sm:py-32 lg:max-w-7xl lg:px-8">
      {{-- <div class="mx-auto max-w-3xl text-center">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Protect your device</h2>
        <p class="mt-4 text-gray-500">As a digital creative, your laptop or tablet is at the center of your work. Keep your device safe with a fabric sleeve that matches in quality and looks.</p>
      </div> --}}

        <div class="mt-16 space-y-16">
            @foreach($panoramaImages as $index => $panoramaImage)
            @if($index % 2 != 0)
                <div class="flex flex-col-reverse lg:grid lg:grid-cols-12 lg:items-center lg:gap-x-8">
                    <div class="mt-6 lg:col-span-5 lg:row-start-1 lg:mt-0 xl:col-span-4 lg:col-start-1">
                        <h3 class="text-lg font-medium text-gray-900">{{$panoramaImage["title"]}}</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            {{$panoramaImage["text"]}}
                        </p>
                    </div>
                    <div class="flex-auto lg:col-span-7 lg:row-start-1 xl:col-span-8 lg:col-start-6 xl:col-start-5">
                        <div class="aspect-h-2 aspect-w-5 overflow-hidden rounded-lg bg-gray-100 relative">
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
                                data-src="{{$panoramaImage["url"]}}"
                                alt="White canvas laptop sleeve with gray felt interior, silver zipper, and tan leather zipper pull."
                                class="object-cover object-center lazy"
                                loading="lazy"
                                onload="this.parentElement.querySelector('.spinner').style.display = 'none';"
                            >
                        </div>
                    </div>
                </div>
            @else
                <div class="flex flex-col-reverse lg:grid lg:grid-cols-12 lg:items-center lg:gap-x-8">
                    <div class="mt-6 lg:col-span-5 lg:row-start-1 lg:mt-0 xl:col-span-4 lg:col-start-8 xl:col-start-9">
                        <h3 class="text-lg font-medium text-gray-900">{{$panoramaImage["title"]}}</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            {{$panoramaImage["text"]}}
                        </p>
                    </div>
                    <div class="flex-auto lg:col-span-7 lg:row-start-1 xl:col-span-8 lg:col-start-1">
                        <div class="aspect-h-2 aspect-w-5 overflow-hidden rounded-lg bg-gray-100">
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
                                data-src="{{$panoramaImage["url"]}}"
                                alt="White canvas laptop sleeve with gray felt interior, silver zipper, and tan leather zipper pull."
                                class="object-cover object-center lazy"
                                loading="lazy"
                                onload="this.parentElement.querySelector('.spinner').style.display = 'none';"
                            >
                        </div>
                    </div>
                  </div>
            @endif
            @endforeach
        </div>
    </div>
  </div>
