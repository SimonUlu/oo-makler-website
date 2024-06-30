<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12">
        <div class="grid grid-cols-3 gap-2">
            <a 
                href="#" 
                class="p-8 col-span-3 text-left h-[600px] bg-no-repeat bg-cover bg-center bg-gray-500 bg-blend-multiply hover:bg-blend-normal"
                style="background-image: url('{{$estate["elements"]["images"][0]["url"]}}');"
            >
                <!-- Entfernen Sie das <img>, wenn Sie das Bild nur als Hintergrund anzeigen möchten -->
            </a>
            @if(isset($estate["elements"]["images"][3]))
                <a 
                    href="#" 
                    style="background-image: url('{{$estate["elements"]["images"][1]["url"]}}');"
                    class="p-8 col-span-2 md:col-span-1 text-left h-96  bg-no-repeat bg-cover bg-center bg-gray-500 bg-blend-multiply hover:bg-blend-normal">
                </a> 
                <div 
                    style="background-image: url('{{$estate["elements"]["images"][2]["url"]}}');"
                    class="p-8 col-span-2 md:col-span-1 text-left h-96  bg-no-repeat bg-cover bg-center bg-gray-500 bg-blend-multiply hover:bg-blend-normal">
                </div>               
                <a 
                    href="#" 
                    style="background-image: url('{{$estate["elements"]["images"][3]["url"]}}');"
                    class="p-8 col-span-2 md:col-span-1 text-left h-96 bg-no-repeat bg-cover bg-center bg-gray-500 bg-blend-multiply hover:bg-blend-normal">
                </a>
            @endif
        </div>
    </div>
</section>