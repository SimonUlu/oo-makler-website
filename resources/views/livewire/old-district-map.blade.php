<div>
    <div class="relative w-full bg-primary-100 mt-10 mb-12">
        <div class="grid grid-cols-2 pt-12 m-auto md:space-x-4 w-full">
            <div class="col-span-2 min-h-[450px] sm:min-h-[500px] md:min-h-[550px] lg:min-h-[600px] w-full min-w-[400px] md:min-w-[700px] lg:min-w-[950px]">
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
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2ltb251bHUxOTAxIiwiYSI6ImNsa3Y4Nno1NTBoMW0zZXJ6aXB6YTk3ZGcifQ.vtgWJm98vfUJ28j8ewL8Gg';;

        var lng = '{{ $mapLong }}';
        var lat = '{{ $mapLat}}';
        var zoom = '{{ $zoom }}';

        var geoJsonData = @json($districtJson);
        // Umwandlung des JSON-Strings in ein JavaScript-Objekt
        var geoJsonObj = JSON.parse(geoJsonData);

        var districtCollectionData = @json($districts);
        let = districtJsonObj = JSON.parse(districtCollectionData);


        // Extrahiere die Postleitzahlen aus der plzList und erstelle ein Array mit diesen Postleitzahlen
        var plzArray = geoJsonObj.map(function(item) {
            return item.plz_code;
        });


        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/light-v10',
            center: [lng, lat],
            zoom: zoom
        });

        let lastHoveredFeatureId;

        // get color based on cp settings
        function getColor(plz) {
            // Durchlaufe das districtJson-Array, um die Farbe basierend auf der Postleitzahl zu finden
            for (var i = 0; i < districtJsonObj.length; i++) {
                var entry = districtJsonObj[i];
                if (entry.plz === plz) {
                    return entry.fill_color;
                }
            }
            // Rückgabe einer Standardfarbe, falls keine Übereinstimmung gefunden wurde
            return '#FFFF00';
        }
        // get color based on cp settings
        function getDescription(plz) {
            // Durchlaufe das geoJsonObj-Array, um die Farbe basierend auf der Postleitzahl zu finden
            for (var i = 0; i < districtJsonObj.length; i++) {
                var entry = districtJsonObj[i];
                if (entry.plz === plz) {
                    return entry.description.code;
                }
            }
            // Rückgabe einer Standardfarbe, falls keine Übereinstimmung gefunden wurde
            return 'Das ist die Standard Description';
        }


        // Filtere die GeoJSON-Features basierend auf der Übereinstimmung der Postleitzahlen
        var filteredFeatures = geoJsonObj.filter(function(feature) {
            var plz_code = feature.plz_code;
            return plzArray.includes(plz_code);
        });

        // Erstelle ein neues GeoJSON-Objekt mit den gefilterten Features
        var filteredGeoJson = {
            'type': 'FeatureCollection',
            'features': filteredFeatures
        };

        // Iteriere über die GeoJSON-Features und setze die Farbe basierend auf der Übereinstimmung der Postleitzahlen
        filteredGeoJson.features.forEach(function(feature, index) {
            var plz_code = feature.plz_code;
            feature.id = plz_code; // Eindeutige ID jedem Feature zuweisen.
            if (!feature.properties) {
                feature.properties = {};
            }
            feature.properties.color = getColor(plz_code);
            feature.properties.description = getDescription(plz_code);
            feature.properties.plz_code = plz_code;
        });
        console.log(filteredGeoJson);

        map.on('load', function() {
            map.addSource('postalCodes', {
                'type': 'geojson',
                'data': filteredGeoJson
            });

            map.addLayer({
                'id': 'postalCodeAreas',
                'type': 'fill',
                'source': 'postalCodes',
                'paint': {
                    'fill-color': [
                        'case',
                        ['boolean', ['feature-state', 'clicked'], false],
                        'transparent',
                        ['get', 'color']
                    ],
                    'fill-opacity': [
                        'case',
                        ['boolean', ['feature-state', 'hover'], false],
                        1,
                        0.6
                    ],
                    'fill-outline-color': '#000000',
                },
            });
            districtJsonObj.forEach(function(entry) {
                console.log(entry.plz);
                // Mache cursor pointer wenn reingeht
                map.on('mousemove', 'postalCodeAreas', function(e) {
                    var featuresUnderMouse = map.queryRenderedFeatures(e.point, { layers: ['postalCodeAreas'] });
                    if (featuresUnderMouse.length > 0) {
                        var featurePlzId = featuresUnderMouse[0].properties.plz_code;
                        // Überprüfen, ob die ID des Features einer der ausgewählten ist
                        if (plzArray.includes(featurePlzId)) {
                            map.getCanvas().style.cursor = 'pointer';
                            if (lastHoveredFeatureId !== featurePlzId) {
                                // Setzen Sie den hover state des vorherigen Features zurück, falls vorhanden
                                if (lastHoveredFeatureId !== null) {
                                    map.setFeatureState(
                                        {source: 'postalCodes', id: lastHoveredFeatureId},
                                        { hover: false }
                                    );
                                }
                                // Aktualisieren der lastHoveredFeatureId mit der neuesten featurePlzId
                                lastHoveredFeatureId = featurePlzId;
                                map.setFeatureState(
                                    {source: 'postalCodes', id: featurePlzId},
                                    { hover: true }
                                );
                            }
                        }
                    } else {
                        // Wenn keine Features unter dem Mauszeiger sind, setzen Sie den Hover-State des letzten gehoverten Features zurück
                        if (lastHoveredFeatureId !== null) {
                            map.setFeatureState(
                                {source: 'postalCodes', id: lastHoveredFeatureId},
                                { hover: false }
                            );
                            lastHoveredFeatureId = null;
                        }
                        map.getCanvas().style.cursor = '';
                    }
                });
                map.on('mouseleave', 'postalCodeAreas', function() {
                    map.getCanvas().style.cursor = '';
                    if (lastHoveredFeatureId) {
                        map.setFeatureState(
                            {source: 'postalCodes', id: lastHoveredFeatureId},
                            { hover: false }
                        );
                        lastHoveredFeatureId = null; // Zurücksetzen der lastHoveredFeatureId
                    }
                });
                map.on('click', 'postalCodeAreas', function (e) {
                    var modal = document.getElementById("modal");
                    var modalDescription = document.getElementById("modal-description");
                    var featuresUnderMouse = map.queryRenderedFeatures(e.point, { layers: ['postalCodeAreas'] });
                    modal.classList.remove("hidden"); // Shows the modal
                    if (window.matchMedia("(max-width: 860px)").matches) {
                        // Wenn der Bildschirm kleiner oder gleich 760px ist, ändern Sie die Modal-Position
                        modal.style.top = '20%';
                        modal.style.left = '20%';
                        modal.style.maxWidth = "60%";
                        var description = featuresUnderMouse[0].properties.description;
                    } else {
                        modal.style.top = (e.point.y) + 'px'; // Set modal position to mouse y
                        modal.style.left = (e.point.x) + 'px'; // Set modal position to mouse x
                        var description = featuresUnderMouse[0].properties.description;
                    }
                    if (featuresUnderMouse.length > 0) {
                        modalDescription.innerHTML = description;
                    }
                });
                map.on('mouseenter', 'postalCodeAreas', function(e) {
                    var featuresUnderMouse = map.queryRenderedFeatures(e.point, { layers: ['postalCodeAreas'] });
                    if (featuresUnderMouse.length > 0) {
                        var featurePlzId = featuresUnderMouse[0].properties.plz_code;

                        // Überprüfen, ob die ID des Features einer der ausgewählten ist
                        if (plzArray.includes(featurePlzId)) {
                            if (lastHoveredFeatureId !== null && lastHoveredFeatureId !== featurePlzId) {
                                map.setFeatureState(
                                    {source: 'postalCodes', id: lastHoveredFeatureId},
                                    { hover: false }
                                );
                            }
                             // Aktualisieren der lastHoveredFeatureId mit der neuesten featurePlzId
                            lastHoveredFeatureId = featurePlzId;
                            map.setFeatureState(
                                {source: 'postalCodes', id: featurePlzId},
                                { hover: true }
                            );
                            // Code zum Öffnen von Modal
                        }
                    }
                });
            })
        });


        // JavaScript-Code nach dem DOM geladen wurde
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

