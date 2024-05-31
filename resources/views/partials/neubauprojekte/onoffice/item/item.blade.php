<li x-bind="disableNextAndPreviousButtons" class="flex flex-col items-center justify-center w-full pr-4 md:w-1/2 lg:w-1/3 shrink-0 snap-start rounded-lg" role="option">

    <div
        x-data="{ hover: false }"
        @mouseover="hover = true"
        @mouseout="hover = false"
        class="bg-cover bg-no-repeat bg-center w-full h-[28rem] relative cursor-pointer rounded-lg"
        style='background-image: url( "{{ $projekt['elements']['images'][0]["url"] }}" )'
    >
        <a href="/neubauprojekte/details/{{$projekt['elements']['Id']}}" target="_blank">
            <div
                x-bind:class="{ 'h-1/3': !hover, 'h-2/3': hover }"
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
                    <h3 class="text-white font-bold text-2xl">
                        {{$projekt['elements']['objekttitel']}}
                    </h3>
                    <p class="text-white text-md"> {{$projekt['elements']['plz']}}  {{$projekt['elements']['ort']}}</p>
                    <p x-show="hover" class="text-white text-md pt-2">
                        {{ \Illuminate\Support\Str::limit($projekt['elements']['objektbeschreibung'], 150, $end='...') }}
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
</li>

