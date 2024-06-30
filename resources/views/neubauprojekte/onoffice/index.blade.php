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

    <section class="w-full bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 lg:px-10">
            @include('partials.neubauprojekte.services')
        </div>

    </section>


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

<section
    class="w-full max-w-7xl mx-auto bg-white lg:pt-10" id="current-projects"
>
    @include('partials.neubauprojekte.cp.list',
            [
                'typ' => "aktuell",
                'art' => "aktuellen Projekte",
                'subtext' => "Hier erhalten Sie einen Einblick in unsere aktuellen Projekte und unserer Arbeit als Immobilienberater.",
                'projekte' => $reference_projects,
            ]
        )
</section>

<div class="text-base text-gray-700 bg-gray-100 py-16 lg:py-32">
    <div class=" max-w-7xl mx-auto px-4 lg:px-10">
        <h2 class="mb-4 text-2xl lg:text-4xl font-bold tracking-tight text-primary">
            Wir sind Ihr Ansprechpartner für den Verkauf Ihrer Immobilie in Berlin & Brandenburg
        </h2>
        <div>
            <div class="mt-6">
                Wir vermitteln Immobilien in Berlin & Brandenburg. Als 100%ige Tochter der Berliner Volksbank eG und damit im
                VR-Banken-Verbund greifen wir dabei auf ein riesiges Netzwerk zum Thema Immobilien und deren Finanzierung 
                und Versicherung zurück. Neben dem klassischen Verkauf von Wohnimmobilien und Grundstücken betreuen wir auch 
                Bauträger und deren Neubauprojekte, Investoren sowie Zwangsversteigerungs- und Bieterverfahren. 
                Der Verkauf oder Kauf einer Immobilie ist für die meisten Menschen eine der wichtigsten Entscheidungen im Leben. 
                Wer dabei Zeit, Ärger und Geld sparen will, beauftragt einen professionellen Immobilienvermittler. 
                Gleichzeitig ist das Zuhause immer Privatsphäre, ob für Eigennutzer oder für Mieter bei Kapitalanlagen.
                 Wir begegnen dieser Verantwortung mit großem Respekt. Gern unterstützen wir auch Sie dabei. 
                 Rufen Sie uns einfach an, wir kommen vorbei. Wir kennen nicht nur Ihren Kiez, wir sind auch dort. 
                 Nach Vereinbarung finden Sie uns an diesen Filialstandorten der Berliner Volksbank:Berlin: Tegel, Weißensee, 
                 Rudow, Zehlendorf und SpandauBrandenburg: Königs Wusterhausen, Bernau, Strausberg, Potsdam und Gransee. 
                 Unser Büro in der Bundesallee hilft Ihnen gerne weiter und nennt Ihnen die passenden Ansprechpartner.     
            </div>
        </div>
    </div>
</div>


    
<section class="py-8 xl:py-12 max-w-7xl w-full px-4 lg:px-10 mx-auto">
    @include('partials.cta-sections.contact.new-contact-team')
</section>


    
@endsection

