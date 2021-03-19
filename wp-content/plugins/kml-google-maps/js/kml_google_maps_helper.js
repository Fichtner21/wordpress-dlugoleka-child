function getValueOrDefault(id) {
    var result = parseFloat(jQuery(id).val());

    if (isNaN(parseFloat(result))) {

        switch (id) {
            case '#lat':
                result = 52.03;
                break;
            case '#lng':
                result = 19.27;
                break;
            case '#zoom':
                result = 6;
                break;
            default:
                result = 0;
        }
    }

    return result;
}

function updateData() {
    jQuery("#zoom").val(map.getZoom());
    jQuery("#lat").val(map.getCenter().lat());
    jQuery("#lng").val(map.getCenter().lng());
}