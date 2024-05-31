<!-- Header Single Images Image gallery -->
<div class="w-full max-h-screen bg-white">
    <!-- Header -->
    <div class="relative bg-gray-800/75">
        <div class="inset-0">
            <img class='object-cover w-full max-h-screen hover:scale-[1.005] transition-transform duration-1000'
                src="{{ $estate['elements']['images'][0]['url'] ?? asset('img/300x200.png')}}"
                alt="{{ $estate['elements']['images'][0]['title'] }}">
            <div class="inset-0 max-h-screen bg-gray-800/75 mix-blend-multiply" aria-hidden="true"></div>
        </div>
    </div>
</div>
<div class="items-center hidden w-full mb-12 md:grid md:grid-cols-4">
    <div class="h-[80px] border-r border-b border-gray-200 md:py-4 inline-flex gap-x-4 pl-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
        </svg>
        <div>
            <p class="font-medium"> {{ $estate['elements']['ort'] }} </p>
            <p class="text-sm"> {{ $estate['elements']['strasse'] }} </p>
        </div>
    </div>
    <div class="h-[80px] border-r border-b border-gray-200 md:py-4 inline-flex gap-x-4 pl-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819" />
        </svg>
        <div>
            <p class="font-medium"> Zimmer </p>
            <p class="text-sm"> {{ round($estate['anzahl_zimmer']) }} </p>
        </div>
    </div>
    <div class="h-[80px] border-r border-b border-gray-200 md:py-4 inline-flex gap-x-4 pl-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M14.25 7.756a4.5 4.5 0 100 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div>
            <p class="font-medium"> Preis </p>
            @if ($estate['elements']['vermarktungsart'] == 'miete')
                <p class="text-sm">{{ $estate['elements']['warmmiete'] }} Euro</p>
            @else
                <p class="text-sm">{{ $estate['elements']['kaufpreis'] }} Euro </p>
            @endif
        </div>
    </div>
    <div class="h-[80px] border-r border-b border-gray-200 md:py-4 inline-flex gap-x-4 pl-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 7.5l-2.25-1.313M21 7.5v2.25m0-2.25l-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3l2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75l2.25-1.313M12 21.75V19.5m0 2.25l-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25" />
        </svg>
        <div>
            <p class="font-medium"> Wohnfläche </p>
            <p class="text-sm"> {{ $estate['elements']['wohnflaeche'] }} qm </p>
        </div>
    </div>
</div>
