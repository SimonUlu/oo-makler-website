<li 
    x-bind="disableNextAndPreviousButtons" 
    class="grid items-center justify-center w-full pr-4  shrink-0 snap-start rounded-lg lg:grid-cols-2" 
    role="option"
>

    <div
        x-data="{ hover: false }"
        @mouseover="hover = true"
        @mouseout="hover = false"
        class="bg-cover bg-no-repeat bg-center w-full h-[28rem] relative cursor-pointer"
        style='background-image: url( "{{ $projekt['estate_images'][0]["url"] }}" )'
    >
        <a href="/neubauprojekte/details/{{$projekt['Id']}}" target="_blank">
            <div
                x-bind:class="{ 'h-1/4': !hover, 'h-2/3': hover }"
                class="transition-all w-full bg-primary-800 flex flex-col justify-end p-4 absolute bottom-0 overflow-hidden rounded-b-lg"
                style="z-index: 10"
                x-bind:style="{'background-color': hover ? 'rgba(0,0,0, 0.9)' : 'rgba(0,0,0, 0.7)'}"
            >
                <div
                    x-bind:class="{ 'translate-y-0': !hover, '-translate-y-1/4': hover }"
                    class="transition-transform"
                >
                    <img
                        x-show="hover"
                        src="/logo_images/logo_white.png"
                        class="h-12 mr-3 pb-4"
                    />
                    <h3 class="text-white font-bold text-xl">
                        {{ \Illuminate\Support\Str::limit($projekt['objekttitel'], 60, $end='...') }}
                    </h3>
                    <p class="text-white text-base"> {{$projekt['plz']}}  {{$projekt['ort']}}</p>
                    <p x-show="hover" class="text-white text-sm pt-2">
                        {{ \Illuminate\Support\Str::limit($projekt['objektbeschreibung'], 150, $end='...') }}
                    </p>
                </div>
                <div
                    x-bind:class="{ 'opacity-0': !hover, 'opacity-100': hover }"
                    class="transition-opacity text-white text-md absolute bottom-4 right-4 rounded-lg"
                >
                    Öffnen →
                </div>
            </div>
        </a>
    </div>

    <div class="py-4 px-8">
        <div class="mb-8">
            <h3 class="mt-2 text-xl lg:text-2xl font-semibold text-primary group-hover:text-gray-600 mb-4">
                {{ $projekt['objekttitel'] }}
            </h3>
            <p>
                {{  \Illuminate\Support\Str::limit($projekt['objektbeschreibung'],  500, $end='...') }}
            </p>
        </div>
        <div class="my-2 border-t border-gray-300 pt-8">
            <dl class="-mx-8 -mt-8 flex flex-wrap">
                <div class="flex flex-col px-8 pt-8">
                    <dt class="order-1 text-base font-medium text-gray-700">Gesamtflaeche</dt>
                    <dd class="order-2 text-2xl font-bold text-primary sm:text-xl sm:tracking-tight">{{$projekt['gesamtflaeche']}} m2</dd>
                </div>
                @if (isset($projekt['energyClass']))
                    <div class="flex flex-col px-8 pt-8">
                        <dt class="order-1 text-base font-medium text-gray-700">Energieklasse</dt>
                        <dd class="order-2 text-2xl font-bold text-primary sm:text-xl sm:tracking-tight">{{$projekt['energyClass']}}</dd>
                    </div>
                    
                @endif
                <div class="flex flex-col px-8 pt-8">
                    <dt class="order-1 text-base font-medium text-gray-700">Ort</dt>
                    <dd class="order-2 text-2xl font-bold text-primary sm:text-xl sm:tracking-tight">{{$projekt['ort']}}</dd>
                </div>
            </dl>
        </div>
        <div class="mt-8">
            <a class="text-primary mt-6 font-bold" href="/neubauprojekte/details/{{$projekt['Id']}}" target="_blank">
                Projekt ansehen <span aria-hidden="true"> →</span>
            </a>
        </div>
    </div>
</li>

