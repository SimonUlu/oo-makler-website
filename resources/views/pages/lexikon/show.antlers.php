<section class="w-full pb-16 bg-white lg:pb-24">
    <header
        class="w-full h-[460px] xl:h-[737px] bg-no-repeat bg-cover bg-center bg-blend-darken relative"
    >
        <div
            class="absolute top-0 left-0 w-full h-full custom-gradient"
        ></div>
        <div
            class="absolute w-full max-w-screen-xl px-4 mx-auto -translate-x-1/2 pt-28 sm:pt-24 top-20 left-1/2 xl:top-1/2 xl:-translate-y-1/2 xl:px-0"
        >
            <span class="block mt-6 mb-4 text-gray-300 xl:mt-0"
                >Publiziert in
                <a href="#" class="font-semibold text-white hover:underline"
                    >{{category}}</a
                ></span
            >
            <h1
                class="max-w-4xl mb-4 text-2xl font-extrabold leading-none text-white sm:text-3xl lg:text-4xl"
            >
                {{title}}
            </h1>
            <p class="text-lg font-normal text-gray-300">{{subtitle}}</p>
        </div>
    </header>

    <div
        class="relative z-20 flex justify-between max-w-screen-xl p-6 mx-4 bg-white rounded -m-36 xl:-m-32 xl:p-9 xl:mx-auto mb-36 xl:mb-32"
    >
        <article
            class="xl:w-[828px] w-full max-w-none format format-sm sm:format-base lg:format-lg format-blue dark:format-invert"
        >
            <div
                class="flex flex-col justify-between lg:flex-row lg:items-center"
            >
                <aside aria-label="Share social media">
                    <div class="not-format">
                        <button
                            data-tooltip-target="tooltip-facebook"
                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                            type="button"
                        >
                            <svg
                                class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                aria-hidden="true"
                                viewBox="0 0 18 18"
                                fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <g clip-path="url(#clip0_13676_82298)">
                                    <path
                                        d="M18 9C18 4.02943 13.9706 0 9 0C4.02943 0 0 4.02943 0 9C0 13.4921 3.29115 17.2155 7.59375 17.8907V11.6016H5.30859V9H7.59375V7.01719C7.59375 4.76156 8.93742 3.51562 10.9932 3.51562C11.9776 3.51562 13.0078 3.69141 13.0078 3.69141V5.90625H11.873C10.755 5.90625 10.4062 6.60006 10.4062 7.3125V9H12.9023L12.5033 11.6016H10.4062V17.8907C14.7088 17.2155 18 13.4921 18 9Z"
                                    />
                                </g>
                                <defs>
                                    <clipPath id="clip0_13676_82298">
                                        <rect
                                            width="18"
                                            height="18"
                                            fill="white"
                                        />
                                    </clipPath>
                                </defs>
                            </svg>
                        </button>
                        <div
                            id="tooltip-facebook"
                            role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
                        >
                            Teilen auf Facebook
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>

                        <button
                            data-tooltip-target="tooltip-twitter"
                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                            type="button"
                        >
                            <svg
                                class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                aria-hidden="true"
                                viewBox="0 0 18 18"
                                fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M5.66064 16.3131C12.4531 16.3131 16.1683 10.6856 16.1683 5.80539C16.1683 5.64555 16.1683 5.48643 16.1575 5.32803C16.8803 4.80525 17.5042 4.15794 18 3.41643C17.326 3.71523 16.611 3.9111 15.8789 3.99747C16.6499 3.53599 17.2269 2.81006 17.5025 1.95483C16.7776 2.38504 15.9845 2.6882 15.1574 2.85123C14.6006 2.25916 13.8642 1.86711 13.0621 1.73574C12.2601 1.60438 11.4371 1.74102 10.7205 2.12452C10.0039 2.50802 9.43367 3.11701 9.09806 3.85724C8.76245 4.59747 8.68016 5.42768 8.86392 6.21939C7.39567 6.14574 5.95932 5.76416 4.64809 5.09943C3.33686 4.4347 2.18007 3.50168 1.2528 2.36091C0.780546 3.17391 0.635904 4.13633 0.848325 5.05223C1.06075 5.96812 1.61426 6.76863 2.39616 7.29075C1.80842 7.27353 1.23349 7.11498 0.72 6.82851V6.87531C0.720233 7.72795 1.01539 8.55426 1.5554 9.21409C2.09542 9.87391 2.84705 10.3266 3.6828 10.4955C3.13911 10.6438 2.56866 10.6654 2.01528 10.5588C2.25136 11.2926 2.71082 11.9342 3.32943 12.394C3.94804 12.8539 4.69487 13.1089 5.46552 13.1235C4.69983 13.7253 3.82299 14.1703 2.88516 14.433C1.94733 14.6956 0.966911 14.7708 0 14.6542C1.68887 15.738 3.65394 16.3128 5.66064 16.3102"
                                />
                            </svg>
                        </button>
                        <div
                            id="tooltip-twitter"
                            role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
                        >
                            Teilen auf Twitter
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>

                        <!-- instagram -->
                        <button
                            data-tooltip-target="tooltip-instagram"
                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                            type="button"
                        >
                            <svg
                                class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                aria-hidden="true"
                                viewBox="0 0 18 18"
                                fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M9 0C4.02944 0 0 4.02944 0 9C0 13.9706 4.02944 18 9 18C13.9706 18 18 13.9706 18 9C18 4.02944 13.9706 0 9 0ZM9 16.5C5.35786 16.5 2.5 13.6421 2.5 10C2.5 6.35786 5.35786 3.5 9 3.5C12.6421 3.5 15.5 6.35786 15.5 10C15.5 13.6421 12.6421 16.5 9 16.5Z"
                                />
                                <path
                                    d="M9 5.25C6.51472 5.25 4.5 7.26472 4.5 9.75C4.5 12.2353 6.51472 14.25 9 14.25C11.4853 14.25 13.5 12.2353 13.5 9.75C13.5 7.26472 11.4853 5.25 9 5.25ZM9 12.75C7.61929 12.75 6.5 11.6307 6.5 10.25C6.5 8.86929 7.61929 7.75 9 7.75C10.3807 7.75 11.5 8.86929 11.5 10.25C11.5 11.6307 10.3807 12.75 9 12.75Z"
                                />
                                <path
                                    d="M13.5 4.5C13.5 5.32843 12.8284 6 12 6C11.1716 6 10.5 5.32843 10.5 4.5C10.5 3.67157 11.1716 3 12 3C12.8284 3 13.5 3.67157 13.5 4.5Z"
                                />
                            </svg>
                        </button>
                        <div
                            id="tooltip-instagram"
                            role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
                        >
                            Teilen auf Instagram
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>

                        <button
                            data-tooltip-target="tooltip-link"
                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                            type="button"
                        >
                            <svg
                                class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"
                                ></path>
                            </svg>
                        </button>
                        <div
                            id="tooltip-link"
                            role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
                        >
                            Share link
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>
                </aside>
            </div>
            <div class="mt-8">
                <p class="text-xl font-bold lead">{{text}}</p>
            </div>
        </article>
    </div>
</section>