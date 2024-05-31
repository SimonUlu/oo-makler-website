<div class="relative grid grid-cols-1 mx-auto overflow-hidden lg:grid-cols-2 isolate">
    <img src="{{header_day.0.url}}" alt="{{header_day.0.alt}}" class="absolute inset-0 object-cover w-full h-full -z-10" />
    <div class="px-4 max-w-2xl py-8 mx-auto space-y-6 sm:py-24 lg:py-24 mt-[80px] sm:mt-0">
        <div class="w-full max-w-lg mx-auto h-fit">
            <div class="p-4 mb-6 text-center bg-white shadow-xl bg-opacity-70 lg:mb-0 rounded-3xl backdrop-blur-lg bg-white/50 sm:p-4">
                <h1 class="mb-4 text-xl font-bold leading-tight tracking-tight text-black md:text-2xl lg:text-3xl">{{title}}</h1>
                <p class="mb-6 font-light text-black md:text-lg lg:mb-8 lg:text-xl">{{subtitle}}</p>
                {{partial:subpartials-header/front-page-search-buttons}}
            </div>
        </div>
        <div class="w-full max-w-lg mx-auto h-fit">
            <div class="p-4 mb-6 text-center bg-white shadow-xl bg-opacity-70 lg:mb-0 rounded-3xl backdrop-blur-lg bg-white/50 sm:p-4">
                <h2 class="mb-4 text-xl font-bold leading-tight tracking-tight text-black md:text-2xl lg:text-3xl">Nachhaltig investieren</h2>
                <p class="mb-6 font-light text-black md:text-lg lg:mb-8 lg:text-xl">Vermögensaufbau. Passives Einkommen. Zukunftssicher.</p>
                <div class="mx-5">
                    <a href="/projekte" class="inline-flex items-center justify-center w-full px-12 py-3 mx-2 font-medium font-bold text-center text-white rounded-lg lg:px-5 focus:ring-4 focus:outline-none bg-primary-700 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 hover:bg-primary-800 focus:ring-primary-900">
                        Anlageobjekte
                    </a>
                </div>
            </div>
        </div>
        {{if header_seller_content}}
        <div class="w-full max-w-lg mx-auto h-fit">
            <div class="p-4 mb-6 text-center bg-white shadow-xl bg-opacity-70 lg:mb-0 rounded-3xl backdrop-blur-lg bg-white/50 sm:p-4">
                <div class="grid grid-cols-1 text-black">
                    <!-- Verkaufen Section - Only show when toggled in backend -->
                    {{partial:subpartials-header/front-page-sell}}
                </div>
            </div>
        </div>
        {{/if}}
    </div>
    <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
        <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
    </div>
</div>
