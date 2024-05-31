<div class="w-full bg-white">
    {{partial:headers/referenzen/referenzen-header-full-width}}
</div>


<section class="w-full bg-white md:px-10 lg:pt-10 max-w-7xl">
    <div class="relative mx-auto">
        <h2 class="mb-4 ml-8 leading-tight mr-4 text-4xl font-bold tracking-tight text-left text-gray-900 lg:text-5xl ">Unsere Immobilien in {{ title }} zum Verkauf</h2>
        <p class="max-w-2xl mt-3 ml-8 text-xl text-gray-500 sm:mt-2">{{kaufen_text}}</p>
    </div>
    {{partial:immo-slider/slider-outlined :estates="buyEstates"}}
</section>


<section class="w-full bg-white md:px-10 lg:pt-10 max-w-7xl">
    <div class="relative mx-auto">
        <h2 class="mb-4 ml-8 mr-4 leading-tight text-4xl font-bold tracking-tight text-left text-gray-900 lg:text-5xl ">Unsere Immobilien in {{ title }} zum Mieten</h2>
        <p class="max-w-2xl mt-3 ml-8 text-xl text-gray-500 sm:mt-2">{{mieten_text}}</p>
    </div>
    {{partial:immo-slider/slider-outlined :estates="rentEstates"}}
</section>

<section class="w-full md:px-10 max-w-7xl bg-slate-50 py-10">
    {{partial:stadtteile/feature-section}}
</section>

<section>
    {{ if seo_content_type == 'type_1' }}
    <div class="w-full bg-white">
        {{ partial:content-section/content-section }}
    </div>
    {{ /if }}
</section>
