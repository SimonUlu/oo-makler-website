<div aria-label="Breadcrumb" class="ml-2">
    <ol role="list" class="flex items-center w-full mx-auto space-x-2 sm:max-w-screen-xl sm:px-4 lg:max-w-7xl lg:px-8">
        <li>
            <div class="flex items-center">
                <a href="/immobilien" class="mr-2 text-sm font-medium text-gray-900">Alle
                    Immobilien</a>
                <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true"
                    class="w-4 h-5 text-gray-300">
                    <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                </svg>
            </div>
        </li>
        @if ($estate['elements']['vermarktungsart'] == 'miete')
            <li class="text-sm">
                <a href="/immobilien?filter[vermarktungsart][0]=Miete" aria-current="page"
                    class="font-medium text-gray-500 hover:text-gray-600">Mietobjekte</a>
            </li>
        @else
            <li class="text-sm">
                <a href="/immobilien?filter[vermarktungsart][0]=Kauf" aria-current="page"
                    class="font-medium text-gray-500 hover:text-gray-600">Kaufobjekte</a>
            </li>
        @endif
    </ol>
</div>
