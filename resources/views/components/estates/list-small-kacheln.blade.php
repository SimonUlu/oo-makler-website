@php
    $logoUrl = asset('logo_images/logo.png');
@endphp

<div class="relative">
    <h2 class="sr-only">Estate View</h2>

    <ul class="sm:grid sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3">
        @php
            $counter = 0;
        @endphp
        @if (!empty($estates))
            @foreach ($estates as $index => $estate)
                @php
                    $counter++;
                @endphp
                @if ($counter % 7 == 0)
                    <div class="md:col-span-2 xl:col-span-3 mx-2">
                        <x-estates.suchauftrag-banner />
                    </div>
                @endif
                <!-- List Item Start -->
                <x-estates.listitem-small-kacheln :estate="$estate" :estateFields="$estateFields" :estateImages="[]"
                    :logoUrl="$logoUrl" :showContactModal="$showContactModal" :openModal="$openModal" :estateContactModal="$estateContactModal" />
                <!-- List Item End-->
            @endforeach
        @endif
    </ul>


    @if ($showContactModal)
        <x-elements.modal wire:model="showContactModal" max-width="5xl" wire:key="{{ $estateContactModal['id'] }}_modal">
            <div class="h-full px-6 py-4">
                <div class="flex justify-between float-right text-lg">
                    <button type="button" wire:click="$set('showContactModal', false)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div>
                    <livewire:estate-contact-controller :estate="$estateContactModal" :title="'Kontakt'" :style="'rounded-t-none'"
                        wire:key="'estate-contact-controller'. {{ $estateContactModal['id'] }}" :defaultMessage="'Ich bin an dieser Immobilie interessiert. Bitte nehmen Sie Kontakt mit mir auf.'" />
                </div>
            </div>
        </x-elements.modal>
    @endif

</div>
