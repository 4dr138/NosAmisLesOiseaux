latField = $("#app_observation_latitude");
longField = $("#app_observation_longitude");
var espece;

function initialize() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 48.866667, lng: 2.333333},
        zoom: 6,
    });
    var infoWindow = new google.maps.InfoWindow({map: map});
    var geocoder = new google.maps.Geocoder();

    document.getElementById('submitLoc').addEventListener('click', function() {
        geocodeAddress(geocoder, map);
    });

    function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
            if (status === 'OK') {
                resultsMap.setCenter(results[0].geometry.location);

                ParseLocation(results[0].geometry.location);
                function ParseLocation(location) {

                    var lat = location.lat().toString().substr(0, 12);
                    var lng = location.lng().toString().substr(0, 12);

                    latField.val(lat);
                    longField.val(lng);
                }

                var marker = new google.maps.Marker({
                    map: resultsMap,
                    position: results[0].geometry.location
                });
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('<style>p{color: red;}</style><p>Vous êtes ici !</p>');
            map.setCenter(pos);
        }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
}

$("#geolocalisation").click(function()
{
    initialize();
});

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
}
// google.maps.event.addDomListener(window, "load", initialize);


var url = Routing.generate('getBirds');
var options =
    {
        url: url,
        getValue: 'taxrefVern',
        list: {
            match: {
                enabled: true
            }
        }
    };
$("#searchBirdLoc").easyAutocomplete(options);

$("#searchBirdLoc").on("change", function(event, ui){
    espece = event.target.value;
});

$("#app_observation_Soumettre").click(function()
{
    $('#app_observation_birdName').val(espece);
});




