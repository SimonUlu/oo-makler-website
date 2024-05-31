@php
    $logoUrl = asset('/logo_images/logo.png');
@endphp

<form id="contact-form" action="{{ url('contact-form') }}" method="POST">
    @csrf
    <div class="pt-3 pl-3 pr-3 border border-gray-200 rounded-lg border-t-none">
        @if (session('success'))
            <div class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
                <strong class="font-bold">Vielen Dank für Ihre Einsendung!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <h3 class="pl-2 text-3xl font-bold tracking-tight text-gray-900">
            Fragen Sie diese Immobilie an!</h3>
        <div class="grid px-2 py-4 gap-y-2">
            <div>
                <x-elements.input type="name" name="name" label="Vor- und Nachname" :required="true" />
            </div>
            <div>
                <x-elements.input type="address" name="address" label="Anschrift" :required="true" />
            </div>
            <div>
                <x-elements.input type="email" name="email" label="Email" />
            </div>
            <div>
                <x-elements.input type="tel" name="phone" label="Telefonnummer" placeholder="(optional)" />
            </div>
            <div>
                <x-elements.textarea name="message" label="Nachricht">
                    Ich bin an dieser Immobilie interessiert.
                </x-elements.textarea>
            </div>

            <x-elements.button type="submit">
                Absenden
            </x-elements.button>
            <div class="text-sm font-medium text-gray-700">
                <x-elements.checkbox-with-text name="widerruf">Ich bin mit der <a href="/datenschutz"
                        class="text-sm font-medium text-gray-900 underline">Datenschutzerklärung</a>
                    und mit der Verarbeitung meiner Daten zur Kontaktaufnahme einverstanden.
                </x-elements.checkbox-with-text>
            </div>
        </div>
    </div>
</form>
