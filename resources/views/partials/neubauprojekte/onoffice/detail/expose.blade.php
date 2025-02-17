<section class="bg-white dark:bg-gray-900">
    <div class="gap-8 items-center py-8 px-4 mx-auto max-w-screen-xl xl:gap-16 md:grid md:grid-cols-2 sm:py-16 lg:px-6">
        <div class="mt-4 md:mt-0">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-primary dark:text-white">
                Alle wesentlichen Details kompakt zusammengefasst
            </h2>
            <p class="mb-6 font-light text-gray-500 md:text-lg dark:text-gray-400">
                Unser Exposé bündelt sämtliche relevanten Informationen zu unserem Bauprojekt. Entdecken Sie detaillierte Angaben zur Positionierung und zur Ausstattung der Immobilien, ergänzt durch aussagekräftige Bilder und Grundrisse. 
            </p>
            <a href="#" class="inline-flex items-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-primary-900">
                Expose herunterladen
                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </a>
        </div>
        @if(isset($estate['elements']['images'][0]['url']))
            <img class="w-full dark:hidden" src="{{$estate['elements']['images'][0]['url']}}" alt="dashboard image">
        @endif
    </div>
</section>
