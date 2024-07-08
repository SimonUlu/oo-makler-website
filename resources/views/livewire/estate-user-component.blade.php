<div class="border-t-[1px] border-gray-300 mt-6 mb-2 flex justify-between items-center lazy-user" data-estate-id="{{ $estateId }}" data-user-id="{{ $userId }}" x-data="{ loaded: @entangle('loaded'), userImage: @entangle('userImage'), loadedImage: @entangle('loadedImage') }">

    <div class="order-1 mt-4 flex items-center" x-data="{ logoUrl: '{{ $logoUrl }}' }">
        <img class="max-h-[42x] max-w-[120px]" x-bind:src="logoUrl" alt="Logo">
    </div>

    @if($ansprechpartner)
        <div x-data="{open: false}" wire:init="load" class="order-2 mt-4 flex items-center lazy-user-spinner relative">
            <svg x-show="!loaded" class="w-5 h-5 animate-spin" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 008 8V12A4 4 0 004 8"></path>
            </svg>
            <a @click="open = !open" class="cursor-pointer flex items-center">
                @if($source !== "small_boxes")
                    <span class="hidden lg:block">{{$userName}} </span>
                @endif
                <span x-show="loadedImage" class="inline-block ml-2 h-16 w-16 overflow-hidden rounded-full bg-gray-100">
                <img class="h-full w-full object-cover" :src="'data:image/png;base64,' + userImage" alt="Profilbild Immobilienansprechpartner">
            </span>
            </a>
            <div x-show="open" x-transition class="absolute p-2 right-0 bg-white shadow-lg rounded-lg -mt-28 min-width-[220px]">
            <span class="flex items-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
                  </svg>
                  <a class="ml-4" href="mailto:{{$email}}"> {{$email}} </a>
            </span>
                <span class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                  </svg>
                  <a class="ml-4" href="phone:{{$userPhoneNumber}}"> {{$userPhoneNumber}} </a>
            </span>
            </div>
        </div>
    @endif
</div>
