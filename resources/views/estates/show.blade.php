@extends('layouts.layoutblade')

@section('blade_content')
    <div class="mx-auto w-full max-w-7xl" x-data="{ shareOpen: false }">

        @if (!empty($estate))
            @include('components.estate-detail.share-modal')

            <div class="font-sans leading-normal text-gray-800">
                <div class="flex flex-col justify-center items-center mx-auto">
                    <div class="w-full bg-white">
                        <x-breadcrumb :estate="$estate" />
                        @if ($headerImageAppearance == 'type_1')
                            <x-singleheader :estate="$estate" />
                        @else
                            <x-multiheader :estate="$estate" :titelbild="$titelbild" />
                        @endif
                        <!-- Product info -->
                        <div class="px-4 pt-4 pb-20 mx-auto w-full lg:gap-x-4">
                            <div class="grid grid-cols-1 space-x-4 md:grid-cols-4">
                                <div class="col-span-3 md:col-span-4 lg:col-span-3">

                                    @php
                                        $boxes = [
                                            !empty($estate->get('ort')) || !empty($estate->get('strasse')),
                                            !empty($estate->get('anzahl_zimmer')) && $estate->get('anzahl_zimmer') != 0,
                                            !empty($estate->get('wohnflaeche')) && $estate->get('wohnflaeche') != 0.00,
                                            !empty($estate->get('vermarktungsart')) && ($estate->get('warmmiete') > 0.0 || $estate->get('kaltmiete') > 0.0 || $estate->get('kaufpreis') > 0.0)
                                        ];
                                    $boxesCount = count(array_filter($boxes));
                                    @endphp

                                    @if($boxesCount > 0)

                                        <div class="hidden top-28 items-center mt-4 mr-4 mb-12 bg-white md:grid md:grid-cols-{{$boxesCount}}">


                                        <x-estate-detail.subheader :estate="$estate" />
                                    </div>

                                    @endif

                                    <h2
                                        class="py-8 mb-4 w-full text-3xl font-extrabold tracking-tight md:text-4xl xl:text-5xl">
                                        {{ $estate->get('objekttitel') }}</h2>
                                    <div class="my-8 sm:mr-7">
                                        <!-- Details -->
                                        <x-estate-detail.details :estate="$estate" />
                                        <x-estate-detail.contact-person :estate="$estate" :estateId="$estate->get('id_internal')" />
                                    </div>
                                    <div>
                                        <!-- Description -->
                                        <div class="grid grid-cols-3 mr-0 space-x-0 sm:mr-8 sm:space-x-5">
                                            <div
                                                class="col-span-3 gap-y-4 gap-x-16 p-8 space-y-5 bg-gray-50 rounded-2xl">

                                                <div>
                                                    <h2 class="text-xl font-bold tracking-tight text-gray-900 md:text-3xl">
                                                        Lagebeschreibung
                                                    </h2>
                                                    <div class="col-span-full text-sm bg-gray-50 rounded-2xl md:text-md">
                                                        {{ $estate->get('lage') }}
                                                    </div>
                                                </div>

                                                <div>
                                                    <h2 class="text-xl font-bold tracking-tight text-gray-900 md:text-3xl">
                                                        Objektbeschreibung
                                                    </h2>
                                                    @php
                                                        $sentences = preg_split(
                                                            '/(?<=[.!?])\s+(?=[a-zA-Z])/i',
                                                            $estate->get('objektbeschreibung'),
                                                        );
                                                        $randomSentence = $sentences[array_rand($sentences)];
                                                    @endphp
                                                    <p class="mt-2 text-sm italic leading-7 text-gray-600">
                                                        {{ '„' . $randomSentence . '“' }}
                                                    </p>
                                                    <div class="col-span-full text-sm bg-gray-50 rounded-2xl md:text-md">
                                                        {{ $estate->get('objektbeschreibung') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        @if(isset($estate->get('energiebedarf')['url']))
                                        <x-estate-detail.energy :estate="$estate" />

                                            <x-estate-detail.energy-svg :estate="$estate" :pfeilposition="$pfeilposition" />
                                        @endif
                                    </div>
                                </div>

                                <aside class="mt-4">
                                    <div class="hidden sticky top-28 lg:block">
                                        <aside aria-labelledby="reactions-label" class="mb-2">
                                            <x-estate-detail.contact-form-small :estate="$estate" :estateId="$estate->get('id_internal')" />
                                        </aside>
                                    </div>
                                </aside>

                            </div>

                        </div>

                        <div class="px-4 pt-4 pb-20 mx-auto w-full sm:px-6 lg:gap-x-4 lg:px-12">

                            <h2 class="pl-2 text-3xl font-bold tracking-tight text-gray-900">
                                @if ($estate->get('wohnflaeche') !== null && $estate->get('wohnflaeche') > 0 && (int) $anzahlZimmerWort > 0)
                                    Wohlfühlen auf {{ round($estate->get('wohnflaeche')) }} m² und
                                    {{ $anzahlZimmerWort }} Zimmern
                                @elseif($estate->get('objektart') != 'grundstueck')
                                    Einziehen und wohlfühlen
                                @endif
                            </h2>

                            @php
                                $numImages = sizeof($estate->get('estate_images')) - 4;
                                $columns = max(min((int) ($numImages / 2), 12), 4);
                            @endphp
                            <div
                                class="grid max-w-2xl grid-cols-3 mx-auto mt-16 gap-x-2 gap-y-8 lg:mx-0 lg:max-w-none lg:grid-cols-{{ $columns }}">

                                @foreach (array_slice($estate->get('estate_images') ?? [], 4) as $key => $image)
                                    <div class="flex flex-col justify-between items-start">
                                        <div class="relative w-full rounded-lg">
                                            <img @click="showSlide({{ $key + 4 }}); openImgSlideShow = !openImgSlideShow"
                                                src="{{ $image['url'] }}"
                                                class="object-cover w-full bg-gray-100 cursor-pointer aspect-[16/9] sm:aspect-[2/1] lg:aspect-[3/2]"
                                                alt="{{ $image['title'] ?? '' }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Features -->
                            {{-- @if ($features)
                            <x-estate-detail.features :estate="$estate" :features="$features" />
                        @endif --}}


                            <div class="grid grid-cols-2 py-12 md:space-x-4">
                                <div class="col-span-2 md:col-span-1 min-h-[300px]">
                                    <!-- Location -->
                                    <x-estate-detail.location-mapbox :estate="$estate" :estateId="$estate->get('id_internal')" />
                                </div>
                                <div class="block col-span-2 mt-4 ml-0 md:col-span-1 md:mt-0">
                                    <livewire:estate-contact-controller :estate="$estate" :estateId="$estateId"
                                        :defaultMessage="'Ich bin an dieser Immobilie interessiert. Bitte nehmen Sie Kontakt mit mir auf.'" :title="'Fragen Sie diese Immobilie jetzt an!'" />
                                    {{-- <x-contact-form-simple :user="$onOfficeUser" /> --}}
                                </div>
                            </div>

                            @if ($epassSkalaImage)
                                <div class="lg:col-span-3">
                                    <section aria-labelledby="reviews-heading"
                                        class="pt-5 mt-6 border-t border-gray-200 lg:pt-8 lg:mt-10">
                                        <h2 class="text-3xl font-bold tracking-tight text-gray-900">Energiepass - Skala</h2>
                                        @include('components.estate-detail.energieausweis', [
                                            'epassSkalaImage' => $epassSkalaImage,
                                        ])
                                    </section>
                                </div>
                            @endif

                            <div class="lg:col-span-3">
                                <section aria-labelledby="reviews-heading"
                                    class="pt-5 mt-6 border-t border-gray-200 lg:pt-8 lg:mt-10">
                                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Das könnte Ihnen
                                        auch gefallen</h2>
                                    @include('pages.estate.estate-columns-3-slider', [
                                        'estates' => $estateRecommendations,
                                        'estateFields' => $estateFields,
                                    ])
                                </section>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        @else
            <div class="container mx-auto">
                <div class="flex flex-col justify-center items-center">
                    <h1 class="text-4xl font-bold">404</h1>
                    <p class="text-xl">Die Seite wurde nicht gefunden</p>
                </div>
            </div>
        @endif
    </div>
@endsection
