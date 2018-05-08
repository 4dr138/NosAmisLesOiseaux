// function initMap() {
//     var map = new google.maps.Map(document.getElementById('map'), {
//         center: {lat: -34.397, lng: 150.644},
//         zoom: 6,
//     });
//     var infoWindow = new google.maps.InfoWindow({map: map});
//
//     // Try HTML5 geolocation.
//     if (navigator.geolocation) {
//         navigator.geolocation.getCurrentPosition(function(position) {
//             var pos = {
//                 lat: position.coords.latitude,
//                 lng: position.coords.longitude
//             };
//
//             infoWindow.setPosition(pos);
//             infoWindow.setContent('<style>p{color: red;}</style><p>Vous êtes ici !</p>');
//             map.setCenter(pos);
//         }, function() {
//             handleLocationError(true, infoWindow, map.getCenter());
//         });
//     } else {
//         // Browser doesn't support Geolocation
//         handleLocationError(false, infoWindow, map.getCenter());
//     }
// }
//
// function handleLocationError(browserHasGeolocation, infoWindow, pos) {
//     infoWindow.setPosition(pos);
//     infoWindow.setContent(browserHasGeolocation ?
//         'Error: The Geolocation service failed.' :
//         'Error: Your browser doesn\'t support geolocation.');
// }

// var url = Routing.generate('getBirds');
// var options =
//     {
//         url: url,
//         getValue: function(element) {
//             return element.taxrefVern;
//         },
//         list: {
//             match: {
//                 enabled: true
//             },
//             onClickEvent: function() {
//                 var value = $("#searchBird").getSelectedItemData().id;
//                 $("#birdId").val(value);
//             }
//         },
//         requestDelay: 400
//     };
// $("#searchBird").easyAutocomplete(options);
//
// $("#searchObs").on("click", function(event) {
//     event.preventDefault();
//     var value = $("#birdId").val();
//     console.log(value);
//
// });

// $.ajax(
//     {
//         url: url,
//         type: 'GET',
//         data: { get_param: 'value' },
//         dataType: "json",
//         success: function(data){
//             sBirds = JSON.stringify(data);
//             arrBirds = JSON.parse(sBirds);
//             console.log(arrBirds);
//             $("#searchBird").autocomplete({
//                 source:data,
//                 select: function(event, ui)
//                 {
//                     console.log(ui.item.value);
//                     $("#searchBird").val(ui.item.value);
//                 }
//             });
//         },
//         error: function(data){
//             alert('no data');
//         }
//     });