<div id='map' class="relative w-full h-full">

</div>

<script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />

<script>
    mapboxgl.accessToken =
        'pk.eyJ1Ijoic2ltb251bHUxOTAxIiwiYSI6ImNsa3Y4Nno1NTBoMW0zZXJ6aXB6YTk3ZGcifQ.vtgWJm98vfUJ28j8ewL8Gg';

    var lng = {{ center_lng }};
    var lat = {{ center_lat }};
    var zoom = {{ zoom }}

    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/light-v10',
        center: [lng, lat],
        zoom: 5
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
</script>
