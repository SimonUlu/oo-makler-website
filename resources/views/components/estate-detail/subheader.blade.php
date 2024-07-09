@php
    $showStreet = Statamic\Facades\GlobalSet::find('estate_filter_configuration')->in('default')->get('show_address_street') == "yes";
@endphp

@if(!empty($estate['ort']) || !empty($estate['strasse']))
    <div
        class="h-[80px] border-t border-l border-r border-b border-gray-200 md:py-2 inline-flex items-center gap-x-4 pl-4 rounded-l-lg">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
             class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
        </svg>
        <div>
            @if(!empty($estate['ort']))
                <p class="font-medium"> {{ $estate['ort'] }} </p>
            @endif
            @if(!empty($estate['strasse']) && $showStreet)
                <p class="text-sm"> {{ $estate['strasse'] }} </p>
            @endif
        </div>
    </div>
@endif

@if(!empty($estate['anzahl_zimmer']) && $estate['anzahl_zimmer'] != 0)
    <div class="h-[80px] border-t border-r border-b border-gray-200 md:py-2 inline-flex items-center gap-x-4 pl-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
             class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819"/>
        </svg>
        <div>
            <p class="font-medium"> Zimmer </p>
            <p class="text-sm"> {{ round($estate['anzahl_zimmer']) }} </p>
        </div>
    </div>
@endif

@if(!empty($estate['wohnflaeche']) && $estate['wohnflaeche'] != 0.00)
    <div class="h-[80px] border-t border-r border-b border-gray-200 md:py-2 inline-flex items-center gap-x-4 pl-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
             class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M21 7.5l-2.25-1.313M21 7.5v2.25m0-2.25l-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3l2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75l2.25-1.313M12 21.75V19.5m0 2.25l-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25"/>
        </svg>
        <div>
            <p class="font-medium"> Wohnfläche </p>
            <p class="text-sm"> {{ $estate['wohnflaeche'] }} qm </p>
        </div>
    </div>
@endif

@if(!empty($estate['vermarktungsart']) && ($estate['warmmiete'] > 0.0 || $estate['kaltmiete'] > 0.0 || $estate['kaufpreis'] > 0.0))
    <div class="h-[80px] border-t border-r border-b border-gray-200 md:py-2 inline-flex items-center gap-x-4 pl-4 rounded-r-lg">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
             class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M14.25 7.756a4.5 4.5 0 100 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            @if ($estate['vermarktungsart'] == 'miete')
                @if($estate['warmmiete'] > 0.0)
                    <p class="font-medium"> Warmmiete </p>
                    <p class="text-sm">
                        {{ number_format($estate['warmmiete'], 0, ',', '.') }}
                        €
                    </p>
                @elseif ($estate['kaltmiete'] > 0.0)
                    <p class="font-medium"> Kaltmiete </p>
                    <p class="text-sm">
                        {{ number_format($estate['kaltmiete'], 0, ',', '.') }}
                        €
                    </p>
                @else
                    <p class="font-medium"> Miete </p>
                    <p class="text-sm">
                        Preis auf Anfrage
                    </p>
                @endif
            @else
                <p class="font-medium"> Kaufpreis </p>
                <p class="text-sm">
                    {{ number_format($estate['kaufpreis'], 0, ',', '.') }}
                    €
                </p>
            @endif
            <p class="font-normal text-sm">zzgl. Provision</p>
        </div>
    </div>
@endif
