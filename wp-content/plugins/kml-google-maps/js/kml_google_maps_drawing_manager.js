var iconUploader;
var drawingManager;
var selectedShape;
var shapes = [];
var popUpsData = [];
var customInfoWindow;

function initDrawingManager() {
    drawingManager = new google.maps.drawing.DrawingManager({
        drawingControl: true,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: ['marker', 'circle', 'polygon', 'polyline', 'rectangle']
        },
        markerOptions: markerOptions(),
        polygonOptions: polyOptions(),
        circleOptions: polyOptions(),
        polylineOptions: polyOptions(),
        rectangleOptions: polyOptions()
    });
    drawingManager.setMap(map);
    google.maps.event.addListener(drawingManager, 'overlaycomplete', overlayComplete);
    google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
    google.maps.event.addListener(map, 'click', clearSelection);

    initShapes();
}

function initShapes() {
    try {
        shapes = IO.OUT(JSON.parse(jQuery('#drawing').val()), map);

        jQuery.each(JSON.parse(jQuery('#popup').val()), function (key, item) {
            popUpsData[item.id] = item;
        });       

        jQuery.each(shapes, function (key, shape) {
            setShapeEvents(shape);
        });
    }
    catch (err) {
        console.log(err);
    }

    jQuery('#post').submit(function (e) {
        jQuery('#drawing').val(JSON.stringify(IO.IN(shapes, false)));

        var tmpPopUpsData = [];
        for (var key in popUpsData) {
            tmpPopUpsData.push(popUpsData[key]);
        }
        jQuery('#popup').val(JSON.stringify(tmpPopUpsData));
    });

    jQuery('#previewMode').change(previewMode);
}

function markerOptions() {
    return {
        clickable: true,
        draggable: true
    }
}

function polyOptions() {
    return {
        clickable: true,
        editable: true,
        draggable: true,
        fillColor: '#F5F5F5',
        fillOpacity: 0.3,
        strokeColor: '#528BE2',
        strokeOpacity: 1,
        strokeWeight: 5
    }
}

function overlayComplete(event) {
    var newShape = event.overlay;
    newShape.type = event.type;
    newShape.id = Date.now();
    shapes.push(newShape);
    drawingManager.setDrawingMode(null);

    setShapeEvents(newShape)
    setSelection(newShape);
}

function setShapeEvents(newShape) {
    google.maps.event.addListener(newShape, 'click', function (e) {
        if (jQuery('#previewMode').prop('checked')) {
            showDrawingPopUp(newShape, e);
        }
        else {
            setSelection(newShape);
        }
    });

    google.maps.event.addListener(newShape, 'rightclick', function (e) {
        setSelection(newShape);
        jQuery('#map').contextMenu();
    });
}

function setSelection(shape) {
    clearSelection();
    if (shape.type !== google.maps.drawing.OverlayType.MARKER) {      
        shape.setEditable(true);
    }      
    shape.setDraggable(true);
    selectedShape = shape;
}

