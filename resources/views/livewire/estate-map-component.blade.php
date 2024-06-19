<div class="mx-4 lg:mx-0" wire:ignore>
    <div id="map-container" class="relative w-full" style="height: 66.67vh;">
        <div id="map-consent-container" class="relative w-full" style="height: 66.67vh;">
            <!-- Placeholder image -->
            <img src="{{ asset('img/mapbox_default.webp') }}" alt="Map Placeholder" class="w-full object-cover" style="height: 66.67vh;" />
            <!-- Blurred overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-30 backdrop-blur-sm flex justify-center items-center" style="height: 66.67vh;">
                <!-- Load Content Button (hidden by default) -->
                <button id="load-content-btn" class="hidden px-4 py-2 bg-white text-black font-semibold rounded">Inhalt laden</button>
            </div>
        </div>
        <!-- Map (initially hidden) -->
        <div id='map' class="relative w-full hidden" style="height: 66.67vh;"></div>
    </div>

    <script src='https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css' rel='stylesheet' />

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loadContentBtn = document.getElementById('load-content-btn');
            const mapPlaceholder = document.querySelector('#map-container img');
            const mapContainer = document.getElementById('map');
            const mapContainerConsent = document.getElementById('map-consent-container');

            var map;
            var hoveredStateId = null;
            var geojson = {
                'type': 'FeatureCollection',
                'features': []
            };


            if (getCookie("__cookie_consent") === "true") {
                this.map = initMap(@json($estates), @json($centerLng), @json($centerLat));
            } else {
                loadContentBtn.classList.remove('hidden');
                loadContentBtn.addEventListener('click', function() {
                    document.cookie = "__cookie_consent=true; path=/; max-age=86400"; // Set consent cookie
                    location.reload();
                });
            }

            window.addEventListener('filterUpdated', function(event) {
                if (getCookie("__cookie_consent") === "true") {
                    const estatesData = event.detail;
                    const estates = estatesData.estates; // Access the estates array
                    if (!Array.isArray(estates)) {
                        console.error('Expected estates to be an array, but got:', typeof estates);
                        return;
                    }

                    updateMap(estates, map);
                } else {
                    loadContentBtn.classList.remove('hidden');
                    loadContentBtn.addEventListener('click', function() {
                        document.cookie = "__cookie_consent=true; path=/; max-age=86400"; // Set consent cookie
                        location.reload();
                    });
                }
            });

            function getCookie(name) {
                const nameEQ = name + "=";
                const ca = document.cookie.split(';');
                for (let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
                }
                return null;
            }

            function initMap(estates, longitude, latitude) {
                console.log('Initializing map...')
                mapContainer.style.display = 'block';
                mapPlaceholder.style.display = 'none';
                loadContentBtn.style.display = 'none';
                mapContainerConsent.style.display = 'none';

                mapboxgl.accessToken = '{{ config('api.mapbox.key') }}';

                map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/outdoors-v11',
                    center: [latitude, longitude],
                    zoom: 10,
                    minZoom: 6,
                    maxZoom: 10,
                    cooperativeGestures: isMobile()
                });

                return createMap(estates);
            }

            function createMap(estates) {
                map.on('load', function() {
                    map.resize();
                    geojson = iterateEstates(estates);

                    if (!map.getSource('places')) {
                        map.addSource('places', { 'type': 'geojson', 'data': geojson });
                        map.addLayer({
                            'id': 'places',
                            'type': 'circle',
                            'source': 'places',
                            'paint': {
                                'circle-color': '#2A426E',
                                'circle-radius': ['case', ['boolean', ['feature-state', 'hover'], false], 10, 6],
                                'circle-stroke-width': ['case', ['boolean', ['feature-state', 'hover'], false], 4, 2],
                                'circle-stroke-color': '#ffffff'
                            }
                        });
                    }

                    const popup = new mapboxgl.Popup({ closeButton: false, closeOnClick: false, className: 'no-padding-popup' });

                    map.on('mouseenter', 'places', (e) => {
                        map.getCanvas().style.cursor = 'pointer';
                        if (e.features.length > 0) {
                            if (hoveredStateId !== null) {
                                map.setFeatureState({ source: 'places', id: hoveredStateId }, { hover: false });
                            }
                            hoveredStateId = e.features[0].id;
                            map.setFeatureState({ source: 'places', id: hoveredStateId }, { hover: true });
                        }
                    });

                    map.on('click', 'places', (e) => {
                        const coordinates = e.features[0].geometry.coordinates.slice();
                        const description = e.features[0].properties.description;
                        while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                            coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                        }
                        popup.setLngLat(coordinates).setHTML(description).addTo(map);
                    });

                    map.on('mouseleave', 'places', () => {
                        map.getCanvas().style.cursor = '';
                        if (hoveredStateId !== null) {
                            map.setFeatureState({ source: 'places', id: hoveredStateId }, { hover: false });
                            hoveredStateId = null;
                        }
                    });

                    const bounds = new mapboxgl.LngLatBounds();
                    let validCoordinates = false;

                    geojson.features.forEach(feature => {
                        const coordinates = feature.geometry.coordinates;
                        if (coordinates && coordinates.length === 2 && !isNaN(coordinates[0]) && !isNaN(coordinates[1])) {
                            bounds.extend(coordinates);
                            validCoordinates = true;
                        }
                    });

                    // Check if there are any valid features
                    if (validCoordinates) {
                        map.fitBounds(bounds, { padding: 50, maxZoom: 10 });
                    } else {
                        // Optionally, set a default bounding box if no features are found
                        const defaultBounds = [
                            [12.1280 - 0.1, 47.8561 - 0.1], // Southwest coordinates
                            [12.1280 + 0.1, 47.8561 + 0.1]  // Northeast coordinates
                        ];
                        map.fitBounds(defaultBounds, { padding: 50, maxZoom: 10 });
                    }
                });

                return map;
            }

            function iterateEstates(estates) {
                return {
                    'type': 'FeatureCollection',
                    'features': estates
                        .filter(estate =>
                            estate.laengengrad !== 0 && estate.breitengrad !== 0 &&
                            estate.laengengrad >= -180 && estate.laengengrad <= 180 &&
                            estate.breitengrad >= -90 && estate.breitengrad <= 90 &&
                            !isNaN(estate.laengengrad) && !isNaN(estate.breitengrad)
                        ) // Filter out invalid coordinates
                        .map(estate => {
                            return {
                                'type': 'Feature',
                                'id': estate.id_internal,
                                'properties': {
                                    'description': `
                    <div class="relative">
                        <button class="absolute top-1 rounded-full shadow-md right-1 z-10 bg-white text-black px-2 cursor-pointer" onclick="document.querySelectorAll('.mapboxgl-popup')[0].remove()">&times;</button>
                        <a href="/immobilien/details/${estate.id_internal}" target="_blank">
                            <div class="group relative w-[180px] lg:w-[240px]">
                                <div class="aspect-h-[2/3] aspect-w-1 w-full overflow-hidden bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-40">
                                    ${estate.estate_images && estate.estate_images.length > 0 ? `<img src="${estate.estate_images[0].url}" alt="${estate.estate_images[0].alt}" class="h-full w-full object-cover object-center lg:h-full lg:w-full">` : ''}
                                </div>
                                <div class="px-4 py-1 mt-2">
                                    <h3 class="text-base font-bold text-gray-900">${estate.objekttitel.substring(0, 40)}...</h3>
                                    <div class="hidden lg:flex text-sm col-span-3 space-x-2 text-gray-700 dark:text-gray-400">
                                        <span class="capitalize">${Math.floor(estate.anzahl_zimmer)} Zimmer</span>
                                        <span class="mx-1">·</span>
                                        <span class="ml-2">${Math.floor(estate.wohnflaeche)} m²</span>
                                        <span class="mx-1">·</span>
                                        <span class="ml-2">${Math.floor(estate.kaufpreis).toLocaleString('de-DE')} €</span>
                                    </div>
                                    <div class="flex text-xs col-span-3 space-x-2 text-gray-500 dark:text-gray-400">
                                        <span class="capitalize">${estate.objektart}</span>
                                        <span>in</span>
                                        <span class="capitalize">${estate.plz}, ${estate.ort}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>`
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [estate.laengengrad, estate.breitengrad]
                                }
                            };
                        })
                };
            }

            function isMobile() {
                return /Mobi|Android/i.test(navigator.userAgent);
            }

            function updateMap(estates, map) {
                geojson = iterateEstates(estates);

                if (map.getSource('places')) {
                    map.getSource('places').setData(geojson);
                } else {
                    map.addSource('places', { 'type': 'geojson', 'data': geojson });
                    map.addLayer({
                        'id': 'places',
                        'type': 'circle',
                        'source': 'places',
                        'paint': {
                            'circle-color': '#2A426E',
                            'circle-radius': ['case', ['boolean', ['feature-state', 'hover'], false], 10, 6],
                            'circle-stroke-width': ['case', ['boolean', ['feature-state', 'hover'], false], 4, 2],
                            'circle-stroke-color': '#ffffff'
                        }
                    });
                }

                const bounds = new mapboxgl.LngLatBounds();
                let validCoordinates = false;

                geojson.features.forEach(feature => {
                    const coordinates = feature.geometry.coordinates;
                    if (coordinates && coordinates.length === 2 && !isNaN(coordinates[0]) && !isNaN(coordinates[1])) {
                        bounds.extend(coordinates);
                        validCoordinates = true;
                    }
                });

                // Check if there are any valid features
                if (validCoordinates) {
                    map.fitBounds(bounds, { padding: 50, maxZoom: 10 });
                } else {
                    // Optionally, set a default bounding box if no features are found
                    const defaultBounds = [
                        [12.1280 - 0.1, 47.8561 - 0.1], // Southwest coordinates
                        [12.1280 + 0.1, 47.8561 + 0.1]  // Northeast coordinates
                    ];
                    map.fitBounds(defaultBounds, { padding: 50, maxZoom: 10 });
                }
            }

        });
    </script>
</div>
