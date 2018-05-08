function initMap(observations = null) {

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 5,
        center: {lat: 46.528635, lng: 2.4389648} // france
        // center: {lat: -28.024, lng: 140.887} // australie
    });

    // Create an array of alphabetical characters used to label the markers.
    var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    var urlObsForMaps = Routing.generate('getObservationsForMap', { birdID: null }, false);

    var locations = [];

    if (null == observations) {
        $.ajax({
            url: urlObsForMaps,
            type: 'GET',
            dataType: "json",
            success: function(data){
                for(var i = 0; i < data.length; i++) {
                    locations[i] = [];
                    locations[i] = {
                        'lat': data[i].latitude,
                        'lng': data[i].longitude
                    }
                }

                console.log('locations quand pas de recherche');
                console.log(locations);

                var markers = locations.map(function(location, i) {
                    return new google.maps.Marker({
                        position: location,
                        label: labels[i % labels.length]
                    });
                });

                // Add a marker clusterer to manage the markers.
                var markerCluster = new MarkerClusterer(map, markers,
                    {imagePath: "../../../assets/js/maps/images/m"});
            }
        });
    } else {
        for(var i = 0; i < observations.length; i++) {
            locations[i] = [];
            locations[i] = {
                'lat': observations[i].latitude,
                'lng': observations[i].longitude
            }
        }
        // locations = observations;

        console.log('locations quand recherche');
        console.log(locations);

        var markers = locations.map(function(location, i) {
            return new google.maps.Marker({
                position: location,
                label: labels[i % labels.length]
            });
        });

        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: "../../../assets/js/maps/images/m"});
    }
}
