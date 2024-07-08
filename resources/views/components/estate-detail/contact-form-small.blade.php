@php
    $logoUrl = asset('logo_images/logo.png');
@endphp

<div class="pt-3 pl-3 pr-3 border border-gray-200 rounded-t-lg border-t-none">
    <div class="flex flex-col items-center justify-center sm:flex sm:col-span-2" x-data="{ logoUrl: '{{ $logoUrl }}' }">
        <!-- Display user photo if it exists -->
        <div class="border-t border-white/5 py-6 px-4 sm:px-6 lg:px-8 sm:border-l text-center">
            <p class="mt-2 flex items-baseline gap-x-2">
              <span class="text-3xl font-semibold tracking-tight text-gray-900 xl:text-5xl">
                @if ($estate['vermarktungsart'] == 'miete')
                      @if($estate['warmmiete'] > 0.0)
                          <p class="text-base font-medium leading-6 text-gray-400"> Warmmiete </p>
                          <p class="text-3xl font-bold xl:text-4xl">
                            {{ number_format($estate['warmmiete'], 0, ',', '.') }}
                            €
                        </p>
                      @elseif ($estate['kaltmiete'] > 0.0)
                          <p class="text-base font-medium leading-6 text-gray-400"> Kaltmiete </p>
                          <p class="text-3xl font-bold xl:text-4xl">
                            {{ number_format($estate['kaltmiete'], 0, ',', '.') }}
                            €
                        </p>
                      @else
                          <p class="text-base font-medium leading-6 text-gray-400"> Miete </p>
                          <p class="text-3xl font-bold xl:text-4xl">
                            Preis auf Anfrage
                        </p>
                      @endif
                  @else
                      <p class="text-base font-medium leading-6 text-gray-400"> Kaufpreis </p>
                      @if($estate['kaufpreis'] > 0.0)
                          <p class="text-3xl font-bold xl:text-4xl">
                        {{ number_format($estate['kaufpreis'], 0, ',', '.') }}
                        €
                    </p>
                      @else
                          <p class="text-xl font-bold xl:text-2xl">
                            Preis auf Anfrage
                        </p>
                      @endif
                  @endif
              </span>
            </p>
        </div>
    </div>


    @if (session('success'))
        <div class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
            <strong class="font-bold">Vielen Dank für Ihre Einsendung!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
</div>
<livewire:estate-contact-controller :estate="$estate" :estateId="$estateId" :title="'Kontakt'" :style="'rounded-t-none'" :formId="2" :defaultMessage="'Ich bin an dieser Immobilie interessiert. Bitte nehmen Sie Kontakt mit mir auf.'" />