function clearSelection() {
    if (selectedShape) {
        if (selectedShape.type !== google.maps.drawing.OverlayType.MARKER) {
            selectedShape.setEditable(false);
        }
        selectedShape.setDraggable(false);
        selectedShape = null;
    }
}
//contextMenu
function initContextMenu() {
    var currentMousePos;
    jQuery(document).mousemove(function (event) {
        currentMousePos = event;
    });

    jQuery.contextMenu({
        selector: '#map',
        determinePosition: function (jQuerymenu) {
            jQuerymenu.position({ my: "left top", at: "center bottom", of: currentMousePos, offset: "0 5" });
        },
        trigger: 'none',
        callback: doAction,
        items: {
            top: {
                name: 'Na wierzch',
                icon: '-fa fa fa-share',
                disabled: function () { return selectedShape.type === google.maps.drawing.OverlayType.MARKER; },
            },
            bottom: {
                name: 'Pod spód',
                icon: '-fa fa fa-reply',
                disabled: function () { return selectedShape.type === google.maps.drawing.OverlayType.MARKER; },
            },
            stroke: {
                name: 'Kontur',
                icon: '-fa menu-color fa fa-square-o',
                disabled: function () { return selectedShape.type === google.maps.drawing.OverlayType.MARKER; },
                items: {
                    strokeColor: {
                        name: 'Kolor <div id="menuStrokeColor" class="color-box" ></div>',
                        isHtmlName: true,
                        icon: '-fa menu-color fa fa-pencil-square-o',
                    },
                    strokeOpacity: {
                        name: 'Przezroczystośc <br /><input id="menuStrokeOpacity" class="itemOpacity" type="range" min="0" max="1" step="0.01" />',
                        isHtmlName: true,
                        icon: '-fa menu-color fa fa-eye-slash',
                    },
                    strokeWeight: {
                        name: 'Obramowanie <input id="menuStrokeWeight" type="number" min="0" step="0.1" />',
                        isHtmlName: true,
                        icon: '-fa menu-color fa fa-minus',
                    }                   
                }
            },
            fill: {
                name: 'Wypełnienie',
                disabled: function () { return selectedShape.type === google.maps.drawing.OverlayType.MARKER || selectedShape.type === google.maps.drawing.OverlayType.POLYLINE; },
                icon: '-fa menu-color fa fa-square shape',
                items: {
                    fillColor: {
                        name: 'Kolor <div id="menuFillColor" class="color-box"></div>',
                        isHtmlName: true,
                        icon: '-fa menu-color fa fa-paint-brush',
                    },
                    fillOpacity: {
                        name: 'Przezroczystośc <br /><input id="menuFillOpacity" class="itemOpacity" type="range" min="0" max="1" step="0.01" />',
                        isHtmlName: true,
                        icon: '-fa menu-color fa fa-eye-slash',
                    }
                }
            },       
            icon: {
                name: 'Ikona',
                disabled: function () { return selectedShape.type !== google.maps.drawing.OverlayType.MARKER; },
                icon: '-fa fa fa-map-marker'
            },
            sep1: '---------',
            edit: {
                name: 'Edytuj dane',
                icon: 'edit'
            },
            sep2: '---------',
            delete: {
                name: 'Usuń',
                icon: 'delete'
            },
        },
        events: {
            show: function (options) {
                if (selectedShape.type !== google.maps.drawing.OverlayType.MARKER) {
                    jQuery('#menuStrokeColor').css('background-color', selectedShape.strokeColor);
                    jQuery('#menuStrokeOpacity').val(selectedShape.strokeOpacity);
                    jQuery('#menuFillColor').css('background-color', selectedShape.fillColor);
                    jQuery('#menuFillOpacity').val(selectedShape.fillOpacity);
                    jQuery('#menuStrokeWeight').val(selectedShape.strokeWeight);
                }
            }
        }
    });

    jQuery('#colorPicker').on('change', setColor);
    jQuery('.itemOpacity').on('change', setOpacity);
    jQuery('#menuStrokeWeight').on('change keyup', setStrokeWeight);
}

function doAction(key, options) {
    switch (key) {
        case 'top':
            if (selectedShape.zIndex < shapes.length - 1) {
                jQuery.each(shapes, function (i, shp) {
                    if (shp.zIndex > selectedShape.zIndex) {
                        shp.setOptions({
                            zIndex: shp.zIndex - 1
                        });
                    }
                });
                selectedShape.setOptions({
                    zIndex: shapes.length - 1
                });
            }
            break;
        case 'bottom':
            if (selectedShape.zIndex > 0) {
                jQuery.each(shapes, function (i, shp) {
                    if (shp.zIndex < selectedShape.zIndex) {
                        shp.setOptions({
                            zIndex: shp.zIndex + 1
                        });
                    }
                });
                selectedShape.setOptions({
                    zIndex: 0
                });
            }
            break;
        case 'strokeColor':
            jQuery('#colorPicker').val(selectedShape.strokeColor).data('type', 'strokeColor').click();
            return false;
            break;
        case 'strokeOpacity':
            return false;
            break;
        case 'strokeWeight':
            return false;
            break;            
        case 'fillColor':
            jQuery('#colorPicker').val(selectedShape.strokeColor).data('type', 'fillColor').click();
            return false;
            break;
        case 'fillOpacity':
            return false;
            break;
        case 'icon':
            if (iconUploader) {
                iconUploader.open();
                return;
            }

            iconUploader = wp.media.frames.file_frame = wp.media({
                title: 'Wybierz ikonę pinezki',
                button: {
                    text: 'Zapisz'
                },
                multiple: false
            });

            iconUploader.on('select', function () {
                selectedShape.setOptions({ icon: iconUploader.state().get('selection').first().toJSON() });
            });

            iconUploader.open();
            break;
        case 'edit':
            editDrawingPopUp();
            break;
        case 'delete':
            removeShape();
            break;
    }
}

