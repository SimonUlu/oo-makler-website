<section class="relative w-full h-full">
    {{ if header_type == 'type_1' }}
    {{partial:headers/front-page/front-page-search-box-full-width}}
    {{ elseif header_type == 'type_2' }}
    {{partial:headers/front-page/front-page-search-box-left-image-background}}
    {{ elseif header_type == 'type_3' }}
    {{partial:headers/front-page/front-page-search-box-left-image-right}}
    {{ elseif header_type == 'type_4' }}
    {{partial:headers/front-page/front-page-content-left-three-boxes}}
    {{ elseif header_type == 'type_5' }}
    {{partial:headers/front-page/no-image}}
    {{ elseif header_type == 'type_6' }}
        {{partial:headers/front-page/leistungen-header}}
    {{ elseif header_type == 'type_7' }}
        {{partial:headers/front-page/carousel-header}}
    {{ /if }}
</section>

{{if header_type == 'type_6' }}
<div
    class="relative z-20 lg:w-2/3 mx-auto flex justify-between mb-0 bg-white shadow-md rounded sm:p-6 sm:mx-4 -mt-36 md:-mt-24 lg:-mt-36 xl:-mt-48 xl:p-9 xl:mx-auto xl:mb-0"
>
    {{partial:subpartials-header/front-page-searchbox-lower}}
</div>
{{/if}}

{{ if statistic_type != 'type_3' }}
<section class="w-full text-center bg-white">
    <div class="relative max-w-5xl py-16 mx-auto md:px-20 sm:py-24 lg:px-10  max-w-screen-3xl">
        <h2 class="text-4xl font-bold tracking-tight text-primary lg:text-5xl ">{{content_heading_h2}}</h2>
        <div class="text-secondary text-xl lg:text-2xl font-medium pb-4"><p>Alles unter einem Dach</p></div>
        <div class="text-gray-700 sm:px-10 sm:text-xl dark:text-gray-400">{{content_text}}</div>
    </div>
{{ if statistic_type == 'type_1' }}
    <div class="w-full custom-gradient-darker">
        <div>
            {{ partial:statistics/visits-searches-estates }}
        </div>
    </div>
{{ /if }}
{{ if statistic_type == 'type_2' }}
    <div class="w-full custom-gradient pb-20 mx-auto">
        {{ partial:statistics/statistics-2 }}
    </div>
    {{ /if }}
</section>
{{/if}}

<section class="relative w-full px-4 lg:px-10 bg-white max-w-7xl">
    <div class="w-full py-8 mx-auto lg:py-16">
        <div class="text-center text-gray-900">
            <h2 class="mb-4 mt-8 text-4xl font-bold tracking-tight text-primary lg:text-5xl ">{{slider_headline}}</h2>
            <p class="text-gray-500 sm:text-xl dark:text-gray-400 mb-12">
                {{slider_subheader}}
            </p>
        </div>
        {{ partial:pages/estate/estate-columns-3-slider :estates="estates" :estateFields="estateFields" }}
        <div class="py-4 mt-12 text-center">
            <a href="/immobilien" class="fade-in-animation items-center px-6 py-3 mx-2 text-center text-white lg:px-5 focus:ring-4 focus:outline-none bg-secondary">
                Zu unseren Immobillien
            </a>
        </div>
    </div>
</section>


{{if content_two_type === "type_1"}}
    <section class="w-full max-w-7xl px-4 lg:px-10  mt-8 bg-white sm:mt-32">
        {{partial:content-section/content-img-swapped-button}}
    </section>
    {{elseif content_two_type == "type_2"}}
    <section class="w-full max-w-7xl px-4 lg:px-10 mt-8 bg-white sm:mt-32">
        {{partial:content-section/content-img-swapped-button}}
    </section>
{{/if}}

<section class="bg-gray-100 w-full">
{{if services_type == "type_1"}}
<section class="px-4 lg:px-10 mx-auto  max-w-7xl">
    {{partial:services/services-three-per-column}}
</section>
{{else}}
<section class="px-4 lg:px-10 mx-auto max-w-7xl">
    {{partial:services/services-with-image}}
</section>
{{/if}}
</section>


