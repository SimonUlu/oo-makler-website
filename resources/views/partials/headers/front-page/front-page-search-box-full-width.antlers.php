
<div class="relative w-full py-16 bg-black lg:py-32 bg-blend-multiply md:py-26">
    <img class="absolute inset-0 object-cover w-full h-full opacity-50" src="{{header_day.0.url}}" alt="{{header_day.0.alt}}"">
    <div class="relative max-w-screen-xl px-4 py-8 mx-auto text-white lg:py-16 xl:px-0 z-1">
        <div class="max-w-screen-md m-auto mb-6 text-center lg:mb-0">
            <h1 class="mb-4 text-4xl font-bold leading-tight tracking-tight text-white md:text-5xl lg:text-6xl">{{title}}</h1>
            <p class="mb-6 font-light text-gray-300 md:text-lg lg:mb-8 lg:text-xl">{{subtitle}}</p>
        </div>
        <!-- Verkaufen Section - Only show when toggled in backend -->
        {{if header_seller_content}}
        <div class="grid grid-cols-1 space-x-4 space-y-16 text-black">
            {{partial:subpartials-header/front-page-searchbox}}
            {{partial:subpartials-header/front-page-sell}}
        </div>
        {{/if}}
    </div>
</div>
