<div x-data="{ openModal: false, imageUrl: '' }">
    <div class="border-t border-gray-800/10 max-w-7xl mx-auto py-16 px-4 lg:px-10">
        <h2 class="text-2xl lg:text-4xl font-semibold leading-7 text-gray-900  mb-12">
            Appartments, Wohnungen und Gewerbeflächen
        </h2>
        <div>
            <table class="mt-6 w-full whitespace-nowrap text-left">
                <colgroup>
                    <col class="w-full sm:w-3/12">
                    <col class="lg:w-3/12">
                    <col class="lg:w-2/12">
                    <col class="lg:w-2/12">
                    <col class="lg:w-2/12">
                </colgroup>
                <thead class="border-b border-gray-800/10 text-sm leading-6 text-gray-700">
                    <tr>
                        <th scope="col" wire:click="sortBy('Id')" class="py-2 pl-4 pr-8 font-semibold sm:pl-6 lg:pl-8">
                            <div class="flex cursor-pointer">
                                Einheit
                                <svg data-v-2059301d="" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path data-v-2059301d="" d="M8 9L12 5L16 9" stroke="black" stroke-width="1.5"></path> <path data-v-2059301d="" d="M8 15L12 19L16 15" stroke="black" stroke-width="1.5"></path></svg>
                            </div>
                        </th>
                        <th scope="col" wire:click="sortBy('objektart')" class="py-2 pl-0 pr-8 font-semibold sm:table-cell">
                            <div class="flex cursor-pointer">
                                Immobilienart
                                <svg data-v-2059301d="" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path data-v-2059301d="" d="M8 9L12 5L16 9" stroke="black" stroke-width="1.5"></path> <path data-v-2059301d="" d="M8 15L12 19L16 15" stroke="black" stroke-width="1.5"></path></svg>
                            </div>
                        </th>
                        <th scope="col" wire:click="sortBy('etagen_zahl')" class="py-2 pl-0 pr-4 text-right font-semibold sm:pr-8 sm:text-left lg:pr-20">
                            <div class="flex cursor-pointer">
                                Etage
                                <svg data-v-2059301d="" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path data-v-2059301d="" d="M8 9L12 5L16 9" stroke="black" stroke-width="1.5"></path> <path data-v-2059301d="" d="M8 15L12 19L16 15" stroke="black" stroke-width="1.5"></path></svg>
                            </div>
                        </th>
                        <th scope="col" wire:click="sortBy('anzahl_zimmer')" class="hidden py-2 pl-0 pr-8 font-semibold md:table-cell lg:pr-20">
                            <div class="flex cursor-pointer">
                                Zimmer
                                <svg data-v-2059301d="" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path data-v-2059301d="" d="M8 9L12 5L16 9" stroke="black" stroke-width="1.5"></path> <path data-v-2059301d="" d="M8 15L12 19L16 15" stroke="black" stroke-width="1.5"></path></svg>
                            </div>
                        </th>
                        <th scope="col" wire:click="sortBy('wohnflaeche')" class="hidden py-2 pl-0 text-left font-semibold sm:table-cell sm:pr-6 lg:pr-8">
                            <div class="flex cursor-pointer">
                                Fläche
                                <svg data-v-2059301d="" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path data-v-2059301d="" d="M8 9L12 5L16 9" stroke="black" stroke-width="1.5"></path> <path data-v-2059301d="" d="M8 15L12 19L16 15" stroke="black" stroke-width="1.5"></path></svg>
                            </div>
                        </th>
                        <th scope="col" wire:click="sortBy('kaufpreis')" class="py-2 pl-0 pr-4 text-right font-semibold sm:table-cell sm:pr-6 lg:pr-8">
                            <div class="flex cursor-pointer">
                                Preis
                                <svg data-v-2059301d="" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path data-v-2059301d="" d="M8 9L12 5L16 9" stroke="black" stroke-width="1.5"></path> <path data-v-2059301d="" d="M8 15L12 19L16 15" stroke="black" stroke-width="1.5"></path></svg>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-900/5">
                    @foreach($subestates as $subestate)
                        <tr class="cursor-pointer bg-gray-100 hover:bg-gray-50">
                            <td class="py-4 pl-4 pr-8 sm:pl-6 lg:pl-8">
                                <a href="/immobilien/details/{{$subestate['elements']['Id']}}" class="flex items-center gap-x-4">
                                <div class="truncate text-sm font-medium leading-6 text-gray-900">{{$subestate['elements']['Id']}}</div>
                                </a>
                            </td>
                            <td class="py-4 pl-0 pr-4 sm:table-cell sm:pr-8">
                                <a href="/immobilien/details/{{$subestate['elements']['Id']}}" class="flex gap-x-3">
                                    <div class="font-mono text-sm leading-6 text-gray-900 uppercase">{{$subestate['elements']['objektart']}}</div>
                                </a>
                            </td>
                            <td class="py-4 pl-0 pr-4 text-sm leading-6 sm:pr-8 lg:pr-20">
                                <a href="/immobilien/details/{{$subestate['elements']['Id']}}">
                                    <div class="flex items-center justify-end gap-x-2 sm:justify-start">
                                        <div class="font-mono text-sm leading-6 text-gray-900">{{$subestate['elements']['etagen_zahl']}}</div>
                                    </div>
                                </a>
                            </td>
                            <td class="hidden py-4 pl-0 pr-8 text-sm leading-6 text-gray-900 md:table-cell lg:pr-20">
                                <a href="/immobilien/details/{{$subestate['elements']['Id']}}">
                                    {{$subestate['elements']['anzahl_zimmer']}}
                                </a>
                            </td>
                            <td class="hidden py-4 pl-0 pr-8 text-sm leading-6 text-gray-900 md:table-cell lg:pr-20">
                                <a href="/immobilien/details/{{$subestate['elements']['Id']}}">
                                    {{$subestate['elements']['wohnflaeche']}} m²
                                </a>
                            </td>
                            <td class="hidden py-4 pl-0 pr-4 text-right text-sm leading-6 text-gray-900 sm:table-cell sm:pr-6 lg:pr-8">
                                <a href="/immobilien/details/{{$subestate['elements']['Id']}}">
                                    @if($subestate['elements']['vermarktungsart'] == 'kauf')
                                        @if($subestate['elements']['kaufpreis'] > 0)
                                            {{number_format($subestate['elements']['kaufpreis'], 2, ',', '.')}} €
                                        @else
                                            Preis auf Anfrage
                                        @endif
                                    @else
                                        @if($subestate['elements']['warmmiete'] > 0)
                                            {{number_format($subestate['elements']['warmmiete'], 2, ',', '.')}} €
                                        @else
                                            Preis auf Anfrage
                                        @endif
                                    @endif
                                </a>
                            </td>
                            <td class="py-4 pl-0 pr-4 text-right text-sm leading-6 text-gray-900 sm:table-cell sm:pr-6 lg:pr-8">
                                @if(isset($subestate['elements']["images"][0]))
                                    <a class="flex px-2 py-2 text-gray-900" @click="openModal = true; imageUrl = '{{ $subestate['elements']["images"][0]["url"]}}'">
                                        Grundriss ansehen
                                        <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <x-floorplan-modal />
    </div>
</div>
