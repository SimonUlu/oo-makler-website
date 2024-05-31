<div>
    <div class="pt-16 pb-0 bg-white sm:py-24">

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded"
                    role="alert">
                    <strong class="font-bold">Vielen Dank für Ihre Einsendung!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div
                class="relative flex flex-col gap-10 px-6 py-24 mt-4 overflow-hidden sm:shadow-2xl bg-primary isolate sm:rounded-3xl sm:px-24 xl:flex-row xl:items-center xl:py-32">
                <h2
                    class="text-3xl font-bold tracking-tight text-white max-w-screen-2xl sm:text-4xl xl:max-w-none xl:flex-auto">
                    Melden Sie sich für unseren Newsletter an
                </h2>

                <div class="grid grid-cols-1">
                    <form wire:submit.prevent="submitForm">
                        <div class="flex gap-x-4">
                            <label for="email-address" class="sr-only">E-Mail Adresse</label>
                            <input id="email-address" name="email" type="email" autocomplete="email" required
                                wire:model.defer="form.email" required
                                class="min-w-0 flex-auto rounded-md border-0 bg-white/5 px-3.5 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-white sm:text-sm sm:leading-6"
                                placeholder="Geben Sie Ihre E-Mail-Adresse ein" />
                            <button type="submit"
                                class="flex-none rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                                Anmelden
                            </button>
                        </div>

                        @error('form.email')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </form>

                    <div>
                        <p class="mt-4 text-sm leading-6 text-gray-200">
                            Wir legen Wert auf den Schutz Ihrer Daten.
                            <a href="/datenschutz"
                                class="font-medium text-gray-300 hover:underline dark:text-primary-500">Lesen Sie unsere
                                Datenschutzerklärung</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
