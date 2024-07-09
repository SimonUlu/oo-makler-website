@php
    $logoUrl = asset('logo_images/logo.png');
@endphp

<div class="pt-3 pr-3 pl-3 rounded-lg border border-gray-200 border-t-none">
    <div class="flex flex-col justify-center items-center sm:flex sm:col-span-2" x-data="{ logoUrl: '{{ $logoUrl }}' }">
        <!-- Display user photo if it exists -->
        <div class="mt-4">
            @if (isset($estate['userPhoto']))
                <img class="rounded-full max-w-[120px]" src="data:image/jpeg;base64, {{ $estate['userPhoto'] }}"
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
                class="inline-flex justify-center items-center py-2 px-5 my-4 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:text-gray-400 dark:border-gray-600 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 focus:outline-none dark:focus:ring-gray-700 dark:hover:text-white dark:hover:bg-gray-700 hover:text-primary-700"
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
                class="inline-flex justify-center items-center py-2 px-5 my-4 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:text-gray-400 dark:border-gray-600 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 focus:outline-none dark:focus:ring-gray-700 dark:hover:text-white dark:hover:bg-gray-700 hover:text-primary-700"
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
        <div class="relative py-3 px-4 text-green-700 bg-green-100 rounded border border-green-400" role="alert">
            <strong class="font-bold">Vielen Dank für Ihre Einsendung!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif


    <form wire:submit.prevent="submitForm">
        <div class="grid gap-y-2 py-4 lg:grid-cols-2 px-4">
            <div class="col-span-2">
                <x-elements.input type="name" id="nameInput" wire:model.defer="form.name" name="name"
                    label="Vor- und Nachname*" required />
            </div>
            <div class="hidden">
                <x-elements.input type="honey" id="honey" wire:model.defer="form.honey" name="honey"
                    label="Feld" />
            </div>
            <div class="mr-2">
                <x-elements.input type="email" wire:model.defer="form.email" name="email" label="Email*" />
            </div>
            <div>
                <x-elements.input type="tel" wire:model.defer="form.phone" name="phone"
                                  label="Telefonnummer*" required />
            </div>
            <div class="lg:col-span-2  py-8" x-data="{selectedTimeSlot: ''}">
                <h4 class="font-bold mb-2"> Wann ist der beste Zeitpunkt für Sie für einen Rückruf? </h4>
                <div class="grid lg:grid-cols-4 lg:space-x-2">
                    @foreach(['Morgens' => '9 - 12 Uhr', 'Nachmittags' => '12 - 16 Uhr', 'Abends' => '16 - 18 Uhr', 'Jederzeit'=>'9 - 18 Uhr'] as $timeSlot => $hours)
                        <div
                            wire:click="selectTimeSlot('{{ $timeSlot }}')"
                            @click="selectedTimeSlot = '{{ $timeSlot }}'"
                            class="relative cursor-pointer rounded-2xl p-8 text-center items-center justify-center flex flex-col shadow-md border-2"
                            :class="{ 'border-primary': selectedTimeSlot === '{{ $timeSlot }}', 'border-transparent': selectedTimeSlot !== '{{ $timeSlot }}' }"
                        >
                            <div x-show="selectedTimeSlot === '{{ $timeSlot }}'" class="absolute top-2 right-2">
                                <svg class="h-5 w-5 text-primary" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div x-show="selectedTimeSlot != '{{ $timeSlot }}'" class="absolute top-2 right-2">
                                <svg class="h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                                  </svg>

                            </div>
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                            </svg>

                            <dl class="mt-3 space-y-1 text-sm leading-6 text-gray-600">
                            <div>
                                <dd>
                                    <div class="font-semibold text-primary text-base">
                                        {{ $timeSlot }}
                                    </div>
                                </dd>
                            </div>
                            <div class="mt-1">
                                <dd>{{ $hours }}</dd>
                            </div>
                            </dl>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="lg:col-span-2">
                <x-elements.textarea wire:model.defer="form.message" name="message" label="Nachricht">Bitte nehmen Sie
                    Kontakt zu mir auf.</x-elements.textarea>
            </div>

            <button id="sendContact" name="contactSender" type="submit"
                class="py-2 px-4 text-white rounded focus:outline-none bg-primary-600 lg:col-span-2" wire:loading.attr="disabled">
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

