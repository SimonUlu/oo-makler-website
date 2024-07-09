<div class="overflow-hidden rounded-lg bg-white shadow">
    <h2 class="sr-only" id="profile-overview-title">Profile Overview</h2>
    <div class="bg-white p-6">
        <ul role="list" class="mx-auto mt-4 max-w-2xl gap-x-8 gap-y-16 text-center"
            data-estate-id="{{ $estateId }}"
            data-user-id="{{ $userId }}"
            x-data="{ loaded: @entangle('loaded'), userImage: @entangle('userImage'), loadedImage: @entangle('loadedImage') }"
        >
            @if($ansprechpartner)
            <li wire:init="load">
                <span x-show="loadedImage">
                    <img class="mx-auto h-48 w-48 rounded-full object-cover" :src="'data:image/png;base64,'+ userImage" alt="Profilbild Immobilienansprechpartner">
                </span>
                {{-- Spinner to show while loading process --}}
                <svg x-show="!loaded" class="w-6 h-6 animate-spin" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 008 8V12A4 4 0 004 8"></path>
                </svg>

                {{-- Show either user info or business info if user does not exist --}}
                <div x-show="loadedImage">
                    <h3 class="mt-2 text-base font-semibold leading-7 tracking-tight text-gray-900">{{ $userName }}</h3>
                </div>
                <div x-show="!loadedImage">
                    <p class="text-sm leading-6 text-gray-600">{{$businessName}}</p>
                </div>
            </li>
            @endif
        </ul>
    </div>
    <div class="grid grid-cols-1 divide-y divide-gray-200 border-t border-gray-200 bg-gray-50 sm:grid-cols-2 sm:divide-x sm:divide-y-0">
      <div class="px-6 py-5 text-center text-sm font-medium cursor-pointer hover:bg-gray-200">
        <a href="mailto:{{$userEmail}}" class="text-base items-center justify-center flex">
            <div class="mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51m16.5 1.615a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V8.844a2.25 2.25 0 011.183-1.98l7.5-4.04a2.25 2.25 0 012.134 0l7.5 4.04a2.25 2.25 0 011.183 1.98V19.5z"></path>
                </svg>
            </div>
            {{$userEmail}}
        </a>
      </div>
      <div class="px-6 py-5 text-center text-sm font-medium cursor-pointer hover:bg-gray-200">
        <a href="tel:{{$userPhoneNumber}}" class="text-base items-center justify-center flex">
            <div class="mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0l-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 014.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 00-.38 1.21 12.035 12.035 0 007.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 011.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 01-2.25 2.25h-2.25z"></path>
                </svg>
            </div>
            {{$userPhoneNumber}}
        </a>
      </div>
    </div>

</div>

