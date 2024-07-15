<div class="max-w-7xl px-4 lg:px-10 mx-auto">
    <div class="relative w-full bg-primary-100 mt-10 mb-12">
        <div class="grid grid-cols-2 pt-12 m-auto md:space-x-4 w-full">
            <div class="relative col-span-2 min-h-[450px] sm:min-h-[500px] md:min-h-[550px] lg:min-h-[600px] w-full min-w-[400px] md:min-w-[700px] lg:min-w-[950px] lg:w-full">
                <div id='map-two' class="relative w-full h-full">
                    
                </div>
                <div id="modal" class="hidden absolute bg-white p-5 rounded-2 max-w-md z-10"
                        style="
                        @media (max-width: 760px) {
                            top: 20% !important;
                            left: 20% !important;
                            max-width: 60% !important;
                        }">
                        <!-- Schließen-Symbol (X) -->
                        <span id="close-modal" class="absolute top-0 right-0 p-2 cursor-pointer">&times;</span>
        
                        <!-- Modal-Inhalt -->
                        <div id="modal-description"></div>
                    </div>
                
            </div>
        </div>
    </div>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />

    <script>
        // Mapbox Javascript Stuff shhs
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2ltb251bHUxOTAxIiwiYSI6ImNsa3Y4Nno1NTBoMW0zZXJ6aXB6YTk3ZGcifQ.vtgWJm98vfUJ28j8ewL8Gg';

        var locationData = @json($locations);

        let = locations = JSON.parse(locationData);

        console.log(locations);

        var lng = '13.25';
        var lat = '52.50';
        var zoom = '8';

        var map_two = new mapboxgl.Map({
            container: 'map-two',
            style: 'mapbox://styles/mapbox/light-v10',
            center: [lng, lat],
            zoom: zoom
        });

        map_two.on('load', function() {
            // Durchlaufe jedes Objekt in der 'locations'-Liste
            locations.forEach(function(location) {
                // Überprüfe, ob sowohl 'longitude' als auch 'latitude' vorhanden sind
                if (location.longitude && location.latitude) {

                    // Erstelle einen neuen Marker
                    var marker = new mapboxgl.Marker({
                        color: "#003064"
                    })
                    .setLngLat([location.longitude, location.latitude]) // Setze die Position des Markers
                    .addTo(map_two); // Füge den Marker zur Karte hinzu

                    // Füge dem Marker ein 'click'-Ereignis hinzu, um das Modal anzuzeigen
                    marker.getElement().addEventListener('click', (e) => {
                        var modal = document.getElementById('modal');
                        var modalDescription = document.getElementById('modal-description');

                        // Zeige das Modal an
                        modal.classList.remove("hidden");

                        // Aktualisiere den Inhalt des Modals
                        modalDescription.innerHTML = `
                            <h3 class="text-base text-gray-900 font-medium">${location.title}</h3>
                            <p class="text-sm">${location.street}</p>
                            <p class="text-sm">${location.ort}</p>

                            <h3 class="text-base text-gray-900 font-medium pt-4">Ansprechpartner/in</h3>
                            <p class="text-sm text-primary font-bold">${location.ansprechpartner}</p>
                            <p class="text-sm text-secondary font-bold">${location.ansprechpartner_function}</p>

                            <div class="flex pt-4">
                                <a href="mailto:${location.mail}">
                                    <span class="text-sm text-gray-800 flex">
                                        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51m16.5 1.615a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V8.844a2.25 2.25 0 011.183-1.98l7.5-4.04a2.25 2.25 0 012.134 0l7.5 4.04a2.25 2.25 0 011.183 1.98V19.5z"></path>
                                        </svg>
                                        ${location.mail}
                                    </span>
                                </a>
                            </div>

                            <div class="flex pb-4">
                                <a href="tel:${location.phone}">
                                    <span class="text-sm text-gray-800 flex">
                                        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"></path>
                                        </svg>
                                        ${location.phone}
                                    </span>
                                </a>
                            </div>
                        `;

                        // Anpassen des Modals für verschiedene Bildschirmgrößen
                        if (window.matchMedia("(max-width: 860px)").matches) {
                            // Für Mobilgeräte
                            modal.style.top = '20%';
                            modal.style.left = '20%';
                            modal.style.maxWidth = "60%";
                        } else {
                            // Für größere Bildschirme, positioniere das Modal direkt über der Klickposition
                            var modalRect = modal.getBoundingClientRect();
                            console.log(modalRect);

                            // Stelle sicher, dass das Modal oben und links von der Klickposition erscheint
                            var topPosition = e.clientY - modalRect.height;
                            var leftPosition = e.clientX - modalRect.width;

                            // Verhindere, dass das Modal außerhalb des sichtbaren Bereichs platziert wird
                            if (topPosition < 0) {
                                topPosition = e.clientY; // Falls oben kein Platz ist, positioniere es unter dem Klick
                            }
                            if (leftPosition < 0) {
                                leftPosition = e.clientX; // Falls links kein Platz ist, positioniere es rechts vom Klick
                            }

                            modal.style.top = topPosition + 'px';
                            modal.style.left = leftPosition - 150 + 'px';
                        }
                    });
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("modal");
            const closeModalButton = document.getElementById("close-modal");

            // Funktion zum Schließen des Modals
            function closeModal() {
                modal.classList.add("hidden");
            }

            // Event-Handler für Klicken des Schließen-Symbols
            closeModalButton.addEventListener("click", closeModal);
        });


    </script>


</div>

