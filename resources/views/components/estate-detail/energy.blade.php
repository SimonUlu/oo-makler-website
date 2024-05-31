<h2 class="px-4 pt-12 sm:px-6 lg:gap-x-4 pl-2 text-3xl font-bold tracking-tight text-gray-900">
    Energieinformationen </h2>
<div class="grid justify-center grid-cols-2 grid-rows-2 mx-8 sm:justify-between lg:grid-cols-3 mt-4 text-center">
    @if (!empty($estate['elements']['energieausweistyp']))
        <div class="flex flex-col items-center justify-center mt-8 sm:justify-start sm:items-start mb-8">
            <span class="text-lg font-bold text-gray-400 h-fit">Energieausweis</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ ucfirst($estate['elements']['energieausweistyp']) }}
            </div>
        </div>
    @endif
    @if (!empty($estate['elements']['energieverbrauchskennwert']))
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start mb-8 ">
            <span class="text-lg font-bold text-gray-400 h-fit">Endenergieverbrauch</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ $estate['elements']['energieverbrauchskennwert'] }}
            </div>
        </div>
    @endif
    @if (!empty($estate['elements']['energieausweis_gueltig_bis']))
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start mb-8">
            <span class="text-lg font-bold text-gray-400 h-fit">Energieausweis gültig bis</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ $estate['elements']['energieausweis_gueltig_bis'] }}
            </div>
        </div>
    @endif
    @if (!empty($estate['elements']['energietraegere']))
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start mb-8">
            <span class="text-lg font-bold text-gray-400 h-fit">Hauptenergieträger</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ $estate['elements']['energietraeger'] }};
            </div>
        </div>
    @endif
    @if (!empty($estate['elements']['energyClass']))
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start mb-8">
            <span class="text-lg font-bold text-gray-400 h-fit">Energieeffizienzklasse</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ $estate['elements']['energyClass'] }}
            </div>
        </div>
    @endif
    @if (!empty($estate['elements']['energieausweisBaujahr']))
        <div class="flex flex-col items-center justify-center sm:justify-start sm:items-start mb-8">
            <span class="text-lg font-bold text-gray-400 h-fit">Baujahr laut Energieausweis</span>
            <div class="flex text-xl font-extrabold lg:text-xl">
                {{ round($estate['elements']['energieausweisBaujahr']) }}
            </div>
        </div>
    @endif
</div>
