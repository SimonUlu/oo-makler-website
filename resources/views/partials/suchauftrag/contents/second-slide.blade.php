<div class="grid gap-5 my-6 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <x-elements.select name="salutation" label="Anrede" :options="['Bitte wählen', 'Frau' => 'Frau', 'Herr' => 'Herr']" :required="true" />
    </div>
    <div>
        <x-elements.input name="firstname" label="Vorname" :required="true" />
    </div>
    <div>
        <x-elements.input name="lastname" label="Nachname" :required="true" />
    </div>
    <div class="sm:col-span-2">
        <x-elements.input name="street" label="Straße" :required="true" />
    </div>
    <div>
        <x-elements.input name="postalcode" label="PLZ" :required="true" />
    </div>
    <div>
        <x-elements.input name="location" label="Ort" :required="true" />
    </div>
    <div>
        <x-elements.input name="email" label="Email" :required="true" />
    </div>
    <div>
        <x-elements.input name="phone" label="Telefonnummer" :required="true" />
    </div>
</div>
<div class="flex space-x-3">
    <button x-on:click="showSlide = 1"
        class="flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:ring-4 focus:ring-primary-300 sm:py-2 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
        </svg>
        Ihre Suchparameter
    </button>
    <button x-on:click="showSlide = 3"
        class="flex items-center justify-center w-full px-5 py-1 text-sm font-medium text-center text-white rounded-lg bg-primary-600 hover:bg-primary-700 focus:ring-4 sm:py-- focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
        Zur Bestätigung
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
        </svg>
    </button>
</div>
