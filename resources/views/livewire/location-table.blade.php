<div class="w-full py-16 lg:py-24">
    @foreach ($locations as $key => $value)
        <div class="w-full {{ $loop->iteration % 2 == 0 ? 'bg-white' : 'bg-gray-100' }}">
            <div class="max-w-7xl px-4 lg:px-10 mx-auto py-8 lg:py-16">
                @foreach ($value as $location)
                <h2 class="text-4xl capitalize font-bold tracking-tight text-primary lg:text-5xl mb-8 mx-auto text-center">
                    {{$key}}
                </h2>
                <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-6 sm:gap-y-10 lg:grid-cols-3 lg:gap-x-8">
                    <div class="group relative flex flex-col overflow-hidden border border-gray-200">
                        <div class="aspect-h-4 aspect-w-3 bg-gray-200 sm:aspect-none group-hover:opacity-75 sm:h-96">
                            <img src="/images/{{$location["thumbnail_image"][0]}}" alt="platzhalter" class="h-full w-full object-cover object-center sm:h-full sm:w-full">
                        </div>
                        <div class="flex flex-1 flex-col space-y-2 p-4">
                            <h3 class="text-xl lg:text-2xl font-bold text-primary">
                            <a target="_blank" href="/standorte/{{strtolower($location["title"])}}">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                {{$location['title']}}
                            </a>
                            </h3>
                            <div class="flex flex-1 flex-col justify-end">
                                <a target="_blank" href="standort/" class="text-base text-secondary" target="_blank">
                                    Stadtteil {{$location['title']}} ansehen <span aria-hidden="true"> →</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
    @endforeach

</div>
