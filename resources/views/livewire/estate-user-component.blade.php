<div class="border-t-[1px] border-gray-300 mt-6 mb-2 flex justify-between  items-center lazy-user" data-estate-id="{{ $estateId }}" data-user-id="{{ $userId }}" x-data="{ loaded: @entangle('loaded'), userUrl: @entangle('userUrl'), loadedImage: @entangle('loadedImage') }">

    <div class="order-1 mt-4 flex items-center" x-data="{ logoUrl: '{{ $logoUrl }}' }">
        <img class="max-h-[42x] max-w-[120px]" x-bind:src="logoUrl" alt="Logo">
    </div>

    @if($ansprechpartner)
    <div wire:init="load" class="order-2 mt-4 flex items-center lazy-user-spinner">
        <svg x-show="!loaded" class="w-5 h-5 animate-spin" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 008 8V12A4 4 0 004 8"></path>
        </svg>
        <a href="/{{$userHrefUrl}}" class="cursor-pointer flex items-center">
            @if($source !== "small_boxes")
                <span class="hidden lg:block">{{$userName}} </span>
            @endif
            <span x-show="loadedImage" class="inline-block ml-2 h-10 w-10 overflow-hidden rounded-full bg-gray-100">
                <img class="h-full w-full" :src="'data:image/png;base64,'+userUrl" alt="Profilbild Immobilienansprechpartner">
            </span>
        </a>
    </div>
    @endif
</div>
