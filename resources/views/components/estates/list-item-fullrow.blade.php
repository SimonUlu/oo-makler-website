<li class="list-none" wire:key="estate-{{ $estate['id'] }}">

    <div class="p-0 space-y-4 bg-white border-l border-r border-gray-200 rounded-lg shadow-md borter-t border-b-none sm:border dark:border-gray-700"
        wire:loading.class="animate-pulse" x-data="{ estateId: {{ $estate['id'] }} }">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <a href="{{ url('immobilien/details/' . strval($estate['id'])) }}" alt="zur Immobilie" target="_blank">
                <div class="relative" wire:key="estate-img-container-{{ $estate['id'] }}">
                    <img class="object-cover w-full rounded-b-none rounded-l-none rounded-tl-lg rounded-tr-lg shadow-none lg:rounded-l-lg lg:rounded-tr-none sm:shadow-t-lg sm:shadow-r-lg sm:shadow-l-lg h-96 lazy"
                        target="_blank"
                        data-src="{{ isset($estate['elements']['images'][0]['url']) ? $estate['elements']['images'][0]['url'] . '@800x600' : asset('img/300x200.png')}}"
                        alt="{{ isset($estate['elements']['images'][0]['title']) ? $estate['elements']['images'][0]['title'] : 'Platzhalter Objekttitel' }}"
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
                        <div class="flex items-center gap-2">
                            <span class="text-lg font-bold text-gray-900 ">
                                <a href="{{ url('immobilien/details/' . strval($estate['id'])) }}" target="_blank">
                                    @if ($estate['elements']['objekttitel'])
                                        {{ $estate['elements']['objekttitel'] }}
                                    @else
                                        Kein Titel
                                    @endif
                                </a>
                            </span>
                        </div>
                        {{-- <span class="text-xs font-normal text-right text-gray-500 dark:text-gray-400">
                            bereits  mal angesehen
                        </span> --}}
                    </div>
                    <div class="w-full h-0.5 mt-1 rounded-full dark:bg-gray-700">
                        <div class="h-0.5 rounded-full bg-primary-600" style="width: 100%"></div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="flex items-center">
                            <h3 class="text-lg font-bold leading-tight text-gray-900 ">
                                @if ($estate['elements']['vermarktungsart'] == 'kauf')
                                    @if ($estate['elements']['kaufpreis'] == 0.0)
                                        Preis auf Anfrage
                                    @else
                                        {{ number_format(round($estate['elements']['kaufpreis']), 0, ',', '.') }} €
                                    @endif
                                @else
                                    @if ($estate['elements']['warmmiete'] > 0.0)
                                        {{ number_format(round($estate['elements']['warmmiete']), 0, ',', '.') }} € <span class="text-gray-500 dark:text-gray-400"> (Warmmiete) </span>
                                    @elseif ($estate['elements']['kaltmiete'] > 0.0)
                                        {{ number_format(round($estate['elements']['kaltmiete']), 0, ',', '.') }} €
                                    @else
                                        Preis auf Anfrage
                                    @endif
                                @endif
                            </h3>
                        </div>
                        <span>
                            <div class="flex justify-end space-x-2">
                                @if ($estate['elements']['vermarktungsart'] == 'kauf')
                                    <span
                                        class="capitalize inline-flex items-center rounded-full bg-primary-900 px-2.5 py-0.5 text-sm font-medium text-white">
                                        {{ $estate['elements']['vermarktungsart'] }}
                                    </span>
                                @elseif($estate['elements']['vermarktungsart'] == 'miete')
                                    <span
                                        class="capitalize inline-flex items-center rounded-full border border-primary text-primary px-2.5 py-0.5 text-sm font-medium">
                                        {{ $estate['elements']['vermarktungsart'] }}
                                    </span>
                                @endif
                            </div>
                        </span>
                    </div>

                    <div class="grid grid-cols-6">
                        <div class="col-span-6 text-base font-normal text-gray-500 dark:text-gray-400">
                            {{ $estate['elements']['ort'] }}
                        </div>
                    </div>

                    <div class="grid grid-cols-6">

                        <div class="col-span-6">
                            <div class="grid grid-cols-2">
                                <div class="my-2">
                                    <div class="flex space-x-2 text-gray-500 dark:text-gray-400">
                                        <span class="">Typ</span>
                                        <span class="font-bold">·</span>
                                        <span class="block font-bold text-black capitalize">
                                            {{ str_replace('/', '/ ', $estateFields['objektart']['permittedvalues'][$estate['elements']['objektart']]) }}
                                        </span>
                                    </div>
                                </div>
                                @if ($estate['elements']['wohnflaeche'] !== '0.00')
                                    <div class="my-2">
                                        <div class="flex space-x-2 text-gray-500 dark:text-gray-400">
                                            <span class="">Wohnfl&auml;che</span>
                                            <span class="font-bold">·</span>
                                            <span class="block font-bold text-black">
                                                {{ round($estate['elements']['wohnflaeche']) }}
                                                m&sup2;</span>
                                        </div>
                                    </div>
                                @endif
                                @if ($estate['elements']['anzahl_zimmer'] !== '0.00')
                                    <div class="my-2">
                                        <div class="flex space-x-2 text-gray-500 dark:text-gray-400">
                                            <span class="">Zimmer</span>
                                            <span class="font-bold">·</span>
                                            <span
                                                class="block font-bold text-black">{{ round($estate['elements']['anzahl_zimmer']) }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if ($estate['elements']['baujahr'] !== '0')
                                    <div class="my-2">
                                        <div class="flex space-x-2 text-gray-500 dark:text-gray-400">
                                            <span class="">Baujahr</span>
                                            <span class="font-bold">·</span>
                                            <span
                                                class="block font-bold text-black">{{ $estate['elements']['baujahr'] }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3">
                    <div
                        class="flex flex-col justify-end w-full gap-4 mt-4 md:mt-2 col-span-full lg:justify-center sm:col-span-2 sm:flex-row md:flex-col lg:flex-row lg:items-center lg:col-span-3">
                        <a href="{{ url('immobilien/details/' . strval($estate['id'])) }}" target="_blank"
                            title="Sehen Sie sich diese Immbolie an"
                            class="text-white w-full bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                            role="button">
                            Jetzt ansehen
                        </a>

                        <a wire:click="openModal({{ $estate['id'] }})"
                            class="inline-flex items-center justify-center w-full px-5 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
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
                @livewire('estate-user-component', ['estateId' => $estate['id'], 'logoUrl' => $logoUrl, 'userId' => $estate['elements']['benutzer']] ,key($estate['id']))
            </div>
        </div>
    </div>
    {{--
    @if ($showContactModal)
        @include('partials.contact-forms.estate-list-contact-modal', [
            'estateContactModal' => $estateContactModal,
            'showContactModal' => $showContactModal,
        ])
    @endif --}}


</li>