function removeShape() {
    jQuery('#itemRemoveConfirm').dialog({
        autoOpen: true,
        resizable: false,
        height: 'auto',
        width: 400,
        modal: true,
        buttons: {
            'Usuń element': function () {
                shapes = jQuery.grep(shapes, function (value) {
                    return value != selectedShape;
                });
                selectedShape.setMap(null);
                jQuery(this).dialog('close');
            },
            'Anuluj': function () {
                jQuery(this).dialog('close');
            }
        }
    });
}

function setColor(e) {
    if (jQuery(e.target).data('type') == 'fillColor') {
        selectedShape.setOptions({ fillColor: jQuery(e.target).val() });
        jQuery('#menuFillColor').css('background-color', selectedShape.fillColor);
    }
    else {
        selectedShape.setOptions({ strokeColor: jQuery(e.target).val() });
        jQuery('#menuStrokeColor').css('background-color', selectedShape.strokeColor);
    }
}

function setOpacity(e) {
    if (jQuery(e.target).attr('id') == 'menuStrokeOpacity') {
        selectedShape.setOptions({ strokeOpacity: jQuery(e.target).val() });
    }
    else {
        selectedShape.setOptions({ fillOpacity: jQuery(e.target).val() });
    }
}

function setStrokeWeight(e) {
    selectedShape.setOptions({ strokeWeight: jQuery(e.target).val() });
}

function editPopUpData(data) {
    jQuery('#popup_id').val(data.id);
    jQuery('#popup_title').val(data.title);
    jQuery('#popup_content').val(data.content);
    jQuery('#popup_hidden').prop('checked', data.hidden);       

    var editDialog = jQuery('#popUpData').dialog({
        autoOpen: true,
        resizable: true,
        width: '70%',
        modal: false,
        buttons: {
            'Zapisz': function () {
                var popup_id = jQuery('#popup_id').val();
                popUpsData[popup_id] = {
                    id: popup_id,
                    title: jQuery('#popup_title').val(),
                    content: jQuery('#popup_content').val(),
                    hidden: jQuery('#popup_hidden').prop('checked')
                };

                try {
                    editDialog.dialog('close');
                }
                catch (err) {
                    console.log(err.message);
                }           
            },
            'Anuluj': function () {
                try {
                    editDialog.dialog('close');
                }
                catch (err) {
                    console.log(err.message);
                }
            }
        },
        open: function (event, ui) {
            jQuery('#popup_content-html').click();
            if (tinymce.activeEditor) {
                tinymce.activeEditor.remove();
            }
        }
    });
}

function previewMode(e) {
    if (jQuery(e.target).prop('checked')) {
        clearSelection();
    }
    else {
        if (customInfoWindow) {
            customInfoWindow.close();
        }
    }
}

//kmlCustomData
function editKmlPopUpData(kmlEvent) {
    var id = kmlEvent.featureData.id;
    var data = popUpsData[id];
    if (data == null) {
        data = {
            id: id,
            title: kmlEvent.featureData.name == null ? '' : kmlEvent.featureData.name,
            content: kmlEvent.featureData.description == null ? '' : kmlEvent.featureData.description,
            hidden: false
        };
        popUpsData[id] = data;
    }

    editPopUpData(data);
}

function showKmlPopUp(kmlEvent) {
    var data = popUpsData[kmlEvent.featureData.id];
    if (data != null && !data.hidden) {
        showPopUp(kmlEvent.latLng, data);
    }
}


function editDrawingPopUp() {
    var id = selectedShape.id;
    var data = popUpsData[id];
    if (data == null) {
        data = {
            id: id,
            title: '',
            content: '',
            hidden: false
        };
        popUpsData[id] = data;
    }

    editPopUpData(data);
}

function showDrawingPopUp(item, e) {
    var data = popUpsData[item.id];
    if (data != null && !data.hidden) {
        showPopUp(e.latLng, data);
    }
}

function showPopUp(latLng, data) {
    if (customInfoWindow) {
        customInfoWindow.close();
    }

    customInfoWindow = new google.maps.InfoWindow({
        content: '<div id="popUpItem"><div id="popUpItemTitle">' + data.title + '</div><div id="popUpItemContent">' + data.content + '</div></div>',
        position: latLng
    });
    customInfoWindow.open(map);    
}
