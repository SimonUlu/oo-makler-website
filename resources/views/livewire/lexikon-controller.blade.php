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
                    placeholder="Nach Artikeln suchen ..." 
                    class="mt-1 p-2 w-full border border-gray-300 "
                >
            </div>
            <div>
                <label for="category" class="block text-gray-700">Von A bis Z</label>
                <select wire:model="selectedCategory" id="category" name="category" class="mt-1 p-2 min-w-[200px] border border-gray-300 ">
                    <option value="">Alle Anfangsbuchstaben</option>
                    @foreach($categories as $category)
                        <option class="capitalize" value="{{ $category["value"] }}">{{ $category["value"] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <section class="relative bg-white">
        <div class="relative z-10 max-w-screen-xl px-4 py-8 mx-auto lg:py-16 lg:px-6">
            <div class="relative grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($posts as $post)
                <article class="relative p-4 bg-gray-100 border border-gray-200 -lg shadow-md dark:border-gray-700">
                    <div class="mt-4 justify-center flex flex-col">
                        <div class="items-center justify-center flex">
                            <svg class="text-primary w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                            </svg>
                        </div>
                          
                        <h2 class="my-2 text-xl font-bold tracking-tight text-gray-900 text-center">
                            <a href="{{ $post->url() }}">{{ $post->get('title') }}</a> <!-- Rufe den Titel auf und verlinke ihn zur URL -->
                        </h2>
                        <p class="mb-4 font-light text-gray-500 dark:text-gray-400">
                            {{ $post->get('teaser') }} <!-- Rufe den Teaser auf -->
                        </p>
                        <a href="faq/{{ $post->slug() }}" class="inline-flex items-center justify-center w-full font-medium text-primary">
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

