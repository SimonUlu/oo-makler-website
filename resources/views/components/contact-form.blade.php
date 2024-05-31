@php
    $logoUrl = asset('logo_images/logo.png');
@endphp

<div class="pt-3 pl-3 pr-3 border border-gray-200 rounded-t-lg border-t-none">
    <div class="flex flex-col items-center justify-center sm:flex sm:col-span-2" x-data="{ logoUrl: '{{ $logoUrl }}' }">
        <!-- Display user photo if it exists -->
        <div class="mt-4">
                <!-- Display default photo if user photo does not exist -->
            <img class="max-w-[120px]" height="auto" src="{{ $logoUrl }}" alt="Ihr Kontakt">
        </div>
        <span class="mt-2 text-sm font-bold text-gray-900 ">
            Ihr Kontakt</span>
        @if (!isset($estate['userPhoto']))
            {{-- <ul role="list" class="mx-auto mt-4 max-w-2xl gap-x-8 gap-y-16 text-center">
                <li>
                <img class="mx-auto h-20 w-20 rounded-full" src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80" alt="">
                <h3 class="mt-2 text-base font-semibold leading-7 tracking-tight text-gray-900">Michael Foster</h3>
                <p class="text-sm leading-6 text-gray-600">Co-Founder / CTO</p>
                </li>
            </ul> --}}
            @livewire('user-show', ['lazy' => true, 'estateId' => $estateId, 'userId' => $estate["elements"]["benutzer"]])
            <a href="tel:{{ Statamic\Facades\GlobalSet::find('business_information')->in('default')->get('company_phone') }}" title="Rufen Sie uns jetzt an!"
                class="inline-flex items-center justify-center px-5 py-2 my-4 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                role="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0l-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 014.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 00-.38 1.21 12.035 12.035 0 007.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 011.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 01-2.25 2.25h-2.25z" />
                </svg>
                Direkt anrufen
            </a>
        @else
            <div class="text-center">
                <span class="text-sm text-center">{{ Statamic\Facades\GlobalSet::find('business_information')->in('default')->get('company_name') }}</span>
            </div>

            <a href="tel:{{ Statamic\Facades\GlobalSet::find('business_information')->in('default')->get('company_phone') }}"
                title="Rufen Sie uns jetzt an!"
                class="inline-flex items-center justify-center px-5 py-2 my-4 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                role="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0l-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 014.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 00-.38 1.21 12.035 12.035 0 007.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 011.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 01-2.25 2.25h-2.25z" />
                </svg>
                Direkt anrufen
            </a>
        @endif
    </div>


    @if (session('success'))
        <div class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
            <strong class="font-bold">Vielen Dank für Ihre Einsendung!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
</div>
<livewire:estate-contact-controller :estate="$estate" :estateId="$estateId" :title="'Kontakt'" :style="'rounded-t-none'" :formId="2" :defaultMessage="'Ich bin an dieser Immobilie interessiert. Bitte nehmen Sie Kontakt mit mir auf.'" />
