<div id="map-container" class="relative w-full h-full">
    <div id="map-consent-container" class="relative w-full h-auto">
        <!-- Placeholder image -->
        <img src="{{ asset('img/mapbox_default.webp') }}" alt="Map Placeholder" class="object-cover w-full h-auto" />
        <!-- Blurred overlay -->
        <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30 backdrop-blur-sm">
            <!-- Load Content Button (hidden by default) -->
            <button id="load-content-btn" class="hidden px-4 py-2 font-semibold text-black bg-white rounded">Inhalt
                laden</button>
        </div>
    </div>
    <!-- Map (initially hidden) -->
    <div id='map' class="relative hidden w-full h-full"></div>
</div>

<script src='https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css' rel='stylesheet' />

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var loadContentBtn = document.getElementById('load-content-btn');
        var mapPlaceholder = document.querySelector('#map-container img');
        var mapContainer = document.getElementById('map');
        var mapContainerConsent = document.getElementById('map-consent-container');

        // Function to get the value of a specific cookie by name
        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        // Function to initialize and display the map
        function initMap() {
            mapContainer.style.display = 'block';
            mapPlaceholder.style.display = 'none';
            loadContentBtn.style.display = 'none';
            mapContainerConsent.style.display = 'none';

            mapboxgl.accessToken = '{{ config('api.mapbox.key') }}';

            var lng = '{{ $estate['laengengrad'] }}';
            var lat = '{{ $estate['breitengrad'] }}';

            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/light-v10',
                center: [lng, lat],
                zoom: 12,
                maxZoom: 14,
                cooperativeGestures: true
            });

            // Add an image to use as a custom marker
            map.on('load', function() {

                map.resize();

                map.loadImage(
                    '/app_images/map/house_icon_outlined.png', // Replace this with the path to your image
                    function(error, image) {
                        if (error) throw error;
                        map.addImage('custom-marker', image);

                        // Add a geojson point
                        map.addSource('point', {
                            'type': 'geojson',
                            'data': {
                                'type': 'FeatureCollection',
                                'features': [{
                                    'type': 'Feature',
                                    'geometry': {
                                        'type': 'Point',
                                        'coordinates': [lng, lat]
                                    }
                                }]
                            }
                        });

                        // Add a symbol layer
                        map.addLayer({
                            'id': 'points',
                            'type': 'symbol',
                            'source': 'point',
                            'layout': {
                                'icon-image': 'custom-marker',
                                'icon-size': 0.03
                            }
                        });
                    }
                );

            });
        }

        if (getCookie("__cookie_consent") === "true") {
            initMap(); // Initialize and display the map immediately if consent is given
        } else {
            // Show the button if consent is not given
            loadContentBtn.classList.remove('hidden');
            loadContentBtn.addEventListener('click', function() {
                document.cookie = "__cookie_consent=true; path=/; max-age=86400"; // Set consent cookie
                initMap(); // Load the map after consent
            });
        }
    });
</script>
