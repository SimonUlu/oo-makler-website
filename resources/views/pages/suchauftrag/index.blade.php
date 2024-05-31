@extends('layout')

@section('blade_content')
    <div class="relative w-full bg-primary-100">
        <div class="md:absolute md:inset-0">
            <div class="md:absolute md:inset-y-0 md:right-0 md:w-1/2">
                <img class="object-cover w-full h-56 lg:absolute lg:h-full"
                    src="https://images.pexels.com/photos/4050312/pexels-photo-4050312.jpeg?auto=compress&cs=tinysrgb&w=1600"
                    alt="Platzhalter Bild">
            </div>
        </div>
        <div class="relative px-6 py-16 sm:py-24 md:grid md:grid-cols-2 md:py-32 md:px-8 md:mx-auto md:max-w-7xl">
            <div class="md:pr-8">
                <div class="max-w-md mx-auto sm:max-w-lg md:mx-0">
                    @if (session('success'))
                        <div class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded"
                            role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Zu Ihrem Suchauftrag</h2>
                    <p class="mt-4 text-lg text-gray-500 sm:mt-3">Interessieren Sie sich für eine Immobilie die derzeit
                        nicht in unserem Angebot ist, dann erstellen Sie gerne einen ganz persönlichen Suchauftrag.</p>
                    <form action="{{ route('suchauftrag.send') }}" method="POST">
                        @csrf
                        <!-- TODO refactor to component -->
                        <fieldset id="address" class="grid grid-cols-1 gap-y-6 mt-9 sm:grid-cols-2 sm:gap-x-8">
                            <legend>Kontaktdaten:</legend>
                            <div class="sm:col-span-2">
                                <x-elements.select name="salutation" label="Anrede" :options="['Herr' => 'Herr', 'Frau' => 'Frau']" :required="true" />
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
                            <div class="sm:col-span-2">
                                <x-elements.input name="email" label="Email" :required="true" />
                            </div>
                            <div>
                                <x-elements.input name="phone" label="Telefonnummer" :required="true" />
                            </div>

                        </fieldset>
                        <fieldset id="estate" class="grid grid-cols-1 gap-y-6 mt-9 sm:grid-cols-2 sm:gap-x-8">
                            <legend>Objektdaten:</legend>
                            <div class="sm:col-span-2">
                                <x-elements.select name="objektart" label="Objektart" :options="['objektart' => 'Objektart', 'haus' => 'Haus', 'wohnung' => 'Wohnung']" />
                            </div>
                            @if(!is_null($minRooms))
                                <div>
                                    <x-elements.input value="von" name="von" label="Anzahl Zimmer von" placeholder="{{$minRooms}}" />
                                </div>
                            @else
                                <div>
                                    <x-elements.input value="von" name="von" label="Anzahl Zimmer von" placeholder="von" />
                                </div>
                            @endif
                            @if(!is_null($maxRooms))
                                <div>
                                    <x-elements.input value="bis" name="bis" label="Anzahl Zimmer bis" placeholder="{{$maxRooms}}" />
                                </div>
                            @else
                                <div>
                                    <x-elements.input value="bis" name="bis" label="Anzahl Zimmer bis" placeholder="bis" />
                                </div>
                            @endif

                            <div>
                                <x-elements.input name="wohnflaeche__von" label="Wohnfläche von" placeholder="von" />
                            </div>
                            <div>
                                <x-elements.input name="wohnflaeche__bis" label="Wohnfläche bis" placeholder="bis" />
                            </div>

                            @if(!is_null($minPrice))
                                <div>
                                    <x-elements.input name="kaufpreis__von" label="Kaufpreis von" placeholder="{{$minPrice}}" />
                                </div>
                            @else
                                <div>
                                    <x-elements.input name="kaufpreis__von" label="Kaufpreis von" placeholder="von" />
                                </div>
                            @endif
                            @if(!is_null($maxPrice))
                                <div>
                                    <x-elements.input name="kaufpreis__bis" label="Kaufpreis bis" placeholder="{{$maxPrice}}" />
                                </div>
                            @else
                                <div>
                                    <x-elements.input name="kaufpreis__bis" label="Kaufpreis bis" placeholder="bis" />
                                </div>
                            @endif
                            @if ($vermarktungsart == "miete")
                                <div class="sm:col-span-2">
                                    <x-elements.select name="vermarktungsart" label="Vermarktungsart" :options="[ 'miete' => 'Miete', 'kauf' => 'Kauf']" />
                                </div>
                            @elseif($vermarktungsart == "kauf")
                                <div class="sm:col-span-2">
                                    <x-elements.select name="vermarktungsart" label="Vermarktungsart" :options="[  'kauf' => 'Kauf', 'miete' => 'Miete',]" />
                                </div>
                            @else
                                <div class="sm:col-span-2">
                                    <x-elements.select name="vermarktungsart" label="Vermarktungsart" :options="[ 'vermarktungsart' => 'Vermarktungsart', 'kauf' => 'Kauf', 'miete' => 'Miete',]" />
                                </div>
                            @endif
                            <div class="sm:col-span-2">
                                <x-elements.textarea name="message" label="Ihre Nachricht" />
                            </div>
                            <div>
                                <x-elements.input name="range_plz" label="PLZ" />
                            </div>
                            <div>
                                <x-elements.input name="range_ort" label="Ort" />
                            </div>
                            {{-- <div>
                                <x-elements.input name="vicinity" label="Umkreis (km)" />
                            </div> --}}
                        </fieldset>
                        <fieldset class="grid grid-cols-1 gap-y-6 mt-9 sm:grid-cols-2 sm:gap-x-8">
                            <legend>Datenschutz:</legend>
                            <div class="divide-y divide-gray-200 sm:col-span-2">
                                <x-elements.checkbox-with-text name="widerruf">Ich bin mit einer Kontaktaufnahme bezüglich
                                    meiner Anfrage einverstanden. Die Einverständniserklärung kann ich jederzeit widerrufen.
                                </x-elements.checkbox-with-text>
                                <x-elements.checkbox-with-text name="datenschutz">Ich willige in die Verarbeitung meiner
                                    Daten zum Zweck der Bearbeitung meiner Anfrage ein und habe die Datenschutzerklärung
                                    gelesen.</x-elements.checkbox-with-text>
                            </div>
                        </fieldset>
                        <div class="text-right sm:col-span-2">
                            <x-elements.button type="submit">Absenden</x-elements.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
