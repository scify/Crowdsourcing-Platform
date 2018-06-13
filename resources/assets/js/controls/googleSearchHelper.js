const googleSearchHelper = function (mapContainerId, afterUserSelectionDisplayPlacesOnMap) {
    let $mapContainer = $("#" + mapContainerId);
    let searchBox;
    let map;
    let markers = [];

    let initMap = function () {
        let $alreadySetLocation = $("#set-location");
        let selectedLocation = {lat: 37.9838096, lng: 23.7275388};
        let markerInfo = null;
        // if location is already set in backend, zoom to location set and return a marker's info to be displayed later
        if ($alreadySetLocation.length !== 0) {
            let locationName = $alreadySetLocation.data('loc-name');
            let lat = parseFloat($alreadySetLocation.data('lat'));
            let lon = parseFloat($alreadySetLocation.data('lon'));
            selectedLocation = {
                lat: lat,
                lng: lon
            };
            markerInfo = {
                title: locationName,
                position: selectedLocation
            };
        }
        map = new google.maps.Map(document.getElementById(mapContainerId), {
            center: selectedLocation,
             zoom: 18,
            mapTypeId: 'roadmap',
            minZoom: 3,
            maxZoom: 20
        });
        return markerInfo;
    };

    let createMarker = function (title, position) {
        return new google.maps.Marker({
            map: map,
            title: title,
            position: position
        })
    };

    let placesChangedHandler = function () {
        let places = searchBox.getPlaces();

        if (places.length == 0)
            return;

        clearMarkers();
        $mapContainer.trigger("places-changed", places);
        displayPlacesOnMap(places, afterUserSelectionDisplayPlacesOnMap);
    };

    let clearMarkers = function () {
        // Clear out the old markers.
        markers.forEach(function (marker) {
            marker.setMap(null);
        });
        markers = [];
    };

    let displayPlacesOnMap = function (places, afterUserSelectionDisplayPlacesOnMap) {
        let bounds = new google.maps.LatLngBounds();
        // For each place, get the icon, name and location.
        places.forEach(function (place) {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }
            if (afterUserSelectionDisplayPlacesOnMap) // Create a marker for each place.
                markers.push(createMarker(place.name, place.geometry.location));

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    };

    let initAutocomplete = function () {
        let initPositionMarkerInfo = initMap();
        // Create the search box and link it to the UI element.
        let input = document.getElementById('pac-input');
        searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function () {
            searchBox.setBounds(map.getBounds());
        });

        let markers = [];
        if (initPositionMarkerInfo)
            markers.push(createMarker(initPositionMarkerInfo.title, initPositionMarkerInfo.position));

        // Listen for the event fired when the user selects a prediction and retrieve more details for that place.
        searchBox.addListener('places_changed', placesChangedHandler);
    };

    let displayMarkersOnMap = function (userLocations) {
        clearMarkers();
        if (userLocations.length > 0) {
            let bounds = new google.maps.LatLngBounds();
            $.each(userLocations, function (index, userLocation) {
                let marker = createMarker(userLocation.name + " " + userLocation.surname, {
                    lat: userLocation.lat,
                    lng: userLocation.lon
                });
                markers.push(marker);
                bounds.extend(marker.getPosition());
            });
            map.fitBounds(bounds);
            // map.panToBounds(bounds);
        }

    };

    return {
        init: initAutocomplete,
        displayMarkersOnMap: displayMarkersOnMap
    }
};


export default googleSearchHelper;


