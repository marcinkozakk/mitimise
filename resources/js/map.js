var GoogleMapsLoader = require('google-maps');
GoogleMapsLoader.KEY = 'AIzaSyCZ-q6zCJ7m9oVsDqo5dwPRRz874zWYG4Q';
GoogleMapsLoader.VERSION = '3.34';
GoogleMapsLoader.LIBRARIES = ['places'];

$('#add-meeting, #edit-meeting').on('show.bs.modal', () => {

    let
        mapElem = $('#map')[0],
        placeSearch = $('#place-search')[0],
        placeName = $('#place-name'),
        placeAddress = $('#place-address'),
        placeLat = $('#place-lat'),
        placeLng = $('#place-lng');

    let centerMap, zoom;

    let isPositionSet = placeLat.val().length && placeLng.val().length;

    if(isPositionSet) {
        centerMap = {lat: +placeLat.val(), lng: +placeLng.val()};
        zoom = 17;
    } else {
        centerMap = {lat: 52, lng: 19};
        zoom = 6;
    }

    GoogleMapsLoader.load(google => {
        let map = new google.maps.Map(mapElem, {
            center: centerMap,
            zoom: zoom
        });

        if (navigator.geolocation && !isPositionSet) {
            navigator.geolocation.getCurrentPosition(function (position) {
                let currentPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                map.setCenter(currentPosition);
                map.setZoom(12);
            });
        }

        let autocomplete = new google.maps.places.Autocomplete(placeSearch);
        autocomplete.setFields(['formatted_address', 'geometry', 'icon', 'name']);
        autocomplete.bindTo('bounds', map);

        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
            draggable:true,
            position: isPositionSet ? centerMap : null
        });

        autocomplete.addListener('place_changed', () => {
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            placeName.val(place.name);
            placeAddress.val(place.formatted_address);

            savePosition(marker);
        });

        marker.addListener('dragend', () => {
                savePosition(marker);
        });
    });

    var savePosition = marker => {
        placeLat.val(marker.position.lat);
        placeLng.val(marker.position.lng);
    };
});

$('#map-modal').on('show.bs.modal', () => {
    let $map = $('#map-show');

    GoogleMapsLoader.load(google => {
        let centerMap = {lat: +$map.data('lat'), lng: +$map.data('lng')};

        let map = new google.maps.Map($map[0], {
            center: centerMap,
            zoom: 17
        });

        new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
            position: centerMap
        });

    });
});