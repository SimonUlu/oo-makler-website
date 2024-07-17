<div class="w-full">
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
    <div class="w-full">
        <ol wire:key="step-1" class="w-full items-center mb-6 text-sm font-medium text-center text-gray-500 dark:text-gray-400 lg:mb-12 sm:text-base" style="{{ $currentStep == 1 ? '' : 'display: none;' }}">
            @if ($currentStep == 1)
                <div class="grid gap-5 pt-8 my-6 sm:grid-cols-2">
                    <div class="col-span-2">
                        <label
                            class="block text-sm font-medium text-gray-700">Regionen</label>
                        <div class="mt-1">
                            <x-multi-select-general
                                wire:model.lazy="region"
                                type="search"
                                :multiple="true"
                                class="p-0 border-none"
                                :searchfields="['label','value','city']"
                                :placeholder="'Region'"
                                :options="$regionOptions"
                                :noChoicesText="'Keine Orte bei dem derzeitigen Filter vorhanden'">
                            </x-multi-select-general>
                        </div>
                    </div>
                    <div class="col-span-2">
{{--                        <x-elements.select name="objektart" label="Objektart" :options="['objektart' => 'Objektart', 'haus' => 'Haus', 'wohnung' => 'Wohnung']" />--}}
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700">Art</label>
                            <select
                                class="block w-full py-3 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md sm:text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                                <option wire:click="setObjektart('')" value="">-- Objektart wählen --</option>
                            @foreach($vermarktungsOptions as $value => $label)
                                    <option wire:click="setObjektart('{{$value}}')">{{$label}}</option>
                                @endforeach
{{--                                <option wire:click="setObjektart('haus')" value="haus">Haus</option>--}}
{{--                                <option wire:click="setObjektart('wohnung')" value="wohnung">Wohnung</option>--}}
{{--                                <option wire:click="setObjektart('grundstueck')" value="grundstueck">Grundstück</option>--}}
                            </select>
                            @error('form.objektart')
                            <p class="text-red-600">{{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>
                    @if($form['objektart']=='haus'||$form['objektart']=='wohnung')
                        <div>
                            <x-elements.input value="von" name="anzahl_zimmer__von" label="Anzahl Zimmer von" placeholder="von" />
                        </div>

                        <div>
                            <x-elements.input value="bis" name="anzahl_zimmer__bis" label="Anzahl Zimmer bis" placeholder="bis" />
                        </div>
                        <div>
                            <x-elements.input name="wohnflaeche__von" label="Wohnfläche von" placeholder="von" />
                        </div>
                        <div>
                            <x-elements.input name="wohnflaeche__bis" label="Wohnfläche bis" placeholder="bis" />
                        </div>
                    @endif
                    @if($form['objektart'])
                        <div>
                            <x-elements.input name="kaufpreis__von" label="Kaufpreis von" placeholder="von" />
                        </div>

                        <div>
                            <x-elements.input name="kaufpreis__bis" label="Kaufpreis bis" placeholder="bis" />
                        </div>
                    @endif
                    @if($form['objektart']=='grundstueck')
                        <!-- Full Row for Grunstückfläche von and bis -->
                        <div>
                            <x-elements.input name="grundstuecksflaeche__von" label="Grundstücksfläche von" placeholder="Grundstücksfläche von" />
                        </div>
                        <div>
                            <x-elements.input name="grundstuecksflaeche__bis" label="Grundstücksfläche bis" placeholder="Grundstücksfläche bis" />
                        </div>
                    @endif

                    @if(is_null($vermarktungsart))
                        <div class="sm:col-span-2">
                            <x-elements.select name="vermarktungsart" label="Vermarktungsart" :options="[ 'kauf' => 'Kauf', 'miete' => 'Miete']" />
                        </div>
                    @endif
                    @if(!$plz_disable)
                        <div>
                            <x-elements.input name="range_plz" label="PLZ" />
                        </div>
                        <div>
                            <x-elements.input name="range_ort" label="Ort" />
                        </div>
                    @endif
                </div>

            @endif
        </ol>
        <ol wire:key="step-2" class="w-full items-center mb-6 text-sm font-medium text-center text-gray-500 dark:text-gray-400 lg:mb-12 sm:text-base" style="{{ $currentStep == 2 ? '' : 'display: none;' }}">
            @if ($currentStep == 2)
                <div class="grid grid-cols-2 mt-4 gap-x-2">
                    <div>
                        <x-elements.input name="firstname" label="Vorname" />
                    </div>

                    <div>
                        <x-elements.input name="lastname" label="Lastname" />
                    </div>
                </div>
                <div class="mt-4">
                    <x-elements.input name="email" label="Email"/>
                </div>
            @endif
        </ol>
        <ol wire:key="step-3" class="w-full items-center mb-6 text-sm font-medium text-center text-gray-500 dark:text-gray-400 lg:mb-12 sm:text-base" style="{{ $currentStep == 3 ? '' : 'display: none;' }}">
            @if ($currentStep == 3)
                <div class="sm:col-span-2">
                    <x-elements.textarea name="message" label="Ihre Nachricht" />
                </div>
                <div class="divide-y divide-gray-200 sm:col-span-2">
                    <x-elements.checkbox-with-text name="kontaktaufnahme">Ich bin mit einer Kontaktaufnahme bezüglich
                        meiner Anfrage einverstanden. Die Einverständniserklärung kann ich jederzeit widerrufen.
                    </x-elements.checkbox-with-text>
                    <x-elements.checkbox-with-text name="datenschutz">Ich willige in die Verarbeitung meiner
                        Daten zum Zweck der Bearbeitung meiner Anfrage ein und habe die Datenschutzerklärung
                        gelesen.</x-elements.checkbox-with-text>
                </div>
            @endif
        </ol>
    </div>

    <!-- Buttons for Step 1 -->
    @if ($currentStep == 1)
        <div class="grid grid-cols-2 gap-3">
            <button
                class="flex items-center justify-center w-full px-5 py-1 text-sm font-medium text-center text-gray-900 bg-white border border-gray-200 rounded-lg cursor-no-drop focus:outline-none focus:ring-4 focus:ring-primary-300 sm:py-2 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                disabled>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                </svg>
                Zurück
            </button>
            <button wire:click="incrementStep"
                    class="flex items-center justify-center w-full px-5 py-1 text-sm font-medium text-center text-white rounded-lg bg-primary-600 hover:bg-primary-700 focus:ring-4 sm:py-- focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                <span class="mr-2">Ihre Kontaktdetails</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>
    @endif

    <!-- Buttons for Step 2 -->
    @if ($currentStep == 2)
        <div class="grid grid-cols-2 gap-3">
            <button wire:click="decrementStep"
                    class="flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:ring-4 focus:ring-primary-300 sm:py-2 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                </svg>
                Ihre Suchparameter
            </button>
            <button wire:click="incrementStep"
                    class="flex items-center justify-center w-full px-5 py-1 text-sm font-medium text-center text-white rounded-lg bg-primary-600 hover:bg-primary-700 focus:ring-4 sm:py-- focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                Zur Bestätigung
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>
    @endif

    <!-- Buttons for Step 3 -->
    @if ($currentStep == 3)
        <div class="grid grid-cols-2 gap-3">
            <button wire:click="decrementStep"
                    class="w-full flex items-center justify-center text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 py-2 lg:py-1 sm:py-2 font-medium rounded-lg text-sm px-3 md:px-5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                </svg>
                Zu den Immo-Infos
            </button>
{{--            <x-elements.button class="w-full" type="submit" wire:click="submit">--}}
{{--                Absenden--}}
{{--            </x-elements.button>--}}
            <button type="submit" wire:click="submit"
                    class="flex items-center justify-center w-full px-5 py-1 text-sm font-medium text-center text-white -lg bg-primary hover:bg-primary-700 focus:ring-4 sm:py-- focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                <span class="mr-2">Absenden</span>
            </button>
        </div>
    @endif
</div>
