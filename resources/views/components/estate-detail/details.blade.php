<div class="grid justify-center grid-cols-2 grid-rows-2 mx-8 space-y-8 sm:justify-between lg:grid-cols-3 mt-4 my-16 ">
    @if (!empty($estate['objekttyp']) && $estate['objekttyp'] != 0)
        <div class="flex flex-col items-center justify-center mt-8 sm:justify-start sm:items-start">
            <span class="text-lg font-bold text-gray-400 h-fit">Objekttyp</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ ucfirst($estate['objekttyp']) }}
            </div>
        </div>
    @endif
    @if (!empty($estate['plz']) && $estate['plz'] != 0)
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start">
            <span class="text-lg font-bold text-gray-400 h-fit">Plz</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ $estate['plz'] }}
            </div>
        </div>
    @endif
    @if (!empty($estate['ort']) && $estate['ort'] != 0)
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start">
            <span class="text-lg font-bold text-gray-400 h-fit">Ort</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ $estate['ort'] }}
            </div>
        </div>
    @endif
    @if (!empty($estate['wohnflaeche']) && $estate['wohnflaeche'] != 0)
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start">
            <span class="text-lg font-bold text-gray-400 h-fit">Wohnfl&auml;che</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ $estate['wohnflaeche'] }} m&sup2;
            </div>
        </div>
    @endif
    @if (!empty($estate['anzahl_zimmer']) && $estate['anzahl_zimmer'] != 0)
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start">
            <span class="text-lg font-bold text-gray-400 h-fit">Zimmer</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ round($estate['anzahl_zimmer']) }}
            </div>
        </div>
    @endif
    @if (!empty($estate['anzahl_schlafzimmer']) && $estate['anzahl_schlafzimmer'] != 0)
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start">
            <span class="text-lg font-bold text-gray-400 h-fit">Schlafzimmer</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ round($estate['anzahl_schlafzimmer']) }}
            </div>
        </div>
    @endif
    @if (!empty($estate['anzahl_badezimmer']) && $estate['anzahl_badezimmer'] != 0)
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start">
            <span class="text-lg font-bold text-gray-400 h-fit">Badezimmer</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ round($estate['anzahl_badezimmer']) }}
            </div>
        </div>
    @endif
    @if (!empty($estate['heizungsart']) && count($estate['heizungsart']) > 0)
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start">
            <span class="text-lg font-bold text-gray-400 h-fit">Heizungsart</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                <div class="mt-1 mb-2 font-bold capitalize text-primary-200">
                    @foreach ($estate['heizungsart'] as $heizungsart)
                        <span>{{ $heizungsart }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    @if (!empty($estate['stellplatzart']) && count($estate['stellplatzart']) > 0)
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start">
            <span class="text-lg font-bold text-gray-400 h-fit">Stellplatzart</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                <div class="mt-1 mb-2 font-bold capitalize text-primary-200">
                    @foreach ($estate['stellplatzart'] as $stellplatzart)
                        <span>{{ $stellplatzart }} </span>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
