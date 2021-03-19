//saveShapes
var IO = {
    IN: function (items, encoded) {
        var result = [],
            goo = google.maps,
            shape, tmp;

        for (var i = 0; i < items.length; i++) {
            shape = items[i];
            tmp = { type: shape.type, id: shape.id || null };


            switch (tmp.type) {
                case google.maps.drawing.OverlayType.CIRCLE:
                    tmp.radius = shape.getRadius();
                    tmp.geometry = this.p_(shape.getCenter());
                    break;
                case google.maps.drawing.OverlayType.MARKER:
                    tmp.geometry = this.p_(shape.getPosition());
                    tmp.icon = shape.icon;
                    break;
                case google.maps.drawing.OverlayType.RECTANGLE:
                    tmp.geometry = this.b_(shape.getBounds());
                    break;
                case google.maps.drawing.OverlayType.POLYLINE:
                    tmp.geometry = this.l_(shape.getPath(), encoded);
                    break;
                case google.maps.drawing.OverlayType.POLYGON:
                    tmp.geometry = this.m_(shape.getPaths(), encoded);
                    break;
            }

            switch (tmp.type) {
                case google.maps.drawing.OverlayType.CIRCLE:
                case google.maps.drawing.OverlayType.RECTANGLE:
                case google.maps.drawing.OverlayType.POLYGON:
                    tmp.fillColor = shape.fillColor;
                    tmp.fillOpacity = shape.fillOpacity;
                    tmp.strokeColor = shape.strokeColor;
                    tmp.strokeOpacity = shape.strokeOpacity;
                    tmp.strokeWeight = shape.strokeWeight;
                    tmp.zIndex = shape.zIndex;
                    break;
                case google.maps.drawing.OverlayType.POLYLINE:
                    tmp.strokeColor = shape.strokeColor;
                    tmp.strokeOpacity = shape.strokeOpacity;
                    tmp.strokeWeight = shape.strokeWeight;
                    tmp.zIndex = shape.zIndex;
            }
       
            result.push(tmp);
        }

        return result;
    },

    OUT: function (items, map) {
        var shapes = [],
            goo = google.maps,
            map = map || null,
            shape, tmp;

        for (var i = 0; i < items.length; i++) {
            shape = items[i];

            switch (shape.type) {
                case google.maps.drawing.OverlayType.CIRCLE:
                    tmp = new goo.Circle({
                        radius: Number(shape.radius),
                        center: this.pp_.apply(this, shape.geometry),
                        icon: shape.icon
                    });
                    break;
                case google.maps.drawing.OverlayType.MARKER:
                    tmp = new goo.Marker({ position: this.pp_.apply(this, shape.geometry) });
                    break;
                case google.maps.drawing.OverlayType.RECTANGLE:
                    tmp = new goo.Rectangle({ bounds: this.bb_.apply(this, shape.geometry) });
                    break;
                case google.maps.drawing.OverlayType.POLYLINE:
                    tmp = new goo.Polyline({ path: this.ll_(shape.geometry) });
                    break;
                case google.maps.drawing.OverlayType.POLYGON:
                    tmp = new goo.Polygon({ paths: this.mm_(shape.geometry) });
                    break;
            }

            switch (shape.type) {
                case google.maps.drawing.OverlayType.CIRCLE:
                case google.maps.drawing.OverlayType.RECTANGLE:
                case google.maps.drawing.OverlayType.POLYGON:
                    tmp.setOptions({
                        fillColor: shape.fillColor,
                        fillOpacity: shape.fillOpacity,
                        strokeColor: shape.strokeColor,
                        strokeOpacity: shape.strokeOpacity,
                        strokeWeight: shape.strokeWeight,
                        zIndex: shape.zIndex
                    });
                    break;
                case google.maps.drawing.OverlayType.POLYLINE:
                    tmp.setOptions({
                        strokeColor: shape.strokeColor,
                        strokeOpacity: shape.strokeOpacity,
                        strokeWeight: shape.strokeWeight,
                        zIndex: shape.zIndex
                    });
                    break;
            }
            
            tmp.setOptions({
                type: shape.type,
                clickable: true
            });

            tmp.setValues({ map: map, id: shape.id })
            shapes.push(tmp);
        }
        return shapes;
    },
    l_: function (path, e) {
        path = (path.getArray) ? path.getArray() : path;
        if (e) {
            return google.maps.geometry.encoding.encodePath(path);
        } else {
            var r = [];
            for (var i = 0; i < path.length; ++i) {
                r.push(this.p_(path[i]));
            }
            return r;
        }
    },
    ll_: function (path) {
        if (typeof path === 'string') {
            return google.maps.geometry.encoding.decodePath(path);
        }
        else {
            var r = [];
            for (var i = 0; i < path.length; ++i) {
                r.push(this.pp_.apply(this, path[i]));
            }
            return r;
        }
    },

    m_: function (paths, e) {
        var r = [];
        paths = (paths.getArray) ? paths.getArray() : paths;
        for (var i = 0; i < paths.length; ++i) {
            r.push(this.l_(paths[i], e));
        }
        return r;
    },
    mm_: function (paths) {
        var r = [];
        for (var i = 0; i < paths.length; ++i) {
            r.push(this.ll_.call(this, paths[i]));

        }
        return r;
    },
    p_: function (latLng) {
        return ([latLng.lat(), latLng.lng()]);
    },
    pp_: function (lat, lng) {
        return new google.maps.LatLng(lat, lng);
    },
    b_: function (bounds) {
        return ([this.p_(bounds.getSouthWest()),
        this.p_(bounds.getNorthEast())]);
    },
    bb_: function (sw, ne) {
        return new google.maps.LatLngBounds(this.pp_.apply(this, sw),
            this.pp_.apply(this, ne));
    },
    t_: function (s) {
        var t = ['CIRCLE', 'MARKER', 'RECTANGLE', 'POLYLINE', 'POLYGON'];
        for (var i = 0; i < t.length; ++i) {
            if (s === google.maps.drawing.OverlayType[t[i]]) {
                return t[i];
            }
        }
    }

}