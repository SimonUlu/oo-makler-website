<div>
    <div class="flex items-center justify-center">
        <ol x-show="showSlide == 1"
            class="flex items-center mb-6 text-sm font-medium text-center text-gray-500 dark:text-gray-400 lg:mb-12 sm:text-base">
            @if ($currentStep == 1)
                @include('partials.suchauftrag.headlines.first-slide')
            @endif
        </ol>
        <ol x-show="showSlide == 2"
            class="flex items-center mb-6 text-sm font-medium text-center text-gray-500 dark:text-gray-400 lg:mb-12 sm:text-base">
            @if ($currentStep == 2)
                @include('partials.suchauftrag.headlines.second-slide')
            @endif
        </ol>
        <ol x-show="showSlide == 3"
            class="flex items-center mb-6 text-sm font-medium text-center text-gray-500 dark:text-gray-400 lg:mb-12 sm:text-base">
            @if ($currentStep == 3)
                @include('partials.suchauftrag.headlines.third-slide')
            @endif
        </ol>
    </div>

    <div>
        <div class="flex items-center justify-center py-2">
            <h2 class="mb-4 text-2xl font-extrabold tracking-tight text-gray-900 sm:mb-6 leding-tight dark:text-white">
                @if ($currentStep == 1)
                    Wie stellen Sie sich Ihre Immobilie vor?
                @elseif($currentStep == 2)
                    Ihre Kontaktdetails
                @elseif($currentStep == 3)
                    Bestätigung
                @endif
            </h2>
        </div>

        <div>
            @if ($currentStep == 1)
                <form wire:submit.prevent>
                    <div class="grid grid-cols-2 mt-4 gap-x-2">
                        <div>
                            <select
{{--                                wire:model.derfer='form.objektart'--}}
                                class='block w-full py-3 pl-3 pr-10 mt-1 text-base border-gray-300 -md sm:text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none'>
                                <option wire:click="setObjektart(null)" value="">-- Objektart wählen --</option>
                                <option wire:click="setObjektart('haus')" value="haus">Haus</option>
                                <option wire:click="setObjektart('wohnung')" value="wohnung">Wohnung</option>
                                <option wire:click="setObjektart('grundstueck')" value="grundstueck">Grundstück</option>
                            </select>
                            @error('form.objektart')
                                <p class="text-red-600">{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    @if($form['objektart'])
                        <div class="grid grid-cols-2 mt-4 gap-x-2">
                            <div class="mt-auto">
                                <x-elements.input wire:model.defer="form.plz_start_from" value="plz_start_from"
                                                  name="plz_start_from" label="Postleitzahl in der Sie suchen"
                                                  placeholder="Postleitzahl" />
                            </div>
                            <div class="mt-auto">
                                <x-elements.input wire:model.defer="form.plz_range" value="plz_range" name="plz_range"
                                                  label="Umkreis Ihrer Suche in km (ausgehend von der Plz)" placeholder="z.B. 35" />
                            </div>
                        </div>
                        @if($form['objektart']=='haus'||$form['objektart']=='wohnung')
                            <!-- Full Row for Anzahl Zimmer von and bis -->
                            <div class="grid grid-cols-2 mt-4 gap-x-2">
                                <div>
                                    <x-elements.input wire:model.defer="form.anzahl_zimmer__von" value="anzahl_zimmer__von"
                                                      name="anzahl_zimmer__von" label="Anzahl Zimmer von" placeholder="Anzahl Zimmer von" />
                                </div>
                                <div>
                                    <x-elements.input wire:model.defer="form.anzahl_zimmer__bis" value="anzahl_zimmer__bis"
                                                      name="anzahl_zimmer__bis" label="Anzahl Zimmer bis" placeholder="Anzahl Zimmer bis" />
                                </div>
                            </div>

                            <!-- Full Row for Wohnfläche von and bis -->
                            <div class="grid grid-cols-2 mt-4 gap-x-2">
                                <div>
                                    <x-elements.input wire:model.defer="form.wohnflaeche__von" value="wohnflaeche__von"
                                                      name="wohnflaeche__von" label="Wohnfläche von" placeholder="Wohnfläche von"  required/>
                                </div>
                                <div>
                                    <x-elements.input wire:model.defer="form.wohnflaeche__bis" value="wohnflaeche__bis"
                                                      name="wohnflaeche__bis" label="Wohnfläche bis" placeholder="Wohnfläche bis" required />
                                </div>
                            </div>
                        @endif
                        <!-- Full Row for Kaufpreis von and bis -->
                        <div class="grid grid-cols-2 mt-4 gap-x-2">
                            <div>
                                <x-elements.input wire:model.defer="form.kaufpreis__von" value="kaufpreis__von"
                                                  name="kaufpreis__von" label="Kaufpreis von" placeholder="Kaufpreis von" />
                            </div>
                            <div>
                                <x-elements.input wire:model.defer="form.kaufpreis__bis" value="kaufpreis__bis"
                                                  name="kaufpreis__bis" label="Kaufpreis bis" placeholder="Kaufpreis bis" />
                            </div>
                        </div>

                        @if($form['objektart']=='grundstueck')
                            <!-- Full Row for Grunstückfläche von and bis -->
                            <div class="grid grid-cols-2 mt-4 gap-x-2">
                                <div>
                                    <x-elements.input wire:model.defer="form.grundstucksflaeche__von" value="grundstucksflaeche__von"
                                                      name="grundstucksflaeche__von" label="Grudnstücksfläche von" placeholder="Grudnstücksfläche von"  required/>
                                </div>
                                <div>
                                    <x-elements.input wire:model.defer="form.grundstucksflaeche__bis" value="grundstucksflaeche__bis"
                                                      name="grundstucksflaeche__bis" label="Grudnstücksfläche bis" placeholder="Grudnstücksfläche bis" required />
                                </div>
                            </div>
                        @endif
                        <!-- Include more fields as necessary -->

                        <div class="grid grid-cols-2 mt-4 gap-x-2">
                            <button
                                disabled
                                class="flex items-center justify-center w-full px-5 py-1 text-sm font-medium text-center text-gray-900 bg-white border border-gray-200 -lg cursor-no-drop focus:outline-none focus:ring-4 focus:ring-primary-300 sm:py-2 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                                </svg>
                                Zurück
                            </button>
                            <button type="submit"
                                    wire:click="incrementStep"
                                    class="flex items-center justify-center w-full px-5 py-1 text-sm font-medium text-center text-white bg-primary hover:bg-primary-700 focus:ring-4 sm:py-- focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                <span class="mr-2">Ihre Kontaktdetails</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </form>
            @endif

            @if ($currentStep == 2)
                <form wire:submit.prevent>
                    <div class="grid grid-cols-2 mt-4 gap-x-2">
                        <div>
                            <x-elements.input wire:model.defer="form.firstname" value="firstname" name="firstname"
                                label="Vorname" placeholder="Vorname" />
                        </div>

                        <div>
                            <x-elements.input wire:model.defer="form.lastname" value="lastname" name="lastname"
                                label="Lastname" placeholder="Nachname" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-elements.input wire:model.defer="form.email" value="email" name="email" label="Email"
                            placeholder="E-Mail" />
                    </div>

                    <div class="grid grid-cols-2 mt-4 gap-x-2">
                        <button
                            class="flex items-center justify-center w-full px-5 py-1 text-sm font-medium text-center text-gray-900 bg-white border border-gray-200 -lg cursor-no-drop focus:outline-none focus:ring-4 focus:ring-primary-300 sm:py-2 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                            wire:click="back">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                            </svg>
                            Zurück
                        </button>
                        <button type="submit"
                                wire:click="incrementStep"
                            class="flex items-center justify-center w-full px-5 py-1 text-sm font-medium text-center text-white -lg bg-primary hover:bg-primary-700 focus:ring-4 sm:py-- focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            <span class="mr-2">Ihre Nachricht</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>
                </form>
            @endif

            @if ($currentStep == 3)
                <form wire:submit.prevent>
                    <div class="sm:col-span-2">
                        <x-elements.textarea name="message" label="Ihre Nachricht" />
                    </div>
                    <x-elements.checkbox-with-text name="kontaktaufnahme">Ich bin mit einer Kontaktaufnahme bezüglich
                        meiner Anfrage einverstanden. Die Einverständniserklärung kann ich jederzeit widerrufen.
                    </x-elements.checkbox-with-text>
                    <x-elements.checkbox-with-text name="datenschutz">Ich willige in die Verarbeitung meiner
                        Daten zum Zweck der Bearbeitung meiner Anfrage ein und habe die Datenschutzerklärung
                        gelesen.</x-elements.checkbox-with-text>

                    <div class="grid grid-cols-2 mt-4 gap-x-2">
                        <button
                            class="flex items-center justify-center w-full px-5 py-1 text-sm font-medium text-center text-gray-900 bg-white border border-gray-200 -lg cursor-no-drop focus:outline-none focus:ring-4 focus:ring-primary-300 sm:py-2 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                            wire:click="back"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                            </svg>
                            Zurück
                        </button>
                        <button type="submit" wire:click="submit"
                            class="flex items-center justify-center w-full px-5 py-1 text-sm font-medium text-center text-white -lg bg-primary hover:bg-primary-700 focus:ring-4 sm:py-- focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            <span class="mr-2">Absenden</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>
                </form>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endif

            <!-- A simple transition when changing steps -->
            <script>
                Livewire.on('stepChanged', step => {
                    // Transition code, you can use libraries like Alpine.js, jQuery, or write pure JS.
                });
            </script>
        </div>
    </div>
</div>
