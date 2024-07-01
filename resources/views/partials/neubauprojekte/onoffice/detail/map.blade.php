<div class="justify-center items-center gap-x-8 max-w-7xl mx-auto py-6 lg:py-12 px-4 lg:px-10">

    <div id='map' class="relative w-full h-full min-h-[600px]"></div>

    <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />

    <script>
        mapboxgl.accessToken = '{{ config('api.mapbox.key') }}';

        var lng = '{{ $estate['elements']['laengengrad'] }}';
        var lat = '{{ $estate['elements']['breitengrad'] }}';

        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/outdoors-v11',
            center: [9.933333, 49.783333],
            zoom: 9
        });
        console.log(map);

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
                                    'coordinates': [9.933333, 49.783333],
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
    </script>
</div>
