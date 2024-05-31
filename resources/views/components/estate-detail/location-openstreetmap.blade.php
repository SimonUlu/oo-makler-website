{{-- 
<div id="map" data-lat="{{ $estate['elements']['breitengrad'] }}"
    data-lon="{{ $estate['elements']['laengengrad'] }}"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/openlayers/2.13.1/OpenLayers.js"></script>
<script>
    var mapElement = document.getElementById("map");
    var lon = mapElement.getAttribute("data-lon");
    var lat = mapElement.getAttribute("data-lat");
    console.log(lat);
    var zoom = 10;

    // Erstelle eine OpenLayers Map-Instanz und binde sie an das 'map'-Element
    var map = new OpenLayers.Map("map");

    // Erstelle eine OpenStreetMap-Layer-Instanz und füge sie zur Karte hinzu
    var osmLayer = new OpenLayers.Layer.OSM();
    map.addLayer(osmLayer);

    // Erstelle eine neue Kartenposition und setze die Koordinaten und den Zoom
    var position = new OpenLayers.LonLat(lon, lat).transform(
        new OpenLayers.Projection("EPSG:4326"), // Von WGS 84 (lon/lat)
        map.getProjectionObject() // Zu Spherical Mercator Projection
    );

    // Zentriere die Karte auf die gewünschte Position und setze den Zoom
    map.setCenter(position, zoom);

    // Erstelle einen Kreis-Feature um die Location
    var circle = new OpenLayers.Feature.Vector(
        OpenLayers.Geometry.Polygon.createRegularPolygon(
            new OpenLayers.Geometry.Point(lon, lat).transform(
                new OpenLayers.Projection("EPSG:4326"),
                map.getProjectionObject()
            ),
            10000, // Radius des Kreises in Metern (hier: 10 km)
            40 // Anzahl der Seiten des Polygons (je höher, desto glatter der Kreis)
        ), {}, {
            fillColor: "none", // Füllfarbe des Kreises
            strokeColor: "#2d4571", // Farbe des Kreisrands
            strokeWidth: 2 // Breite des Kreisrands
        }
    );

    // Erstelle eine Vector-Layer-Instanz und füge das Kreis-Feature hinzu
    var vectorLayer = new OpenLayers.Layer.Vector("Circle Layer");
    vectorLayer.addFeatures([circle]);
    map.addLayer(vectorLayer);
</script> --}}
