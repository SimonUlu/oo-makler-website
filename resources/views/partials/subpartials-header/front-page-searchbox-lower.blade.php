<div class="relative w-full">
    <h2
        class="mx-auto mt-4 mb-0 font-bold tracking-tight text-center sm:text-xl lg:pl-4 lg:mt-0 lg:mb-4 lg:text-3xl lg:text-left text-l text-secondary">
        Traumimmobilie finden
    </h2>
    <form action="{{ route('immobilien.filtered') }}" method="POST"
        class="grid gap-y-4 p-4 mx-auto mt-2 w-full max-w-5xl rounded-lg sm:mt-8 md:max-w-5xl lg:grid-cols-12 lg:gap-x-4 lg:mt-4 lg:max-w-7xl">
        @csrf
        {{-- <input type="hidden" name="vermarktungsart" value="kauf"> --}}

        <div class="lg:col-span-3" x-data="{ openLocations: false, query: '' }">
            <label for="location-form" class="sr-only">Location</label>
            <div class="relative" x-data="{
                locations: {{ $estateLocations }},
            }">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input name="filter[ort]" @click.outside="openLocations  = false"
                    x-on:input="openLocations = true; query = $event.target.value" type="text" id="location-form"
                    x-bind:value="query"
                    class="block p-2.5 pl-10 w-full text-sm text-gray-900 rounded-lg border border-gray-300 dark:placeholder-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Ort">
                <ul x-show="openLocations && query.length > 0"
                    class="overflow-auto absolute z-10 py-1 mt-1 w-full max-h-60 text-base bg-white rounded-md ring-1 ring-black ring-opacity-5 shadow-lg sm:text-sm focus:outline-none"
                    tabindex="-1" role="listbox" aria-labelledby="listbox-label"
                    aria-activedescendant="listbox-option-3">
                    <template x-for="(location, index) in locations" :key="index">
                        <li x-show="location.toLowerCase().includes(query.toLowerCase())"
                            class="relative py-2 pr-9 pl-3 text-left text-gray-900 cursor-pointer select-none hover:text-white hover:bg-primary"
                            id="listbox-option-0" role="option" @click="query = location; openLocations = false;">
                            <span class="block font-normal truncate" x-text="location"></span>
                        </li>
                    </template>
                    <p x-show="locations.filter(location => location.toLowerCase().includes(query.toLowerCase())).length === 0"
                        class="relative py-2 pr-9 pl-3 text-gray-900 cursor-default select-none">Keine passenden Orte
                        gefunden</p>
                </ul>
            </div>
        </div>
        <div class="lg:col-span-3">
            <label for="objektart" class="sr-only">Object Type</label>
            {{-- Comment it out when you want to use objektart --}}
            <select name="filter[objektart]" id="objektart"
                class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 dark:placeholder-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 focus:ring-primary-500 focus:border-primary-500">
                <option disabled selected>Objektart</option>
                <option>Haus</option>
                <option>Wohnung</option>
            </select>
        </div>
        <div class="lg:col-span-3">
            <label for="vermarktungsart" class="sr-only">Kauf / Miete</label>
            <select name="filter[vermarktungsart]" id="vermarktungsart"
                class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 dark:placeholder-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 focus:ring-primary-500 focus:border-primary-500">
                <option disabled selected>Vermarktungsart</option>
                <option>Kauf</option>
                <option>Miete</option>
            </select>
        </div>
        <button type="submit" id="submitEstateForm"
            class="inline-flex justify-center items-center py-2.5 px-5 w-full text-sm font-medium text-center text-white rounded-lg md:w-auto lg:col-span-3 lg:col-span-12 focus:ring-4 focus:outline-none bg-secondary dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 hover:bg-primary-800 focus:ring-primary-300">
            <svg class="mr-2 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd"></path>
            </svg>
            Suchen
        </button>
    </form>
    

</div>
