<li class="flex flex-col items-center justify-center w-full p-2 shrink-0 snap-start" role="option">
    <div
        x-data="{ hover: false }"
        @mouseover="hover = true"
        @mouseout="hover = false"
        class="bg-cover bg-no-repeat bg-center w-full h-[28rem] relative cursor-pointer"
        style='background-image: url( "{{ $estate["elements"]["images"]["0"]["url"] }}" )'
    >
        <a target="_blank">
            <div
                x-bind:class="{ 'h-1/3': !hover, 'h-3/4': hover }"
                class="transition-all w-full bg-primary-800 flex flex-col justify-end p-4 absolute bottom-0 overflow-hidden"
                style="z-index: 10"
                x-bind:style="{'background-color': hover ? 'rgba(0,103,177, 0.8)' : 'rgba(0,103,177, 0.6)'}"
            >
                <div
                    x-bind:class="{ 'translate-y-0': !hover, '-translate-y-1/4': hover }"
                    class="transition-transform"
                >
                    <img
                        x-show="hover"
                        src="/logo_images/logo_white.png"
                        class="h-12 mr-3 pb-4"
                        alt="Test"
                    />
                    <h3 class="text-white font-bold text-xl">
                        {{$estate["elements"]["objekttitel"]}}
                    </h3>
                    <p class="text-white text-md">  {{$estate["elements"]["plz"]}} {{$estate["elements"]["ort"]}}</p>
                    <p x-show="hover" class="text-white text-sm pt-2">{{ substr(e($estate["elements"]["objektbeschreibung"]), 0, 150) }}</p>
                </div>
            </div>
        </a>
    </div>
</li>

