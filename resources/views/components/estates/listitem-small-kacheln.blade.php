<li class="list-none mb-4 px-2 w-full" wire:key="estate-{{ $estate['id'] }}">
    <div class="p-0 space-y-4 bg-white border-l border-r border-gray-200 shadow-md borter-t border-b-none sm:border dark:border-gray-700 rounded-lg"
        wire:loading.class="animate-pulse" x-data="{ estateId: {{ $estate['id'] }} }">
        <div class="grid w-full max-w-lg grid-cols-1 mx-auto md:flex-col md:mb-0 md:space-x-0 md:max-w-none">
            <a href="{{ url('immobilien/details/' . strval($estate['id'])) }}" alt="zur Immobilie" target="_blank">
                <div class="relative" wire:key="estate-img-container-{{ $estate['id'] }}">
                    <img class="object-cover w-full shadow-none  sm:shadow-t-lg sm:shadow-r-lg sm:shadow-l-lg h-64 lazy rounded-t-lg"
                        target="_blank"
                        data-src="{{ isset($estate['elements']['images'][0]['url']) ? $estate['elements']['images'][0]['url'] . '@800x600' : asset('img/300x200.png')}}"
                        alt="{{ isset($estate['elements']['objekttitel']) ? $estate['elements']['objekttitel'] : 'Platzhalter Objekttitel' }}"
                        loading="lazy" />
                    <div class="absolute transform -translate-x-1/2 -translate-y-1/2 spinner top-1/2 left-1/2">
                        <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 008 8V12A4 4 0 004 8"></path>
                        </svg>
                    </div>
                    {{-- @if ($estate['clickCount'] == 1)
                        <div
                            class="absolute bottom-0 left-0 m-4 bg-secondary opacity-90 text-white p-1 text-xs rounded">
                            Heute schon {{ $estate['clickCount'] }} Ansicht
                        </div>
                    @elseif ($estate['clickCount'] > 1)
                        <div
                            class="absolute bottom-0 left-0 m-4 bg-secondary opacity-90 text-white p-1 text-xs rounded">
                            Heute schon {{ $estate['clickCount'] }} Ansichten
                        </div>
                    @endif --}}
                </div>
            </a>

            <div class="flex flex-col h-full p-5">
                <div class="flex-grow space-y-2">
                    <div class="flex items-center justify-between gap-6">
                        <div class="flex gap-2 h-[30px] justify-between w-full">
                            <div>
                                <span class="text-lg font-bold text-gray-900 ">
                                    <a href="{{ url('immobilien/details/' . strval($estate['id'])) }}" target="_blank">
                                        @if ($estate['elements']['vermarktungsart'] == 'kauf')
                                            @if ($estate['elements']['kaufpreis'] == 0.0)
                                                Preis auf Anfrage
                                            @else
                                                €
                                                {{ number_format(round($estate['elements']['kaufpreis']), 0, ',', '.') }}
                                            @endif
                                        @else
                                            @if ($estate['elements']['warmmiete'] > 0.0)
                                                €
                                                {{ number_format(round($estate['elements']['warmmiete']), 0, ',', '.') }}
                                                <span class="text-gray-500 dark:text-gray-400"> (Warmmiete) </span>
                                            @elseif ($estate['elements']['kaltmiete'] > 0.0)
                                                €
                                                {{ number_format(round($estate['elements']['kaltmiete']), 0, ',', '.') }}
                                            @else
                                                Preis auf Anfrage
                                            @endif
                                        @endif
                                    </a>
                                </span>
                            </div>
                            <div>
                                <span class="text-lg font-bold text-gray-900 cursor-pointer">
                                    <a class="cursor-pointer" wire:click="openModal({{ $estate['id'] }})"
                                        target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                        </svg>
                                    </a>
                                </span>
                            </div>
                        </div>
                        {{-- <span class="text-xs font-normal text-right text-gray-500 dark:text-gray-400">
                            bereits  mal angesehen
                        </span> --}}
                    </div>
                    <div class="grid grid-cols-6 h-[35px]">

                        <div class="col-span-6">
                            <div class="pb-2">
                                <div class="text-gray-600">
                                    <div class="flex space-x-1 items-center  w-full">
                                        @if ($estate['elements']['baujahr'] !== '0')
                                            <span
                                                class="block text-sm font-bold">{{ $estate['elements']['baujahr'] }}</span>

                                            <span class="font-bold">·</span>
                                        @endif
                                        @if ($estate['elements']['anzahl_zimmer'] !== '0.00')
                                            <span class="block text-sm font-bold ">
                                                {{ round($estate['elements']['anzahl_zimmer']) }} Zimmer
                                            </span>

                                            <span class="font-bold">·</span>
                                        @endif
                                        @if ($estate['elements']['wohnflaeche'] !== '0.00')
                                            <span class="block  text-sm font-bold ">
                                                {{ round($estate['elements']['wohnflaeche']) }}
                                                m&sup2;</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="text-gray-400">
                                    <div class="flex space-x-1 items-center  w-full">
                                        @if ($estate['elements']['objektart'] !== '0')
                                            <span class="block font-bold text-sm capitalize">
                                                {{ str_replace('/', '/ ', $estateFields['objektart']['permittedvalues'][$estate['elements']['objektart']]) }}
                                            </span>
                                        @endif
                                        <span class="block font-bold text-sm"> in </span>
                                        <span class="block font-bold text-sm capitalize">
                                            {{ $estate['elements']['plz'] }}
                                        </span>
                                        <span class="block text-sm font-bold ">
                                            {{ $estate['elements']['ort'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @livewire('estate-user-component', ['estateId' => $estate['id'], 'logoUrl' => $logoUrl, 'userId' => $estate['elements']['benutzer'], 'source' => 'small_boxes'], key($estate['id']))
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
