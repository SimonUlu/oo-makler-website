<h2 class="px-4 pt-12 sm:px-6 lg:gap-x-4 pl-2 text-3xl font-bold tracking-tight text-gray-900">
    Immobiliendetails </h2>
<div class="grid justify-center grid-cols-2 grid-rows-2 mx-8 space-y-8 sm:justify-between lg:grid-cols-3 mt-4 text-center">
    @if (!empty($estate['elements']['objekttyp']))
        <div class="flex flex-col items-center justify-center mt-8 sm:justify-start sm:items-start">
            <span class="text-lg font-bold text-gray-400 h-fit">Objekttyp</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ ucfirst($estate['elements']['objekttyp']) }}
            </div>
        </div>
    @endif
    @if (!empty($estate['elements']['plz']))
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start">
            <span class="text-lg font-bold text-gray-400 h-fit">Plz</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ $estate['elements']['plz'] }}
            </div>
        </div>
    @endif
    @if (!empty($estate['elements']['ort']))
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start">
            <span class="text-lg font-bold text-gray-400 h-fit">Ort</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ $estate['elements']['ort'] }}
            </div>
        </div>
    @endif
    @if (!empty($estate['elements']['wohnflaeche']))
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start">
            <span class="text-lg font-bold text-gray-400 h-fit">Wohnfl&auml;che</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ $estate['elements']['wohnflaeche'] }} m&sup2;
            </div>
        </div>
    @endif
    @if (!empty($estate['elements']['anzahl_zimmer']))
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start">
            <span class="text-lg font-bold text-gray-400 h-fit">Zimmer</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ round($estate['elements']['anzahl_zimmer']) }}
            </div>
        </div>
    @endif
    @if (!empty($estate['elements']['anzahl_schlafzimmer']))
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start">
            <span class="text-lg font-bold text-gray-400 h-fit">Schlafzimmer</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ round($estate['elements']['anzahl_schlafzimmer']) }}
            </div>
        </div>
    @endif
    @if (!empty($estate['elements']['anzahl_badezimmer']))
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start">
            <span class="text-lg font-bold text-gray-400 h-fit">Badezimmer</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ round($estate['elements']['anzahl_badezimmer']) }}
            </div>
        </div>
    @endif
    @if (!empty($estate['elements']['heizungsart']))
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start">
            <span class="text-lg font-bold text-gray-400 h-fit">Heizungsart</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                <div class="mt-1 mb-2 font-bold capitalize text-primary-200">
                    @foreach ($estate['elements']['heizungsart'] as $heizungsart)
                        <span>{{ $heizungsart }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    @if (!empty($estate['elements']['stellplatzart']))
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start">
            <span class="text-lg font-bold text-gray-400 h-fit">Stellplatzart</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                <div class="mt-1 mb-2 font-bold capitalize text-primary-200">
                    @foreach ($estate['elements']['stellplatzart'] as $stellplatzart)
                        <span>{{ $stellplatzart }} </span>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
