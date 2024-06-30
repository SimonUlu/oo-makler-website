<div class="flex relative max-w-7xl mx-auto pb-12 lg:pb-24">
  
  <ul x-ref="slider" tabindex="0" role="listbox" aria-labelledby="carousel-content-label" class="flex w-full overflow-hidden snap-x snap-mandatory show-1">
    <h2 class="mb-4 pl-6 text-4xl font-bold tracking-tight text-left text-primary px-4 lg:px-10 lg:text-5xl "> Lorem Ipsum </h2>
      <li x-bind="disableNextAndPreviousButtons" class="grid items-center justify-center w-full pr-4  shrink-0 snap-start rounded-lg lg:grid-cols-2" role="option">

        <div class="bg-cover bg-no-repeat bg-center w-full h-[28rem] relative cursor-pointer" style="background-image: url( &quot;https://image.onoffice.de/smart20/Objekte/BVBI/13917/f1aab8a8-991a-46fa-b8a1-52b31947dbaa.jpg&quot; )">
          
        </div>

        <div class="py-4 px-8">
          <div class="mb-8">
            <h3 class="mt-2 text-xl lg:text-2xl font-semibold text-primary group-hover:text-gray-600 mb-4">
              {{$estate["elements"]["objekttitel"]}}
            </h3>
            <p>
              {{$estate["elements"]["objektbeschreibung"]}}
            </p>
          </div>
          <div class="my-2 border-t border-gray-300 pt-8">
            <dl class="-mx-8 -mt-8 flex flex-wrap">
              <div class="flex flex-col px-8 pt-8">
                  <dt class="order-1 text-base font-medium text-gray-700">Gesamtflaeche</dt>
                  <dd class="order-2 text-2xl font-bold text-primary sm:text-xl sm:tracking-tight">
                    {{$estate["elements"]["gesamtflaeche"]}}
                  </dd>
              </div>
                                  <div class="flex flex-col px-8 pt-8">
                      <dt class="order-1 text-base font-medium text-gray-700">Energieklasse</dt>
                      <dd class="order-2 text-2xl font-bold text-primary sm:text-xl sm:tracking-tight">
                        {{$estate["elements"]["energyClass"]}}
                      </dd>
                  </div>
                  
                              <div class="flex flex-col px-8 pt-8">
                  <dt class="order-1 text-base font-medium text-gray-700">Ort</dt>
                  <dd class="order-2 text-2xl font-bold text-primary sm:text-xl sm:tracking-tight">{{$estate["elements"]["ort"]}}</dd>
              </div>
            </dl>
        </div>
        </div>
    </li>
  </ul>
</div>