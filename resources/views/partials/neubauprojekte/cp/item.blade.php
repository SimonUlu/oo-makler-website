<li 
    x-bind="disableNextAndPreviousButtons" 
    class="grid items-center justify-center w-full pr-4  shrink-0 snap-start rounded-lg lg:grid-cols-8" 
    role="option"
>
    <div class="py-4 px-8 lg:col-span-5">
        <div class="mb-8">
            <h3 class="mt-2 text-xl lg:text-2xl font-semibold text-primary group-hover:text-gray-600 mb-4">
                {{ $projekt['title'] }}
            </h3>
            <p>
                {{  $projekt['text_one'] }}
            </p>
            <div class="pb-4  sm:py-6 lg:py-8">
                <ul class="space-y-4">
                    
                    @foreach ($projekt["list"] as $list)
                        <li class="flex items-center gap-2.5">
                            <div class="inline-flex items-center justify-center w-5 h-5  bg-primary-100 text-primary-600 shrink-0 dark:bg-primary-900 dark:text-primary-500">
                                <svg aria-hidden="true" class="w-6 h-6 text-secondary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-base font-bold text-gray-900">
                                {{$list["listitem"]}}
                            </span>
                        </li>
                    @endforeach
                    
                    
                </ul>
            </div>
            <p>
                {{  $projekt['text_two'] }}
            </p>
        </div>
    </div>

    <div class="group relative flex flex-col overflow-hidden border border-gray-200 bg-white ml-4 lg:col-span-3">
        <div class="aspect-h-4 aspect-w-3 bg-gray-200 sm:aspect-none group-hover:opacity-75 sm:h-96">
          <img src="{{$projekt["image"][0]["url"]}}" alt="Front of plain black t-shirt." class="h-full w-full object-cover object-center sm:h-full sm:w-full">
        </div>
        <div class="flex flex-1 flex-col space-y-2 p-4">
            <h3 class="text-xl lg:text-2xl font-medium text-primary">
                <a href="#">
                <span aria-hidden="true" class="absolute inset-0"></span>
                {{$projekt["objekttyp"]}}
                </a>
            </h3>
            <div class="flex justify-between items-center">
                <div class="flex text-primary text-base">
                    <span>{{$projekt["plz"]}}</span>
                    <span class="mx-2"> · 
                        {{$projekt["ort"]}}
                    </span>
                </div>
                <a  class="inline-flex justify-center bg-secondary items-center py-2.5 px-5 text-md font-medium text-center md:w-auto lg:col-span-12 focus:ring-4 focus:outline-none text-white">
                    {{$projekt["vermarktung"]["value"]}}
                </a>
            </div>
            
        </div>
    </div>
</li>

