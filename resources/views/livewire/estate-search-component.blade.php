<div class="max-w-xl mx-auto my-16 lg:my-24 relative">
    <input class="block w-full rounded-md border-0 py-1.5 pr-14 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="text" wire:model.debounce.500ms="searchTerm" placeholder="Suche nach Immobilien...">

    <!-- Suchergebnisse Container -->
    <div class="absolute z-10 w-full mt-1 rounded-lg shadow-lg border border-gray-200 bg-white max-h-80 overflow-y-auto">
        <ul>
            @foreach($estates as $estate)
                @if ($loop->index < 5) <!-- Begrenzung auf 5 Resultate -->
                    <li class="flex justify-between items-center gap-x-6 p-4 hover:bg-gray-100">
                        <div class="flex items-center gap-x-4">
                            <img class="h-12 w-12 rounded-full bg-gray-50" src="{{ $estate['image_url'] ?? 'https://via.placeholder.com/48' }}" alt="">
                            <div class="min-w-0 flex-auto">
                                <p class="text-sm font-semibold text-gray-900">{{ $estate['title'] }}</p>
                                <p class="mt-1 truncate text-xs text-gray-500">{{ $estate["location"] }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <p class="text-xs leading-5 text-gray-500">{{ $estate['selling_price'] }}</p>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
