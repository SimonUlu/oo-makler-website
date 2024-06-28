@extends('layouts.layoutblade')

@section('blade_content')
    <div class="w-full mb-36 xl:mb-32 -mt-[80px]">
        @include('partials.headers.projekte.projekte-substitute')
    </div>

    <div
        class="relative z-20 flex justify-between sm:p-6 mb-0 bg-white rounded px-4 lg:px-10 max-w-7xl -mt-36 xl:-mt-32 xl:p-9 xl:mx-auto xl:mb-0"
    >
        <div class="w-full bg-white">
            <div class="py-8 mx-auto lg:py-16">
                <section>
                    @include('partials.neubauprojekte.projects-text-substitute')
                </section>
                    @include('partials.eigentuemer.general.content-img-proj')
            </div>
        </div>
    </div>


@if(isset($categorizedProjects['Aktuelle Projekte']))
<section
    class="w-full max-w-7xl mx-auto bg-white lg:pt-10" id="current-projects"
>
    @include('partials.neubauprojekte.onoffice.list.list',
                [
                    'typ' => "aktuell",
                    'art' => "aktuellen Projekte",
                    'subtext' => "Hier erhalten Sie einen Einblick in unsere aktuellen Projekte und unserer Arbeit als Immobilienberater.",
                    'projekte' => $categorizedProjects['Aktuelle Projekte'],
                ]
            )
</section>
@endif


    <section class="my-12 lg:my-24  max-w-7xl mx-auto px-4 lg:px-10">
        <div class="border-t border-b  py-6 lg:py-12">
            @include('partials.cta-sections.contact.cta-contact')
        </div>
    </section>


    @if(isset($categorizedProjects['Referenzobjekte']))
    <section
        class="w-full max-w-7xl mx-auto bg-white lg:pt-10" id="past-projects"
    >
    @include('partials.neubauprojekte.onoffice.list.list-grid',
    [
        'art' => "Referenzprojekte",
        'subtext' => "Hier erhalten Sie einen Einblick in unsere realisierten Projekte und unserer Arbeit als Immobilienberater.",
        'projekte' => $categorizedProjects['Referenzobjekte'],
    ]
    )
    </section>
    @endif


    @if(isset($categorizedProjects['Vorankündigung']))
    <section
        class="w-full max-w-7xl mx-auto bg-white lg:pt-10" id="future-projects"
    >
    @include('partials.neubauprojekte.onoffice.list.list-grid',
    [
        'art' => "Vorankündigungen",
        'subtext' => "Hier erhalten Sie einen Einblick in unsere realisierten Projekte und unserer Arbeit als Immobilienberater.",
        'projekte' => $categorizedProjects['Vorankündigung'],
    ]
    )</section>
    @endif
    
@endsection

