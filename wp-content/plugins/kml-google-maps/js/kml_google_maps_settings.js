var jQuery = jQuery.noConflict();
var map;

jQuery(function () {
    initKmlGoogleMaps();
});

function initKmlGoogleMaps() {
    var lat = getValueOrDefault("#lat");
    var lng = getValueOrDefault("#lng");
    var zoom = getValueOrDefault("#zoom");

    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: lat, lng: lng },
        zoom: zoom
    });

    google.maps.event.addListener(map, 'center_changed', updateData);
    google.maps.event.addListener(map, 'zoom_changed', updateData);
}
