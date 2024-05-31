<div class="pt-3 pl-3 pr-3 border border-gray-200 rounded-lg border-t-none {{ $style }}">
    <div class="pl-3 pr-3 border border-gray-200 md:pt-3 md:rounded-t-lg border-t-none">
        <div class="flex flex-col items-center justify-center hidden sm:flex sm:col-span-2" x-data="{ logoUrl: '/logo_images/logo.png' }">
            <!-- Display user photo if it exists -->
            <div class="mt-4">
                <!-- Display default photo if user photo does not exist -->
                <img class="max-w-[120px] rounded-full" src="/logo_images/logo.png" alt="Ihr Kontakt">
            </div>
            <span class="mt-2 text-sm font-bold text-gray-900 ">
                Ihr Kontakt
            </span>
            <div class="text-center">
                <span class="text-sm text-center">{{ Statamic\Facades\GlobalSet::find('business_information')->in('default')->get('company_name') }}</span>
            </div>

            <a href="tel:{{ Statamic\Facades\GlobalSet::find('business_information')->in('default')->get('company_phone') }}" title="Rufen Sie uns jetzt an!"
                class="inline-flex items-center justify-center px-5 py-2 my-4 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                role="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0l-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 014.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 00-.38 1.21 12.035 12.035 0 007.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 011.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 01-2.25 2.25h-2.25z">
                    </path>
                </svg>
                Direkt anrufen
            </a>
        </div>
    </div>
    @if (session()->has('success'))
        <div class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
            <strong class="font-bold">Vielen Dank für Ihre Einsendung!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <h3 class="pl-2 text-3xl font-bold tracking-tight text-gray-900">
        {{ $title }}
    </h3>
    <form wire:submit.prevent="submitForm">
        <div class="grid px-2 py-4 gap-y-2">
            <div>
                <x-elements.input type="name" wire:model.defer="form.name" name="name" label="Vor- und Nachname"
                    required />
            </div>
            <div>
                <x-elements.input type="address" wire:model.defer="form.address" name="address" label="Anschrift"
                    required />
            </div>
            <div>
                <x-elements.input type="email" wire:model.defer="form.email" name="email" label="Email" />
            </div>
            <div>
                <x-elements.input type="tel" wire:model.defer="form.phone" name="phone" label="Telefonnummer"
                    placeholder="(optional)" />
            </div>
            <div>
                <x-elements.textarea wire:model.defer="form.message" name="message" label="Nachricht">Ich bin an dieser
                    Immobilie
                    interessiert.</x-elements.textarea>
            </div>

            <button type="submit" class="px-4 py-2 text-white rounded bg-primary-600 focus:outline-none">
                Absenden
            </button>
            <div class="text-sm font-medium text-gray-700">
                <x-elements.checkbox-with-text name="widerruf">Ich bin mit der <a href="/datenschutz"
                    class="text-sm font-medium text-gray-900 underline">Datenschutzerklärung</a>
                und mit der Verarbeitung meiner Daten zur Kontaktaufnahme einverstanden.
            </x-elements.checkbox-with-text>
            </div>
        </div>
    </form>
</div>
