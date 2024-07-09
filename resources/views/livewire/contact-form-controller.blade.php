@php
    $logoUrl = asset('logo_images/logo.png');
@endphp

<div class="pt-3 pr-3 pl-3 -lg border border-gray-200 border-t-none">
    <div class="flex flex-col justify-center items-center sm:flex sm:col-span-2" x-data="{ logoUrl: '{{ $logoUrl }}' }">
        <!-- Display user photo if it exists -->
        <div class="mt-4">
            @if (isset($estate['userPhoto']))
                <img class="-full max-w-[120px]" src="data:image/jpeg;base64, {{ $estate['userPhoto'] }}"
                    alt="Ihr Kontakt">
            @else
                <!-- Display default photo if user photo does not exist -->
                <img class="max-w-[120px]" height="auto" src="{{ $logoUrl }}" alt="Ihr Kontakt">
            @endif
        </div>
        <span class="mt-2 text-sm font-bold text-gray-900">
            Ihr Kontakt</span>
        @if (isset($estate['userPhoto']))
            <div class="text-center">
                <span class="text-sm">{{ $estate['Vorname'] }}</span>
                <span class="text-sm">{{ $estate['Nachname'] }}</span>
            </div>

            <a href="tel:{{ Statamic\Facades\GlobalSet::find('business_information')->in('default')->get('company_phone') }}"
                title="Rufen Sie uns jetzt an!"
                class="inline-flex justify-center items-center py-2 px-5 my-4 text-sm font-medium text-gray-900 bg-white -lg border border-gray-200 dark:text-gray-400 dark:border-gray-600 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 focus:outline-none dark:focus:ring-gray-700 dark:hover:text-white dark:hover:bg-gray-700 hover:text-primary-700"
                role="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="mr-2 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0l-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 014.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 00-.38 1.21 12.035 12.035 0 007.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 011.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 01-2.25 2.25h-2.25z" />
                </svg>
                Direkt anrufen
            </a>
        @else
            <div class="text-center">
                <span
                    class="text-sm text-center">{{ Statamic\Facades\GlobalSet::find('business_information')->in('default')->get('company_name') }}</span>
            </div>

            <a href="tel:{{ Statamic\Facades\GlobalSet::find('business_information')->in('default')->get('company_phone') }}"
                title="Rufen Sie uns jetzt an!"
                class="inline-flex justify-center items-center py-2 px-5 my-4 text-sm font-medium text-gray-900 bg-white -lg border border-gray-200 dark:text-gray-400 dark:border-gray-600 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 focus:outline-none dark:focus:ring-gray-700 dark:hover:text-white dark:hover:bg-gray-700 hover:text-primary-700"
                role="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="mr-2 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0l-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 014.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 00-.38 1.21 12.035 12.035 0 007.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 011.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 01-2.25 2.25h-2.25z" />
                </svg>
                Direkt anrufen
            </a>
        @endif
    </div>


    @if (session('success'))
        <div class="relative py-3 px-4 text-green-700 bg-green-100  border border-green-400" role="alert">
            <strong class="font-bold">Vielen Dank für Ihre Einsendung!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif


    <form wire:submit.prevent="submitForm">
        <div class="grid gap-y-2 py-4 px-2">
            <div>
                <x-elements.input type="name" id="nameInput" wire:model.defer="form.name" name="name"
                    label="Vor- und Nachname" required />
            </div>
            <div class="hidden">
                <x-elements.input type="honey" id="honey" wire:model.defer="form.honey" name="honey"
                    label="Feld" />
            </div>
            <div>
                <x-elements.input type="email" wire:model.defer="form.email" name="email" label="Email" />
            </div>
            <div>
                <x-elements.input type="address" wire:model.defer="form.address" name="address" label="Anschrift"
                    placeholder=(optional) />
            </div>
            <div>
                <x-elements.input type="tel" wire:model.defer="form.phone" name="phone" label="Telefonnummer"
                    placeholder="(optional)" />
            </div>
            <div>
                <x-elements.textarea wire:model.defer="form.message" name="message" label="Nachricht">Bitte nehmen Sie
                    Kontakt zu mir auf.</x-elements.textarea>
            </div>

            <button id="sendContact" name="contactSender" type="submit"
                class="py-2 px-4 text-white focus:outline-none bg-primary" wire:loading.attr="disabled">
                Absenden
            </button>
            <div class="text-sm font-medium text-gray-700">
                <div class="flex items-center">
                    <label for="widerruf-{{ $formId }}" class="flex items-center">
                        <input id="widerruf-{{ $formId }}" name="widerruf-{{ $formId }}" type="checkbox"
                            wire:model='form.widerruf'
                            class="mr-2 w-4 h-4 border-gray-300 text-primary-600 focus:ring-primary-600">

                        <p id="widerruf-description" class="text-sm text-gray-500">
                            Ich bin mit der
                            <a href="/datenschutz" class="text-sm font-medium text-gray-900 underline">
                                Datenschutzerklärung
                            </a>
                            und mit der Verarbeitung meiner Daten zur Kontaktaufnahme einverstanden.
                        </p>
                    </label>
                </div>
                @error('form.widerruf')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </form>
</div>
