<div class="w-full bg-white py-12 lg:py-16">
    <div class="max-w-7xl px-4 lg:px-10 mx-auto flex w-full justify-between lg:space-x-8">
            <div class="mb-4 w-full max-w-[50%]">
                <label for="search" class="block text-gray-700">Suche</label>
                <input 
                    wire:model.debounce.300ms="searchString" 
                    id="search" 
                    name="search" 
                    type="text" 
                    placeholder="Nach Fragen suchen ..." 
                    class="mt-1 p-2 w-full border border-gray-300 "
                >
            </div>
            <div>
                <label for="category" class="block text-gray-700">Kategorie wählen</label>
                <select id="category" name="category" class="capitalize mt-1 p-2 min-w-[200px] border border-gray-300 ">
                    <option value="">Alle Kategorien</option>
                    @foreach ($orderedEntries as $key => $value)
                        <option class="capitalize" value="{{ $key }}">{{ $key }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    <div class="max-w-7xl px-4 lg:px-10 mx-auto">
        @foreach ($orderedEntries as $key => $value)
        <div class="py-6 lg:py-12" id="{{$key}}">
            <h2 class="text-4xl font-bold tracking-tight text-primary lg:text-5xl mb-8">
                {{$key}}
            </h2>
            <div class="mt-20">
                

                    <dl class="space-y-16 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-16 sm:space-y-0 lg:grid-cols-2 lg:gap-x-10">
                        @foreach ($value as $question)
                            <div>
                                <dt class="text-base font-semibold leading-7 text-gray-900">
                                    {{$question["title"]}}
                                </dt>
                                <dd class="mt-2 text-base leading-7 text-gray-600">
                                    {!!$question["erklaerung"]!!}    
                                </dd>
                            </div>
                        @endforeach
                
                    </dl>
                    

                
            </div>
        </div>  
        @endforeach

    </div>

    <script>
        document.getElementById('category').addEventListener('change', function() {
            var selectedOption = this.value;
            // Prüfen, ob eine Kategorie ausgewählt wurde
            if(selectedOption) {
                // Aktualisieren des Ankerpunkts in der URL, ohne die Seite neu zu laden
                window.location.hash = selectedOption;
            } else {
                // Entfernen des Ankerpunkts, wenn "Alle Kategorien" ausgewählt ist
                history.pushState("", document.title, window.location.pathname + window.location.search);
            }
        });
    </script>

</div>
