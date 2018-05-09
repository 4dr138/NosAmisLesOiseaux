function initMap(observations = null) {

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 5,
        center: {lat: 46.528635, lng: 2.4389648} // france
    });

    var urlObsForMaps = Routing.generate('getObservationsForMap', { birdID: null }, false);

    var locations = [];
    var icon = '../../../assets/js/maps/images/icon_maps.png';
    var titles = [];

    if (null === observations) {
        $.ajax({
            url: urlObsForMaps,
            type: 'GET',
            dataType: "json",
            success: function(data){
                for(var i = 0; i < data.length; i++) {
                    // locations[i] = [];
                    locations[i] = {
                        'lat': parseFloat(data[i].latitude),
                        'lng': parseFloat(data[i].longitude)
                    };

                    titles[i] = {
                        'title': data[i].taxrefVern
                    };
                }

                var markers = locations.map(function(location, i) {
                    return new google.maps.Marker({
                        position: location,
                        icon: icon,
                        title: titles[i].title
                    });
                });

                // Add a marker clusterer to manage the markers.
                var markerCluster = new MarkerClusterer(map, markers,
                    {imagePath: "../../../assets/js/maps/images/m"});
            }
        });
    } else {

        if(observations.length === 0)
        {
            $("#alert_map").remove();
            $('<p id="alert_map" style = "color: red;text-align: center;">Aucune observation enregistrée chez cette espèce pour le moment</p>').insertAfter($("#map"));
        }
        else {
            for(var i = 0; i < observations.length; i++) {
                // locations[i] = [];
                locations[i] = {
                    'lat': parseFloat(observations[i].latitude),
                    'lng': parseFloat(observations[i].longitude)
                }

                titles[i] = {
                    'title': observations[i].taxrefVern
                };
            }

            var markers = locations.map(function (location, i) {
                return new google.maps.Marker({
                    position: location,
                    icon: icon,
                    title: titles[i].title
                });
            });

            // Add a marker clusterer to manage the markers.
            var markerCluster = new MarkerClusterer(map, markers,
                {imagePath: "../../../assets/js/maps/images/m"});
        }
    }
}
