<div class="mx-4 lg:mx-0">
    <div id="map-container" class="relative w-full h-screen">
        <div id="map-consent-container" class="relative w-full h-screen">
            <!-- Placeholder image -->
            <img src="{{asset('img/mapbox_default.webp')}}" alt="Map Placeholder" class="w-full h-screen object-cover" />
            <!-- Blurred overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-30 backdrop-blur-sm flex justify-center items-center">
                <!-- Load Content Button (hidden by default) -->
                <button id="load-content-btn" class="hidden px-4 py-2 bg-white text-black font-semibold rounded">Inhalt laden</button>
            </div>
        </div>
        <!-- Map (initially hidden) -->
        <div id='map' class="relative w-full h-screen hidden"></div>
    </div>

    <link href='https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css' rel='stylesheet' />
    <script src='https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js'></script>

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
            // loop over all estates and return geojson object
            function iterateEstates(estates) {
                var geojson = {
                    'type': 'FeatureCollection',
                    'features': []
                };

                for (var i = 0; i < estates.length; i++) {
                    var estate = estates[i];

                    var feature = {
                        'type': 'Feature',
                        'id': estate.id,
                        'properties': {
                            'description': `
                        <div class="relative">
                            <button
                                class="absolute top-1 rounded-full shadow-md right-1 z-10 bg-white text-black px-2 cursor-pointer"
                                onclick="document.querySelectorAll('.mapboxgl-popup')[0].remove()">
                                &times;
                            </button>
                            <a href="/immobilien/details/${estate.id}" target="_blank">
                                <div class="group relative w-[180px] lg:w-[240px]">
                                    <div class="aspect-h-[2/3] aspect-w-1 w-full overflow-hidden bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-40">
                                        <img src="${estate.elements.images[0]?.url}" alt="${estate.elements.images[0]?.alt}" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                                    </div>
                                    <div class="px-4 py-1 mt-2">
                                        <div >
                                            <h3 class="text-base font-bold text-gray-900">
                                                ${Math.floor(estate.elements.kaufpreis).toLocaleString('de-DE')} €
                                            </h3>
                                        </div>
                                        <div class="hidden lg:flex text-sm col-span-3 space-x-2 text-gray-700 dark:text-gray-400">
                                            <span class="capitalize">
                                                ${Math.floor(estate.elements.anzahl_zimmer)} Zimmer
                                            </span>
                                            <span class="mx-1">
                                                ·
                                            </span>
                                            <span class="ml-2">
                                                ${Math.floor(estate.elements.wohnflaeche)} m²
                                            </span>
                                        </div>
                                        <div class="flex text-xs col-span-3 space-x-2 text-gray-500 dark:text-gray-400">
                                            <span class="capitalize">
                                                ${estate.elements.objektart}
                                            </span>
                                            <span>
                                                in
                                            </span>
                                            <span class="ml-2 capitalize">
                                                ${estate.elements.plz}, ${estate.elements.ort}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
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
                return geojson;
            }

            // Add layers such as popups and other stuff
            function createMap(estates) {
                var map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/outdoors-v11',
                    center: [@json($center_lat), @json($center_lng)],
                    zoom: @json($zoom)
                });
                var hoveredStateId = null;
                // Fügen Sie bei Kartenladung Marker hinzu
                map.on('load', function() {
                    map.resize();

                    var geojson = iterateEstates(estates);

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
                            'circle-color': '#2A426E',
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

                    const popup = new mapboxgl.Popup({
                        closeButton: false,
                        closeOnClick: false,
                        className: 'no-padding-popup'
                    });


                    map.on('mouseenter', 'places', (e) => {
                        map.getCanvas().style.cursor = 'pointer';
                        if (e.features.length > 0) {
                            if (hoveredStateId) {
                                map.setFeatureState({
                                    source: 'places',
                                    id: hoveredStateId
                                }, {
                                    hover: false
                                });
                            }
                            hoveredStateId = e.features[0].id;
                            map.setFeatureState({
                                source: 'places',
                                id: hoveredStateId
                            }, {
                                hover: true
                            });
                        }
                    })

                    map.on('click', 'places', (e) => {
                        console.log(estates);
                        const coordinates = e.features[0].geometry.coordinates.slice();
                        const description = e.features[0].properties.description;

                        while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                            coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                        }
                        popup.setLngLat(coordinates).setHTML(description).addTo(map);
                    });

                    map.on('mouseleave', 'places', () => {
                        map.getCanvas().style.cursor = '';
                        if (hoveredStateId) {
                            map.setFeatureState({
                                source: 'places',
                                id: hoveredStateId
                            }, {
                                hover: false
                            });
                        }
                        hoveredStateId = null;
                    });
                });
                return map;
            }

            function initMap() {
                mapContainer.style.display = 'block';
                mapPlaceholder.style.display = 'none';
                loadContentBtn.style.display = 'none';
                mapContainerConsent.style.display = 'none';
                // Init setup of estate map
                mapboxgl.accessToken = '{{ config('api.mapbox.key') }}';
                var map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/outdoors-v11',
                    center: [@json($center_lat), @json($center_lng)],
                    zoom: @json($zoom),
                    cooperativeGestures: true,
                });
                map = createMap(@json($estates), map);
            }

            

            window.addEventListener('filterUpdated', function(event) {
                if(getCookie("__cookie_consent") === "true") {
                    initMap();
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

            if(getCookie("__cookie_consent") === "true") {
                initMap();
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
