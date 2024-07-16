<div class="w-full bg-white">
    {{partial:headers/leistungen/verkaufen-header-full-width}}
</div>

<section class="w-full text-center bg-white pb-12 lg:pb-20">
    <div class="relative max-w-7xl mx-auto lg:px-10">
        <h2 class="text-4xl font-bold tracking-tight text-primary lg:text-5xl mb-8 max-w-5xl mx-auto">{{title}}</h2>
        <div class="text-gray-700 sm:px-10 sm:text-xl dark:text-gray-400">{{subtitle}}</div>
    </div>
</section>

<section class="w-full max-w-7xl px-4 lg:px-10">
    <div class="relative max-w-7xl mx-auto lg:px-10">
        <h2 class="text-4xl font-bold tracking-tight text-primary lg:text-5xl mb-8 max-w-5xl mx-auto text-center">
            Hier sind wir zu finden!
        </h2>
    </div>
    {{partial:stadtteile/index/old-district-map}}
</section>

<section class="w-full">
    {{partial:stadtteile/index/location-table}}
</section>

<section class="w-full">
    <div class="relative max-w-7xl mx-auto lg:px-10">
        <h2 class="text-4xl font-bold tracking-tight text-primary lg:text-5xl mb-8 max-w-5xl mx-auto text-center">
            Hier sind wir zu finden!
        </h2>
    </div>
    {{partial:stadtteile/index/location-map}}
</section>

<section class="w-full px-4 lg:px-10 custom-gradient-darker bg-[url('/images/wall.jpg')] relative">
    <div class="absolute top-0 left-0 w-full h-full custom-gradient"></div>
    <div class="max-w-screen-xl px-4 py-8 mx-auto text-left md:text-center lg:py-16 lg:px-6">
        <div class="max-w-screen-sm mx-auto mb-8 lg:mb-16">
            <h2 class="mb-4 text-4xl font-bold tracking-tight text-white relative">
                Was unsere Kunden sagen
            </h2>
        </div>
        <div
            data-google-api-key="{{ $googleApiKey }}"
            x-data="reviewsSlider()"
            x-init="init()"
            data-google-places-id="{{ $googlePlaceId }}"
            class="block"
        >
            {{partial:reviews/google-reviews-full-width}}
        </div>
    </div>
</section>

<div class="w-full bg-gray-100">
    <section class="py-8 xl:py-12 mx-auto max-w-7xl w-full px-4 lg:px-10">
        {{partial:cta-sections/contact/contact-team}}
    </section>
</div>




