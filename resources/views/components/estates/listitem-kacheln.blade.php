<li class="list-none mb-4" wire:key="estate-{{ $estate['id_internal'] }}">
    <div class="p-0 space-y-4 bg-white border-l border-r border-gray-200 shadow-md borter-t border-b-none sm:border dark:border-gray-700"
         wire:loading.class="animate-pulse" x-data="{ estateId: {{ $estate['id_internal'] }} }">
        <div class="grid w-full max-w-lg grid-cols-1 mx-auto md:flex-col md:mb-0 md:space-x-0 md:max-w-none">
            <a href="{{ url('immobilien/details/' . strval($estate['id_internal'])) }}" alt="zur Immobilie" target="_blank">
                <div class="relative" wire:key="estate-img-container-{{ $estate['id_internal'] }}">
                    <img class="object-cover w-full shadow-none sm:shadow-t-lg sm:shadow-r-lg sm:shadow-l-lg h-72 lazy"
                         target="_blank"
                         data-src="{{ isset($estate['estate_images'][0]['url']) ? $estate['estate_images'][0]['url'] . '@800x600' : 'https://via.placeholder.com/300x200' }}"
                         alt="{{ isset($estate['estate_images'][0]['title']) ? $estate['estate_images'][0]['title'] : 'Platzhalter Objekttitel' }}"
                         loading="lazy" />
                    <div class="absolute transform -translate-x-1/2 -translate-y-1/2 spinner top-1/2 left-1/2">
                        <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 008 8V12A4 4 0 004 8"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <div class="flex flex-col h-full p-5">
                <div class="flex-grow space-y-4">
                    <div class="flex items-center justify-between gap-6">
                        <div class="flex items-center gap-2 h-[50px]">
                            <span class="text-lg font-bold text-gray-900">
                                <a href="{{ url('immobilien/details/' . strval($estate['id_internal'])) }}" target="_blank">
                                    @if ($estate['objekttitel'])
                                        {{$estate['objekttitel']}} <span class="font-medium"> in </span>{{ $estate['ort'] }}
{{--                                        {{ \Illuminate\Support\Str::limit($estate['objekttitel'], 30) }} <span class="font-medium"> in </span>{{ $estate['ort'] }}--}}
                                    @else
                                        Kein Titel
                                    @endif
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="w-full h-0.5 mt-1 -full dark:bg-gray-700">
                        <div class="h-0.5 -full bg-primary-600" style="width: 100%"></div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="flex items-center">
                            <h3 class="text-lg font-bold leading-tight text-gray-900">
                                <div>
                                    <span >
                                    @if (strtolower($estate['vermarktungsart']) == 'kauf')
                                            @if ($estate['kaufpreis'] == 0.0)
                                                Preis auf Anfrage
                                            @else
                                                {{ number_format(round($estate['kaufpreis']), 0, ',', '.') }} €
                                            @endif
                                        @else
                                            @if ($estate['warmmiete'] > 0.0)
                                                {{ number_format(round($estate['warmmiete']), 0, ',', '.') }} € <span class="text-gray-500 dark:text-gray-400"> (Warmmiete) </span>
                                            @elseif ($estate['kaltmiete'] > 0.0)
                                                {{ number_format(round($estate['kaltmiete']), 0, ',', '.') }} €
                                            @else
                                                Preis auf Anfrage
                                            @endif
                                        @endif
                                    </span>
                                    <br>
                                    <p class="font-normal text-sm">zzgl. Provision</p>
                                </div>
                            </h3>
                        </div>
                    </div>

                    <div class="grid grid-cols-6">
                        <div class="col-span-6">
                            <div class="grid lg:grid-cols-2 min-h-24">
                                @if (!empty($estate['objekttyp']))
                                    <div class="my-2">
                                        <div class="flex space-x-2 items-center text-gray-500 dark:text-gray-400">
                                            <span>Typ</span>
                                            <span class="font-bold">·</span>
                                            <span class="block font-bold text-sm text-black capitalize">
                                                @if(!empty($estateFields))
                                                    {{ str_replace('/', '/ ', $estateFields['objekttyp']['permittedvalues'][$estate['objekttyp']]) }}
                                                @else
                                                    {{ $estate['objekttyp'] }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if($estate['objektart']=='grundstueck')
                                    @if (floatval($estate['grundstuecksflaeche']) > 0)
                                        <div class="my-2">
                                            <div class="flex space-x-2 items-center text-gray-500 dark:text-gray-400">
                                                <span class="">Grundstücksfläche</span>
                                                <span class="font-bold">·</span>
                                                <span class="block text-sm font-bold text-black">
                                                    {{ round($estate['grundstuecksflaeche']) }} m&sup2;
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    @if (floatval($estate['wohnflaeche']) > 0)
                                        <div class="my-2">
                                            <div class="flex space-x-2 items-center text-gray-500 dark:text-gray-400">
                                                <span class="">Wohnfläche</span>
                                                <span class="font-bold">·</span>
                                                <span class="block text-sm font-bold text-black">
                                                    {{ round($estate['wohnflaeche']) }} m&sup2;
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                @if (floatval($estate['anzahl_zimmer']) > 0)
                                    <div class="my-2">
                                        <div class="flex space-x-2 items-center text-gray-500 dark:text-gray-400">
                                            <span class="">Zimmer</span>
                                            <span class="font-bold">·</span>
                                            <span class="block text-sm font-bold text-black">
                                                {{ round($estate['anzahl_zimmer']) }}
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                @if (floatval($estate['baujahr']) > 0)
                                    <div class="my-2">
                                        <div class="flex space-x-2 items-center text-gray-500 dark:text-gray-400">
                                            <span class="">Baujahr</span>
                                            <span class="font-bold">·</span>
                                            <span class="block text-sm font-bold text-black">{{ $estate['baujahr'] }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3">
                    <div class="flex flex-col justify-end w-full gap-4 mt-4 md:mt-2 col-span-full lg:justify-center sm:col-span-2 sm:flex-row md:flex-col lg:flex-row lg:items-center lg:col-span-3">
                        <a href="{{ url('immobilien/details/' . strval($estate['id_internal'])) }}" target="_blank"
                           title="Sehen Sie sich diese Immobilie an"
                           class="text-white w-full bg-primary hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium -lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                           role="button">
                            Jetzt ansehen
                        </a>

                        <a wire:click="openModal({{ $estate['id_internal'] }})"
                           class="inline-flex items-center justify-center w-full px-5 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 -lg focus:outline-none hover:bg-gray-100 hover:text-primary focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                           role="button">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            Direkt anfragen
                        </a>
                    </div>
                </div>
                @livewire('estate-user-component', ['estateId' => $estate['id_internal'], 'logoUrl' => null, 'userId' => $estate['benutzer'], "source" => "small_boxes"], key($estate['id_internal']))
            </div>
        </div>
    </div>
</li>
