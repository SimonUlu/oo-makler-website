<div class="w-full bg-white  lg:pt-10 pb-6 lg:pb-12 max-w-7xl px-4 lg:px-10 mt-16">
    <div class="relative mx-auto">
        <h2 class="text-3xl font-bold tracking-tight text-left text-gray-900 lg:text-5xl ">Unsere {{$art}}</h2>
    </div>
    <div class="relative pt-8 pb-20 mx-auto lg:px-2 lg:pt-12 lg:pb-28">
        <div class="flex flex-col w-full">

            <div  class="flex space-x-6">


                <ul class="grid-cols-1 grid md:grid-cols-2 w-fulloverflow-hidden snap-x space-y-4 md:space-y-0 snap-mandatory md:space-x-6">
                    <!-- Section Single Estate -->
                    @foreach($projekte as $projekt)
                        @include("partials.neubauprojekte.onoffice.item.item-grid", ['projekt' => $projekt])
                    @endforeach
                    <!-- Section Single Estate -->
                </ul>
            </div>
        </div>
    </div>

</div>
