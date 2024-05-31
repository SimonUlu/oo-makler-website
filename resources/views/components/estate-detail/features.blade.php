    <div class="mt-12">
        <div class="lg:col-span-2 lg:pr-8">
            <section aria-labelledby="reviews-heading" class="pt-4 border-t border-gray-200 lg:pt-10">
                <h2 class="text-xl font-bold tracking-tight text-gray-900">Besondere Ausstattungsmerkmale</h2>
                <div class="grid justify-between grid-cols-3 pt-4 mt-8 space-y-8 ">
                    @foreach ($features as $key => $feature)
                        @if ($estate[$feature['name']])
                            <div class="flex flex-col mt-2 lg:mt-8 items-center justify-center">
                                <span class="w-8 h-8 text-xl font-bold">{!! $feature['avatar'] !!}</span>
                                <div class="flex text-md font-extrabold lg:text-xl">
                                    {{ $key }}
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>
        </div>
    </div>
