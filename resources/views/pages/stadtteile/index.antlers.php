<div class="w-full bg-white">
    {{partial:headers/leistungen/verkaufen-header-full-width}}
</div>

<section class="w-full text-center bg-white">
    <div class="relative max-w-7xl py-16 mx-auto sm:py-24 lg:px-10">
        <h2 class="text-4xl font-bold tracking-tight text-primary lg:text-5xl mb-8 max-w-5xl mx-auto">{{title}}</h2>
        <div class="text-gray-700 sm:px-10 sm:text-xl dark:text-gray-400">{{subtitle}}</div>
    </div>
</section>

{{partial:stadtteile/index/district-map}}



<section class="w-full max-w-7xl mx-auto py-12 lg:py-24 px-4 lg:px-10">
    {{partial:stadtteile/index/table}}
</section>

<section class="w-full max-w-7xl mx-auto py-12 lg:py-24 px-4 lg:px-10">
    {{partial:stadtteile/index/content}}
</section>


<section class="w-full max-w-7xl mx-auto py-12 lg:py-24 px-4 lg:px-10">
    {{partial:cta-sections/suchauftrag/suchauftrag-cta}}
</section>

<div class="px-4 py-12 sm:px-0">
    <h2
        class="max-w-4xl text-3xl font-bold tracking-tight text-center text-gray-900 sm:text-4xl"
    >
        Kontaktieren Sie uns!
    </h2>
    <div class="pt-4" {{partial:contact-forms/contact-form-standard formId="2" onofficeNote="{{onoffice_note}}"
    title="Immobilien" defaultMessage="Bitte nehmen Sie zum Thema Immobilien Kontakt mit mir auf."}}
</div>




