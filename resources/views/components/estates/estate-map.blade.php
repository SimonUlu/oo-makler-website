
<div>

    <div id="map-container" class="relative w-full h-full">
        <div id="map-consent-container" class="relative w-full h-screen">
            <!-- Placeholder image -->
            <img src="{{asset('img/mapbox_default.webp')}}" alt="Map Placeholder" class="w-full h-screen object-cover" />
            <!-- Blurred overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-30 backdrop-blur-sm flex justify-center items-center">
                <!-- Load Content Button (hidden by default) -->
                <button id="load-content-btn" class="hidden px-4 py-2 bg-white text-black font-semibold rounded">Inhalt laden</button>
            </div>
        </div>
        <div id='map' class="relative w-full h-screen hidden"></div>
    </div>
    <script src='https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css' rel='stylesheet' />

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var loadContentBtn = document.getElementById('load-content-btn');
            var mapPlaceholder = document.querySelector('#map-container img');
            var mapContainer = document.getElementById('map');
            var mapContainerConsent = document.getElementById('map-consent-container');
            function getCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for(var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
                }
                return null;
            }
            function initMap() {
                mapContainer.style.display = 'block';
                mapPlaceholder.style.display = 'none';
                loadContentBtn.style.display = 'none';
                mapContainerConsent.style.display = 'none';
                mapboxgl.accessToken = '{{ config('api.mapbox.key') }}';
                var map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/outdoors-v11',
                    center: [9.933333, 49.783333],
                    zoom: 11,
                    cooperativeGestures: true,
                });
                var hoveredStateId = null;
                // Pfeifen Sie Ihre Immobilieninformationen durch
                var estates = @json($estates);
                // Fügen Sie bei Kartenladung Marker hinzu
                map.on('load', function() {
                    map.resize();
                    var geojson = {
                        'type': 'FeatureCollection',
                        'features': []
                    };
                    // Iterieren Sie durch jede Estate
                    for (var i = 0; i < estates.length; i++) {
                        var estate = estates[i];
                        // Erstellen Sie ein Feature für diese Estate
                        var feature = {
                            'type': 'Feature',
                            'id': estate.id,
                            'properties': {
                                'description': `
                                    <a href="/immobilien/details/${estate.id}" target="_blank">
                                        <div class="group relative">
                                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-40">
                                                <img src="${estate.elements.images[0].url}" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                                            </div>
                                            <div>
                                                <h3 class="text-base py-2 font-bold text-gray-900">
                                                        ${estate.elements.kaufpreis}
                                                </h3>
                                            </div>
                                            <div class="flex text-sm col-span-3 space-x-2 text-gray-500 dark:text-gray-400">
                                                <span class="capitalize">
                                                    ${estate.elements.objektart}
                                                </span>
                                                <span class="mx-1">
                                                    ·
                                                </span>
                                                <span class="ml-2">
                                                    ${estate.elements.wohnflaeche}
                                                </span>

                                            </div>
                                        </div>
                                    </a>
                                `
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [estate.elements.laengengrad, estate.elements.breitengrad]
                    }
                };

                // Fügen Sie dieses Feature zur Liste der Features hinzu
                geojson.features.push(feature);
            }


            map.addSource('places', {
                'type': 'geojson',
                'data': geojson
            });


            // Add a layer showing the places.
            map.addLayer({
                'id': 'places',
                'type': 'circle',
                'source': 'places',
                'paint': {
                    'circle-color': 'red',
                    'circle-radius': [
                        'case',
                            ['boolean', ['feature-state', 'hover'], false],
                            10,
                            6
                        ],
                    'circle-stroke-width': [
                        'case',
                        ['boolean', ['feature-state', 'hover'], false],
                        4,
                        2
                    ],
                    'circle-stroke-color': '#ffffff'
                }
            });

            // Create a popup, but don't add it to the map yet.
            const popup = new mapboxgl.Popup({
                    closeButton: false,
                    closeOnClick: false
                });
                // Styling while hovering
                map.on('mouseenter', 'places', (e) => {
                    // Change the cursor style as a UI indicator.
                    map.getCanvas().style.cursor = 'pointer';
                    if (e.features.length > 0) {
                        if (hoveredStateId) {
                            map.setFeatureState(
                                { source: 'places', id: hoveredStateId },
                                { hover: false }
                            );
                        }
                        hoveredStateId = e.features[0].id;
                        map.setFeatureState(
                            { source: 'places', id: hoveredStateId },
                            { hover: true }
                        );
                    }
                })
                // Display Popup when clicking
                map.on('click', 'places', (e) => {
                    console.log(estates);
                    // Copy coordinates array.
                    const coordinates = e.features[0].geometry.coordinates.slice();
                    const description = e.features[0].properties.description;
                    // Ensure that if the map is zoomed out such that multiple
                    // copies of the feature are visible, the popup appears
                    // over the copy being pointed to.
                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }
                    // Populate the popup and set its coordinates
                    // based on the feature found.
                    popup.setLngLat(coordinates).setHTML(description).addTo(map);
                });
                // Remove style when hovering
                map.on('mouseleave', 'places', () => {
                    map.getCanvas().style.cursor = '';
                    if (hoveredStateId) {
                        map.setFeatureState(
                            { source: 'places', id: hoveredStateId },
                            { hover: false }
                        );
                    }
                    hoveredStateId = null;
                });
            });
            window.addEventListener('filterUpdated', function(event) {
                console.log("Hallo");
                const estates = event.detail.estates;
                // Aktualisieren Sie hier Ihre Karte mit den neuen estates
                //Zum Beispiel könnten Sie die Datenquelle entfernen und dann eine neue hinzufügen:
                if (map.getSource('places')) {
                    map.removeSource('places');
                    map.removeLayer('places');
                }
                var geojson = {
                    'type': 'FeatureCollection',
                    'features': []
                };
                // Iterieren Sie durch jede Estate
                for (var i = 0; i < estates.length; i++) {
                    var estate = estates[i];
                    // Erstellen Sie ein Feature für diese Estate
                    var feature = {
                        'type': 'Feature',
                        'id': estate.id,
                        'properties': {
                            'description': `
                            <a href="/immobilien/details/${estate.id}" target="_blank">
                                <div class="group relative">
                                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-40">
	@@ -213,45 +246,58 @@
                                </div>
                            </a>
                        `
                        },
                        'geometry': {
                            'type': 'Point',
                            'coordinates': [estate.elements.laengengrad, estate.elements.breitengrad]
                        }
                    };
                    // Fügen Sie dieses Feature zur Liste der Features hinzu
                    geojson.features.push(feature);
                }
                map.addSource('places', {
                    'type': 'geojson',
                    'data': geojson
                });
                // Fügen Sie die Layer neu hinzu
                // Add a layer showing the places.
                map.addLayer({
                    'id': 'places',
                    'type': 'circle',
                    'source': 'places',
                    'paint': {
                        'circle-color': 'red',
                        'circle-radius': [
                            'case',
                            ['boolean', ['feature-state', 'hover'], false],
                            10,
                            6
                        ],
                        'circle-stroke-width': [
                            'case',
                            ['boolean', ['feature-state', 'hover'], false],
                            4,
                            2
                        ],
                        'circle-stroke-color': '#ffffff'
                    }
                });
            });
        }
        if(getCookie("__cookie_consent") === "true") {
            initMap(); // Initialize and display the map immediately if consent is given
        } else {
            // Show the button if consent is not given
            loadContentBtn.classList.remove('hidden');
            loadContentBtn.addEventListener('click', function() {
                document.cookie = "__cookie_consent=true; path=/; max-age=86400"; // Set consent cookie
                // refresh the page
                location.reload();
            });
        }
    });
</script>
</div>
