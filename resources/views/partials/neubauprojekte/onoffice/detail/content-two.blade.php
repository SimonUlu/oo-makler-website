<div class="bg-white">
    <div class="mx-auto max-w-7xl py-24 sm:px-2 sm:py-32 lg:px-4">
        <div class="mx-auto max-w-2xl px-4 lg:max-w-none">
            <div class="max-w-3xl">
                <h2 class="font-semibold text-gray-500">Ausstattung</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{$title}}</p>
                <p class="mt-4 text-gray-500">
                    {{$ausstattung}}
                </p>
                </div>

            <div class="mt-10 space-y-16 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16">
                @foreach($images as $image)
                <div class="flex flex-col-reverse lg:grid lg:grid-cols-12 lg:items-center lg:gap-x-8">
                    <div class="mt-6 lg:col-span-5 lg:mt-0 xl:col-span-4">
                    <h3 class="text-lg font-medium text-gray-900">{{$image["title"]}}</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        {{$image["text"]}}
                    </p>
                    </div>
                    <div class="flex-auto lg:col-span-7 xl:col-span-8">
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
                            data-src="{{$image["url"]}}"
                            alt="Printed photo of bag being tossed into the sky on top of grass."
                            class="object-cover object-center lazy"
                            loading="lazy"
                            onload="this.parentElement.querySelector('.spinner').style.display = 'none';"
                        >
                    </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
  </div>
