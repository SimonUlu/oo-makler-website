<ul role="list" class="mx-auto mt-4 max-w-2xl gap-x-8 gap-y-16 text-center"
    data-estate-id="{{ $estateId }}"
    data-user-id="{{ $userId }}"
    x-data="{ loaded: @entangle('loaded'), userUrl: @entangle('userUrl'), loadedImage: @entangle('loadedImage') }"
>
    @if($ansprechpartner)
    <li wire:init="load">
        <span x-show="loadedImage">
            <img class="mx-auto h-20 w-20 rounded-full" :src="'data:image/png;base64,'+userUrl" alt="Profilbild Immobilienansprechpartner">
        </span>
        {{-- Spinner to show while loading process --}}
        <svg x-show="!loaded" class="w-5 h-5 animate-spin" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 008 8V12A4 4 0 004 8"></path>
        </svg>

        {{-- Show either user info or business info if user does not exist --}}
        <div x-show="loadedImage">
            <h3 class="mt-2 text-base font-semibold leading-7 tracking-tight text-gray-900">{{ $userName }}</h3>
            <a href="mailto:{{$userEmail}}" class="cursor-pointer">
                <p class="text-sm leading-6 text-gray-600">{{$userEmail}}</p>
            </a>
        </div>
        <div x-show="!loadedImage">
            <p class="text-sm leading-6 text-gray-600">{{$businessName}}</p>
        </div>
    </li>
    @endif
</ul>
