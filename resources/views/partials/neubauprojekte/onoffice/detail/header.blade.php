<section class="w-full bg-white">
    <header
        class="w-full h-[460px] xl:h-[737px] bg-no-repeat bg-cover bg-center bg-blend-darken relative"
    >
        <div
            class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-50"
        ></div>
        <div
            class="absolute w-full max-w-screen-xl px-4 mx-auto -translate-x-1/2 pt-28 sm:pt-24 top-20 left-1/2 xl:top-1/2 xl:-translate-y-1/2 lg:px-10"
        >
            <h1
                class="max-w-4xl mb-4 text-2xl font-extrabold leading-none text-white sm:text-3xl lg:text-4xl"
            >
                Lorem Ipsum
            </h1>
            <div class="max-w-2xl text-base font-normal text-white opacity-60">
                Lorem Ipsum dolor sit amet.
            </div>
        </div>
        @foreach($titleImages as $titleImage)
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
            id="backgroundImage"
            class="object-cover object-bottom w-full h-full lazy"
            data-src="{{$titleImage["url"]}}"
            alt="test"
            loading="lazy"
        />
        @endforeach
    </header>
</section>
