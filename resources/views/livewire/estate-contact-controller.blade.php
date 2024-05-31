<div class="p-0 md:pt-3 md:pl-3 md:pr-3 border border-gray-200 rounded-lg border-t-none {{ $style }}">
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
                <div class="flex items-center">
                    <label for="widerruf-{{ $formId }}" class="flex items-center">
                        <input id="widerruf-{{ $formId }}" name="widerruf-{{ $formId }}" type="checkbox"
                            wire:model='form.widerruf'
                            class="w-4 h-4 mr-2 border-gray-300 text-primary-600 focus:ring-primary-600">

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
