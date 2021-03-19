var mediaUploader;
var map;
var kmlLayers = [];

jQuery(function () {
    initKmls();
    initKmlGoogleMaps();
});

function initKmls() {
    //This event is triggered when the user stopped sorting and the DOM position has changed.
    jQuery('#kmlsList').sortable({
        update: redrawKmls
    });

    jQuery('#kmlUploadButton').click(uploadKml);
}

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

    initDrawingManager();
    initContextMenu();
    redrawKmls();
}

function redrawKmls() {
    jQuery("#kmlsList").sortable("refreshPositions");
    jQuery("#kmlsList").sortable("refresh");

    //remove kmls from map
    jQuery.each(kmlLayers, function (i, v) {
        v.setMap(null);
    });

    //draw kml and set order
    var order = [];
    kmlLayers = [];
    jQuery('#kmlsList li').each(function (i, v) {  
        var kmlLayer = new google.maps.KmlLayer({
            url: jQuery(v).data('url'),
            suppressInfoWindows: true,
            preserveViewport: true,
            map: map
        });
        kmlLayer.addListener('click', function (kmlEvent) {
            if (jQuery('#previewMode').prop('checked')) {
                showKmlPopUp(kmlEvent);
            }
            else {
                editKmlPopUpData(kmlEvent);
            }
        });
        kmlLayers.push(kmlLayer);
        order.push(jQuery(v).data('id'));
    });
    jQuery('#kmls').val(order.join(','))
}

function uploadKml(e) {
    e.preventDefault();
    if (mediaUploader) {
        mediaUploader.open();
        return;
    }

    mediaUploader = wp.media.frames.file_frame = wp.media({
        title: 'Wybierz plik KML',
        button: {
            text: 'Dodaj plik'
        },
        multiple: true
    });

    mediaUploader.on('select', function () {
        var attachments = mediaUploader.state().get('selection').toJSON();

        jQuery.each(attachments, function (key, val) {
            jQuery('#kmlsList').append( 
                '<li class="ui-state-default kml-li-item" data-id="' + val.id + '" data-url="' + val.url + '">' +
                '<span class="ui-icon ui-icon-arrowthick-2-n-s" ></span > ' +
                val.title + ' - ' + val.filename +
                '<span class="remove-kml"><span class="ui-icon ui-icon-trash" onclick="removeKml(this)"></span></span></li>'
            );
        });

        redrawKmls();
    });

    mediaUploader.open();
}

function removeKml(item) {
    var itemToRemove = jQuery(item).closest('li');

    jQuery('#kmlToRemoveUrl').html(itemToRemove.text());
    jQuery('#kmlRemoveConfirm').dialog({
        autoOpen: true,
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: {
            "Usuń plik": function () {
                itemToRemove.remove();
                redrawKmls();         
                jQuery(this).dialog("close");
            },
            Anuluj: function () {
                jQuery(this).dialog("close");
            }
        }
    });
}
