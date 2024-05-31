<section class="border-t border-b my-6 px-4 lg:px-0 lg:my-12 py-8 lg:py-16 mx-4 lg:mx-10">

    <div class="flex flex-col sm:flex-row justify-center items-start w-full">
        <div class="text-left mb-4 sm:mr-4">
            <h2 class="text-2xl font-semibold mb-2">Ihr persönlicher Ansprechpartner für dieses Projekt</h2>
            <p class="text-lg">
                Sie wollen den Verkauf allein stemmen und brauchen keinen Makler? Kein Problem, in unserem Video erfahren Sie schon mal, wie Sie am besten vorgehen. Achtung: Das Szenario ist natürlich mit einem Augenzwinkern zu verstehen. Sie können bei uns auch gerne Teilleistungen beauftragen. Zum Beispiel übernehmen wir das Besichtigungsmanagement für Sie. Unten sehen Sie eine Übersicht all unserer Leistungen.
            </p>
        </div>
        <div class="flex items-center justify-center flex-row items-start sm:items-center sm:justify-between">
            <div class="mb-4 sm:mb-0 sm:mr-4">
                <h3 class="text-xl font-semibold mb-2 gap-x-1">{{$onOfficeUser->vorname}} {{$onOfficeUser->nachname}}</h3>
                <p class="text-lg italic mb-4">Projektbeauftragter</p>
                {{-- <a class="block mb-2" href="tel:&nbsp;{{$onOfficeUser->}}">{{$onOfficeUser["elements"]["Telefon"]}}</a> --}}
                <a class="block" href="mailto:{{$onOfficeUser->email}}">{{$onOfficeUser->email}}</a>
            </div>
            <div class="w-40 ml-4 lg:ml-0">
                <img class="w-full" src="data:image/png;base64,{{ $onOfficeUser->picUrl }}" alt="Ansprechpartner Neubauprojekt">
            </div>
        </div>
    </div>
</section>