{{if review_type == "type_1"}}
<section class="w-full px-4 lg:px-10 custom-gradient-darker bg-[url('/images/wall.jpg')] relative">
    <div class="absolute top-0 left-0 w-full h-full custom-gradient"></div>
    <div class="max-w-screen-xl px-4 py-8 mx-auto text-left md:text-center lg:py-16 lg:px-6">
        <div class="max-w-screen-sm mx-auto mb-8 lg:mb-16">
            <h2 class="mb-4 text-4xl font-bold tracking-tight text-white relative">
                Was unsere Kunden sagen
            </h2>
        </div>
        {{if review_configuration:google_reviews}}
        <div
            data-google-api-key="{{ $googleApiKey }}"
            x-data="reviewsSlider()"
            x-init="init()"
            data-google-places-id="{{ $googlePlaceId }}"
            class="block"
        >
            {{partial:reviews/google-reviews-full-width}}
        </div>

        {{/if }}
        {{if review_configuration:immoscout24_reviews}}
        {{partial:reviews/immoscout24-reviews-full-width}}
        {{/if }}
    </div>
</section>
{{elseif review_type == "type_2"}}
<section class="w-full bg-gray-50">
    <div class="max-w-7xl px-4 lg:px-10 mx-auto">
        {{partial:referenzen/person-references/person-testimonials}}
    </div>
</section>
{{elseif review_type == "type_4"}}
<section class="w-full bg-gray-50">
    <div class="max-w-7xl px-4 lg:px-10 mx-auto">
        {{partial:referenzen/person-references/person-references}}
    </div>
</section>
{{elseif review_type == "type_5"}}
<section class="w-full bg-gray-50">
    <div class="max-w-7xl px-4 lg:px-10 mx-auto">
        {{partial:reviews/custom-reviews}}
    </div>
</section>
{{/if}}

<div class="relative mx-16">
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div class="w-full border-t border-gray-300"></div>
    </div>
</div>

{{if show_referenzen == "yes"}}
    <section class="w-full bg-white md:px-10 lg:pt-10 max-w-7xl">
        <div class="relative mx-auto">
            <h2 class="mb-4text-4xl font-bold tracking-tight text-left text-gray-900 lg:text-5xl ">Unsere Referenzen</h2>
            <p class="max-w-2xl mt-3 text-xl text-gray-500 sm:mt-2">Hier erhalten Sie einen Einblick in unsere realisierten Projekte und unserer Arbeit als Immobilienberater.</p>
        </div>
        {{partial:immo-slider/slider-outlined-references}}
    </section>
{{/if}}


<section class="relative w-full 0 bg-gray-50 py-16">
    <div class="w-full py-8 mx-auto lg:py-16 max-w-7xl px-4 lg:px-10">
        <div class="text-center text-gray-900">
            <h2 class="mb-4 text-4xl font-bold tracking-tight text-primary lg:text-5xl ">Unsere aktuellsten Referenzen</h2>

            <p class="text-gray-500 sm:text-xl dark:text-gray-400">
                Erhalten Sie einen Einblick in unsere realisierten Projekte und unserer Arbeit als Immobilienberater.
            </p>
        </div>
        <!-- Section Einleitung & Statistics -->

        {{ partial:pages/estate/estate-columns-3-ref :estates="estateReferences" :estateFields="estateFields" }}
    </div>
    <div class="py-4 mt-12 text-center">
        <a href="/immobilien" class="fade-in-animation items-center px-6 py-3 mx-2 text-center text-white lg:px-5 focus:ring-4 focus:outline-none bg-secondary">
            Alle Immobilien ansehen
        </a>
    </div>
</section>





{{if show_posts == "yes"}}
    <section class="w-full max-w-7xl md:px-10 pt-10 lg:pt-20">
        <h2 class="mb-4 text-4xl font-bold tracking-tight text-center text-primary lg:text-5xl "> Unsere Neuigkeiten </h2>
        <div class=" mt-3 text-xl text-gray-500 sm:mt-2 text-center">{{posts_text}}</div>
        {{partial:posts/new-list}}
    </section>
{{/if}}

{{if show_posts == "sequence"}}
    <section class="w-full max-w-7xl mt-8 xl:mt-16 mb-8 xl:mb-16 px-4 lg:px-10">
        {{partial:posts/cta}}
    </section>
{{/if}}

<div class="relative mx-16">
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div class="w-full border-t border-gray-300"></div>
    </div>
</div>

{{if show_suchauftrag == "yes"}}
<section class="w-full bg-white max-w-7xl px-4 lg:px-10">
    {{partial:cta-sections/suchauftrag/suchauftrag-cta}}
</section>
{{/if}}

{{ if seo_content_type == 'type_1' }}
<div class="w-full bg-white max-w-7xl px-4 lg:px-10">
    {{ partial:content-section/content-section }}
</div>
{{ /if }}

<div class="relative mx-16">
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div class="w-full border-t border-gray-300"></div>
    </div>
</div>

{{if show_newsletter == "yes"}}
<section class="w-full bg-white ">
    {{partial:newsletter/newsletter-broad}}
</section>
{{/if}}

