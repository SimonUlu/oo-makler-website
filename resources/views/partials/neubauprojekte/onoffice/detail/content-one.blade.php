@foreach($images as $image)
<div class="overflow-hidden bg-white">
    <div class="relative mx-auto max-w-7xl px-6 py-16 lg:px-8">
      <div class="absolute bottom-0 left-3/4 top-0 hidden w-screen bg-gray-50 lg:block"></div>
      <div class="mx-auto max-w-prose text-base lg:grid lg:max-w-none lg:grid-cols-2 lg:gap-8">
        <div>
          <h2 class="text-lg font-semibold text-gray-600">Präsentation</h2>
          <h3 class="mt-2 text-3xl font-bold leading-8 tracking-tight text-gray-900 sm:text-4xl">{{$image["title"]}}</h3>
        </div>
      </div>
      <div class="mt-8 lg:grid lg:grid-cols-2 lg:gap-8">
        <div class="relative lg:col-start-2 lg:row-start-1">
          <svg class="absolute right-0 top-0 -mr-20 -mt-20 hidden lg:block" width="404" height="384" fill="none" viewBox="0 0 404 384" aria-hidden="true">
            <defs>
              <pattern id="de316486-4a29-4312-bdfc-fbce2132a2c1" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
              </pattern>
            </defs>
            <rect width="404" height="384" fill="url(#de316486-4a29-4312-bdfc-fbce2132a2c1)" />
          </svg>
          <div class="relative mx-auto max-w-prose text-base lg:max-w-none">

            <figure>
              <div class="aspect-h-7 aspect-w-12 lg:aspect-none">
                    <div class="spinner" style="display: flex">
                        <svg
                            class="absolute inset-0 w-5 h-5 m-auto animate-spin"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 008 8V12A4 4 0 004 8"
                            ></path>
                        </svg>
                    </div>
                    <img
                        class="rounded-lg object-cover object-center shadow-lg lazy"
                        data-src="{{$image["url"]}}"
                        alt="Whitney leaning against a railing on a downtown street"
                        width="1184"
                        height="1376"
                        loading="lazy"
                        onload="this.parentElement.querySelector('.spinner').style.display = 'none';"
                    >
              </div>
            </figure>

          </div>
        </div>
        <div class="mt-8 lg:mt-0">
            <div class="mx-auto max-w-prose text-base lg:max-w-none">
                <p class="text-lg text-gray-500">
                    {{$estate["elements"]["objektbeschreibung"]}}
                </p>
            </div>
            <div class="prose prose-indigo mx-auto mt-5 text-gray-500 lg:col-start-1 lg:row-start-1 lg:max-w-none">

                <ul role="list">
                <li>Die gesamte Wohnfläche des Objektes beträgt {{$estate["elements"]["wohnflaeche"]}} qm</li>
                <li>Die Gesamtfläche des Objektes beträgt {{$estate["elements"]["gesamtflaeche"]}} qm</li>
                </ul>
                <h3>Beschreibung des Bildes</h3>
                <p>
                    {{$image["text"]}}
                </p>
            </div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
