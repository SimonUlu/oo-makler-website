<div class="max-w-7xl px-4 lg:px-10 mx-auto">
    <div class="relative w-full bg-primary-100 mt-10 mb-12">
        <div class="grid grid-cols-2 pt-12 m-auto md:space-x-4 w-full">
            <div class="relative col-span-2 min-h-[450px] sm:min-h-[500px] md:min-h-[550px] lg:min-h-[600px] w-full min-w-[400px] md:min-w-[700px] lg:min-w-[950px] lg:w-full">
                <div id='map' class="relative w-full h-full">
                    
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
        // Mapbox Javascript Stuff
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2ltb251bHUxOTAxIiwiYSI6ImNsa3Y4Nno1NTBoMW0zZXJ6aXB6YTk3ZGcifQ.vtgWJm98vfUJ28j8ewL8Gg';

        var locationData = @json($locations);

        let = locations = JSON.parse(locationData);

        console.log(locations);

        var lng = '13.25';
        var lat = '52.50';
        var zoom = '8';

        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/light-v10',
            center: [lng, lat],
            zoom: zoom
        });

        map.on('load', function() {
            // Durchlaufe jedes Objekt in der 'locations'-Liste
            locations.forEach(function(location) {
                // Überprüfe, ob sowohl 'longitude' als auch 'latitude' vorhanden sind
                if (location.longitude && location.latitude) {

                    // Erstelle einen neuen Marker
                    var marker = new mapboxgl.Marker({
                        color: "#003064"
                    })
                    .setLngLat([location.longitude, location.latitude]) // Setze die Position des Markers
                    .addTo(map); // Füge den Marker zur Karte hinzu

                    // Füge dem Marker ein 'click'-Ereignis hinzu, um das Modal anzuzeigen
                    marker.getElement().addEventListener('click', (e) => {
                        var modal = document.getElementById('modal');
                        var modalDescription = document.getElementById('modal-description');

                        // Zeige das Modal an
                        modal.classList.remove("hidden");

                        // Aktualisiere den Inhalt des Modals
                        modalDescription.innerHTML = `
                            <h3 class="text-xl text-primary-600 font-medium">${location.title}</h3>
                            <p class="text-sm my-2">${location.description}</p>

                            <a href="/stadtteile/sanderau" class="inline-flex justify-center items-center py-2.5 px-5 text-sm font-medium text-center text-white rounded-lg md:w-auto lg:col-span-12 focus:ring-4 focus:outline-none bg-primary-700 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 hover:bg-primary-800 focus:ring-primary-300">Mehr erfahren<span aria-hidden="true">&nbsp;→</span></a>
                        `;

                        // Anpassen des Modals für verschiedene Bildschirmgrößen
                        if (window.matchMedia("(max-width: 860px)").matches) {
                            // Für Mobilgeräte
                            modal.style.top = '20%';
                            modal.style.left = '20%';
                            modal.style.maxWidth = "60%";
                        } else {
                            // Für größere Bildschirme, positioniere das Modal basierend auf der Position des Mausklicks
                            // Da `e` hier nicht direkt die Klickposition liefert, müssen wir einen anderen Ansatz wählen
                            var modalRect = modal.getBoundingClientRect();
                            modal.style.top = (e.clientY - modalRect.height / 2) + 'px';
                            modal.style.left = (e.clientX - modalRect.width / 2) + 'px';
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

