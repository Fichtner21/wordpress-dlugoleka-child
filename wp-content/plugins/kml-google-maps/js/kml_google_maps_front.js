var maps = [];
var popups = [];
var customInfoWindows = [];

jQuery(function () {
    jQuery('.kml_map').each(function(k, v){
	    eval('init_' + jQuery(v).attr('id') + '()');
    });
});

function createMap(mapSettings){
    var map = new google.maps.Map(document.getElementById(mapSettings.map_id), {
        center: { lat: mapSettings.lat, lng: mapSettings.lng },
        zoom: mapSettings.zoom
    });

    jQuery.each(IO.OUT(mapSettings.drawings, map), function (key, shape) {
        google.maps.event.addListener(shape, 'click', function (e) {
            showDrawingPopUp(shape, e, mapSettings.map_id);
        });
    });

    jQuery.each(mapSettings.kml_urls, function(k, v){
	    var kmlLayer = new google.maps.KmlLayer({
            url: v,
            suppressInfoWindows: true,
            preserveViewport: true,
            map: map
        });
        kmlLayer.addListener('click', function (kmlEvent) {
            showKmlPopUp(kmlEvent, mapSettings.map_id);
        });
    });
    customInfoWindows[mapSettings.map_id] = null;

    popups[mapSettings.map_id] = [];
    jQuery.each(mapSettings.popups_data, function (k, v) {
        popups[mapSettings.map_id][v.id] = v;
    });

    maps[mapSettings.map_id] = map;
}

function showKmlPopUp(kmlEvent, map_id) {
    var data = popups[map_id][kmlEvent.featureData.id];
    console.log(popups[map_id]);
    if (data != null && !data.hidden) {
        showPopUp(kmlEvent.latLng, data, map_id);
    }
}

function showDrawingPopUp(item, e, map_id) {
    var data = popups[map_id][item.id];
    if (data != null && !data.hidden) {
        showPopUp(e.latLng, data, map_id);
    }
}

function showPopUp(latLng, data, map_id) {
    if (customInfoWindows[map_id]) {
        customInfoWindows[map_id].close();
    }

    customInfoWindows[map_id] = new google.maps.InfoWindow({
        content: '<div id="popUpItem"><div id="popUpItemTitle" style="font-weight: bold; margin-bottom: 8px;">' + data.title + '</div><div id="popUpItemContent">' + data.content + '</div></div>',
        position: latLng
    });
    customInfoWindows[map_id].open(maps[map_id]);
}
