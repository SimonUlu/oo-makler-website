<div class="">
    <div class="relative z-10 max-w-screen-xl px-4 py-8 mx-auto lg:py-16 lg:px-6">
        <div class="flex w-full justify-between lg:space-x-8">
            <div class="mb-4 w-full max-w-[50%]">
                <label for="search" class="block text-gray-700">Suche</label>
                <input 
                    wire:model.debounce.300ms="searchString" 
                    id="search" 
                    name="search" 
                    type="text" 
                    placeholder="Nach News suchen..." 
                    class="mt-1 p-2 w-full border border-gray-300 rounded"
                >
            </div>
            <div>
                <label for="category" class="block text-gray-700">Kategorie wählen</label>
                <select wire:model="selectedCategory" id="category" name="category" class="mt-1 p-2 min-w-[200px] border border-gray-300 rounded">
                    <option value="">Alle Kategorien</option>
                    @foreach($categories as $category)
                        <option value="{{ $category["value"] }}">{{ $category["value"] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <section class="relative bg-white">
        <div class="relative z-10 max-w-screen-xl px-4 py-8 mx-auto lg:py-16 lg:px-6">
            <div class="relative grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($posts as $post)
                <article class="relative p-4 mt-16 bg-white border border-gray-200 rounded-lg shadow-md dark:border-gray-700">
                    <div class="relative -mt-16 h-60">
                        <a href="{{ $post->url() }}"> <!-- Rufe die URL des Eintrags auf -->
                            <img class="object-cover object-center w-full mb-5 rounded-lg h-60" src="/images/{{ $post->get('image') }}" alt="{{ $post->get('title') }}" /> <!-- Rufe das Bild und den Titel auf -->
                        </a>
                    </div>
                    <div class="mt-12">
                        <h2 class="my-2 text-2xl font-bold tracking-tight text-gray-900">
                            <a href="{{ $post->url() }}">{{ $post->get('title') }}</a> <!-- Rufe den Titel auf und verlinke ihn zur URL -->
                        </h2>
                        <p class="mb-4 font-light text-gray-500 dark:text-gray-400">
                            {{ $post->get('teaser') }} <!-- Rufe den Teaser auf -->
                        </p>
                        <a href="{{ $post->url() }}" class="inline-flex items-center justify-end w-full font-medium text-primary-600 hover:underline dark:text-primary-500">
                            Weiterlesen
                            <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
</div>
