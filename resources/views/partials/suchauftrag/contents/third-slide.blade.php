<div class="sm:col-span-2">
    <x-elements.textarea name="message" label="Ihre Nachricht" />
</div>
<div class="divide-y divide-gray-200 sm:col-span-2">
    <x-elements.checkbox-with-text name="widerruf">Ich bin mit einer Kontaktaufnahme bezüglich
        meiner Anfrage einverstanden. Die Einverständniserklärung kann ich jederzeit widerrufen.
    </x-elements.checkbox-with-text>
    <x-elements.checkbox-with-text name="datenschutz">Ich willige in die Verarbeitung meiner
        Daten zum Zweck der Bearbeitung meiner Anfrage ein und habe die Datenschutzerklärung
        gelesen.</x-elements.checkbox-with-text>
</div>
<div class="flex space-x-3 pt-4">
    <button x-on:click="showSlide = 2" class="w-full flex items-center justify-center text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 py-2 lg:py-1 sm:py-2 font-medium rounded-lg text-sm px-3 md:px-5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
        </svg>
        Zu den Immo-Infos
    </button>
    <x-elements.button class="w-full" type="submit">
        Absenden
    </x-elements.button>
</div>
