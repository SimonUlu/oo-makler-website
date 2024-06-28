<div class="w-full bg-white py-12 lg:py-24">
    <div class="max-w-7xl px-4 lg:px-10 mx-auto">
        @foreach ($orderedEntries as $key => $value)
        <div class="py-6 lg:py-12">
            <h2 class="text-4xl font-bold tracking-tight text-primary lg:text-5xl mb-8">
                {{$key}}
            </h2>
            <div class="mt-20">
                @foreach ($value as $question)

                    <dl class="space-y-16 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-16 sm:space-y-0 lg:grid-cols-3 lg:gap-x-10">
                        <div>
                            <dt class="text-base font-semibold leading-7 text-gray-900">
                                {{$question["title"]}}
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">
                                {!!$question["erklaerung"]!!}    
                            </dd>
                        </div>
                
                    </dl>
                    
                @endforeach
                
            </div>
        </div>




            
        @endforeach

    </div>

</div>
