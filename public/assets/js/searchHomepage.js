var urlGetBirds = Routing.generate('getBirds');
var optionsGetBirds =
{
    url: urlGetBirds,
    getValue: function(element) {
        return element.taxrefVern;
    },
    list: {
        match: {
            enabled: true
        },
        onClickEvent: function() {
            var value = $("#searchBird").getSelectedItemData().id;
            $("#birdId").val(value);
        }
    },
    requestDelay: 400
};

$("#searchBird").easyAutocomplete(optionsGetBirds);

$("#searchObs").on("click", function(event) {
    event.preventDefault();
    var birdID = $("#birdId").val();

    var urlObsForMaps = Routing.generate('getObservationsForMap', { birdID: birdID }, false);
    $.ajax(
    {
        url: urlObsForMaps,
        type: 'GET',
        dataType: "json",
        success: function(data){

            initMap(data);
        }
    });
});

$("#selectBirdFamily").on("select", function(event) {
    event.preventDefault();
    var select = document.getElementById("selectBirdFamily");
    var choice = select.selectedIndex;
    var birdFamilyId = select.options[choice].value;

    var urlObsWithFamilyForMaps = Routing.generate('getObservationsWithFamilyForMap', { birdFamilyId: birdFamilyId }, false);
    $.ajax(
    {
        url: urlObsWithFamilyForMaps,
        type: 'GET',
        dataType: "json",
        success: function(data){
            console.log(data);
            initMap(data);
        }
    });
});
