<div class="mt-16 lg:mt-32 max-w-7xl mx-auto">
    <h2 class="mb-4 pl-6 text-4xl font-bold tracking-tight text-left text-primary px-4 lg:px-10 lg:text-5xl "> Lorem Ipsum </h2>
    <p class="mb-4 text-gray-500 sm:text-xl dark:text-gray-400 px-4 lg:px-10 pl-6">
        Beschreiben Sie hier Ihr Neubauprojekte detailliert, wie mit der Lage oder ähnlichem.
    </p>
    <div class="grid grid-cols-1 gap-12 sm:grid-cols-2 lg:grid-cols-3 px-4 lg:px-10 py-8 lg:py-16 mt-10 lg:mt-20">
        @foreach($four_grid_text_with_icons as $icon)
        <div class="pt-6">
            <div class="flow-root rounded-lg bg-gray-50 px-6 pb-8">
            <div class="-mt-6">
                <div>
                <span class="inline-flex items-center justify-center rounded-xl bg- p-3 shadow-lg">
                    {!! $icon["svg_icon"]["code"] !!}
                </span>
                </div>
                <h3 class="mt-8 text-lg font-semibold leading-8 tracking-tight text-gray-900">{{$icon["header"][0]["content"][0]["text"]}}</h3>
                <p class="mt-5 text-base leading-7 text-gray-600">{{$icon["description"][0]["content"][0]["text"]}}</p>
            </div>
            </div>
        </div>
        @endforeach
    </div>
  </div>
