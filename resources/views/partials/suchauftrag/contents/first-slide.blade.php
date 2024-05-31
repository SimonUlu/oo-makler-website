<div class="grid gap-5 pt-8 my-6 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <x-elements.select name="objektart" label="Objektart" :options="['objektart' => 'Objektart', 'haus' => 'Haus', 'wohnung' => 'Wohnung']" />
    </div>
    @if (!is_null($minRooms))
        <div>
            <x-elements.input value="von" name="von" label="Anzahl Zimmer von" placeholder="{{ $minRooms }}" />
        </div>
    @else
        <div>
            <x-elements.input value="von" name="von" label="Anzahl Zimmer von" placeholder="von" />
        </div>
    @endif
    @if (!is_null($maxRooms))
        <div>
            <x-elements.input value="bis" name="bis" label="Anzahl Zimmer bis"
                placeholder="{{ $maxRooms }}" />
        </div>
    @else
        <div>
            <x-elements.input value="bis" name="bis" label="Anzahl Zimmer bis" placeholder="bis" />
        </div>
    @endif

    <div>
        <x-elements.input name="wohnflaeche__von" label="Wohnfläche von" placeholder="von" />
    </div>
    <div>
        <x-elements.input name="wohnflaeche__bis" label="Wohnfläche bis" placeholder="bis" />
    </div>
    @if (!is_null($minPrice))
        <div>
            <x-elements.input name="kaufpreis__von" label="Kaufpreis von" placeholder="{{ $minPrice }}" />
        </div>
    @else
        <div>
            <x-elements.input name="kaufpreis__von" label="Kaufpreis von" placeholder="von" />
        </div>
    @endif
    @if (!is_null($maxPrice))
        <div>
            <x-elements.input name="kaufpreis__bis" label="Kaufpreis bis" placeholder="{{ $maxPrice }}" />
        </div>
    @else
        <div>
            <x-elements.input name="kaufpreis__bis" label="Kaufpreis bis" placeholder="bis" />
        </div>
    @endif
    @if ($vermarktungsart == 'miete')
        <div class="sm:col-span-2">
            <x-elements.select name="vermarktungsart" label="Vermarktungsart" :options="['miete' => 'Miete', 'kauf' => 'Kauf']" />
        </div>
    @elseif($vermarktungsart == 'kauf')
        <div class="sm:col-span-2">
            <x-elements.select name="vermarktungsart" label="Vermarktungsart" :options="['kauf' => 'Kauf', 'miete' => 'Miete']" />
        </div>
    @else
        <div class="sm:col-span-2">
            <x-elements.select name="vermarktungsart" label="Vermarktungsart" :options="['vermarktungsart' => 'Vermarktungsart', 'kauf' => 'Kauf', 'miete' => 'Miete']" />
        </div>
    @endif
    <div>
        <x-elements.input name="range_plz" label="PLZ" />
    </div>
    <div>
        <x-elements.input name="range_ort" label="Ort" />
    </div>
</div>
<div class="flex space-x-3">
    <button
        class="flex items-center justify-center w-full px-5 py-1 text-sm font-medium text-center text-gray-900 bg-white border border-gray-200 rounded-lg cursor-no-drop focus:outline-none focus:ring-4 focus:ring-primary-300 sm:py-2 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
        disabled>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
        </svg>
        Zurück
    </button>
    <button x-on:click="showSlide = 2"
        class="flex items-center justify-center w-full px-5 py-1 text-sm font-medium text-center text-white rounded-lg bg-primary-600 hover:bg-primary-700 focus:ring-4 sm:py-- focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
        <span class="mr-2">Ihre Kontaktdetails</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
        </svg>
    </button>

</div>
