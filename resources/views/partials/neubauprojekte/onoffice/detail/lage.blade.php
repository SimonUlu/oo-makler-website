<div class="max-w-7xl px-4 lg:px-10 mx-auto">
    <div class="overflow-hidden px-6 pt-16 lg:px-8 xl:pt-36">
        <div class="relative md:py-6">
            <div class="lg:grid lg:grid-cols-2 lg:gap-6">
                <div class="prose prose-lg prose-indigo text-gray-500 lg:max-w-none">
                    <div class="max-w-prose text-base lg:max-w-none">
                        <p class="mt-2 text-3xl font-bold leading-8 tracking-tight text-primary sm:text-4xl">
                            Lage
                        </p>
                    </div>
                    {{$lage}}
                </div>
                <div class="relative bg-gray-100 px-4 py-4">
                    <div class="max-w-prose text-base lg:max-w-none">
                        <p class="mt-2 text-3xl font-bold leading-8 tracking-tight text-primary sm:text-4xl mb-8">
                            Alle Infos auf einen Blick
                        </p>
                    </div>
                    <div class="relative">
                        <!-- Fake card background -->
                        <div aria-hidden="true" class="absolute inset-y-0 right-0 hidden w-1/2 rounded-lg bg-white shadow-sm sm:block"></div>

                        <div class="relative rounded-lg bg-white shadow-sm sm:rounded-none sm:bg-transparent sm:shadow-none sm:ring-0 ring-1 ring-gray-900/10">
                            <dl class="divide-y divide-gray-200 text-sm leading-6">
                                @foreach($info[0]["infos"] as $info)                            
                                    <div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
                                        <dt class="pr-4 text-gray-600 text-xl font-bold">{{$info["key"]}}</dt>
                                        <dd class="flex items-center justify-end sm:justify-center sm:px-4 text-center">
                                            <span> {{$info["wert"]["code"]}} </span>
                                        </dd>
                                    </div>
                                @endforeach
                                
                                
                            </dl>
                        </div>
                    <!-- Fake card border -->
                    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 hidden w-1/2 rounded-lg sm:block ring-1 ring-gray-900/10"></div>
                </div>
            </div>
            <div class="mt-8 inline-flex">
                <a 
                    href="#" 
                    class="flex items-center justify-center py-3 text-base font-medium text-primary">
                    Expose anfordern
                </a>
            </div>
        </div>
    </div>
<div>