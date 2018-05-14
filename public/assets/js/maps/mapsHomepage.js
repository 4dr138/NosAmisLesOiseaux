var icon = '../../../assets/js/maps/images/icon_maps.png';
var markers = [];
var markersDeleted = [];

function initMap(observations = null) {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 5,
        center: {lat: 46.528635, lng: 2.4389648} // france
    });

    var urlObsForMaps = Routing.generate('getObservationsForMap', { birdID: null }, false);

    if (null === observations) {
        $.ajax({
            url: urlObsForMaps,
            type: 'GET',
            dataType: "json",
            success: function(data){
                markers = [];
                for(var i = 0; i < data.length; i++) {
                    var latLng = {
                        'lat': parseFloat(data[i].latitude),
                        'lng': parseFloat(data[i].longitude)
                    };

                    var marker = new google.maps.Marker({
                        position: latLng,
                        icon: icon,
                        title: data[i].taxrefVern,
                        protected: data[i].protected
                    });

                    markers.push(marker);
                }

                // Add a marker clusterer to manage the markers.
                markerCluster = new MarkerClusterer(map, markers,
                    {imagePath: "../../../assets/js/maps/images/m"});
            }
        });
    } else {
        if(observations.length === 0)
        {
            $("#alert_map").remove();
            $('<p id="alert_map" style = "color: red;text-align: center;">Aucune observation enregistrée chez cette espèce pour le moment</p>').insertAfter($("#map"));
        }
        else
        {
            markers = [];
            for(var i = 0; i < observations.length; i++) {
                var latLng = {
                    'lat': parseFloat(observations[i].latitude),
                    'lng': parseFloat(observations[i].longitude)
                };

                var marker = new google.maps.Marker({
                    position: latLng,
                    icon: icon,
                    title: observations[i].taxrefVern,
                    protected: observations[i].protected
                });

                markers.push(marker);
            }

            // Add a marker clusterer to manage the markers.
            var markerCluster = new MarkerClusterer(map, markers,
                {imagePath: "../../../assets/js/maps/images/m"});
        }
    }

    map.addListener('zoom_changed', function(e) {
        if (map.zoom > 8) {
            if (false == window.accessToProtectedBird) {
                clearProtectedMarkers(markers, markerCluster, markersDeleted);

                $("#alert_map").remove();
                $('<p id="alert_map" style = "color: red;text-align: center;">' +
                    'Vous n\'avez pas les accès requis pour visualiser les espèces protégées, celles-ci ont été retirées de la map</p>')
                    .insertAfter($("#map"))
                ;
            }
        } else {
            if (false == window.accessToProtectedBird) {
                addProtectedMarkers(markers, markerCluster, markersDeleted, map);
            }
        }
    });
}

function clearProtectedMarkers(markers, markerCluster, markersDeleted) {
    for (var i = 0; i < markers.length; i++) {
        if (markers[i].protected == true) {
            // retrait du marker de la carte
            markers[i].setMap(null);

            // insert le marker dans markersDeleted
            markersDeleted.push(markers[i]);

            // retrait du marker dans markerCluster
            markerCluster.removeMarker(markers[i]);

            // retire le marker de markers
            markers.splice(i, 1);

            i--;
        }
    }
}

function addProtectedMarkers(markers, markerCluster, markersDeleted, map) {
    if (markersDeleted.length > 0) {
        $("#alert_map").remove();
        $('<p id="alert_map" style = "color: dodgerblue;text-align: center;">' +
            'Le niveau de zoom permet le réaffichage des espèces protégées sur la carte</p>')
            .insertAfter($("#map"))
        ;
    }

    for (var i = 0; i < markersDeleted.length; i++) {
        // affiche le marker sur la map
        markersDeleted[i].setMap(map);

        // insert le marker dans markers
        markers.push(markersDeleted[i]);

        // insert le marker dans markerCluster
        // markerCluster.addMarker(markersDeleted[i], false);
        markerCluster.addMarker(markersDeleted[i]);

        // retire le marker de markersDeleted
        markersDeleted.splice(i, 1);

        i--;
    }
}
