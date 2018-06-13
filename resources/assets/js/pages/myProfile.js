import googleSearchHelper from '../controls/googleSearchHelper';

(function () {
    window.initGoogleMap = function() {

        let g = new googleSearchHelper('map',true);
        g.init();

        $("#map").on("places-changed",function(event, place){
            if (place.geometry){
                $("#profile-lat").val(place.geometry.location.lat);
                $("#profile-lon").val(place.geometry.location.lng);
            }
        });
    };

    let updateLocation = function() {
        $('#profile-location-name').val($('#pac-input').val());
        if ($('#profile-lat').val() === "" || $('#profile-lon').val() === "") {
            swal({
                title: "An error occurred.",
                text: "You need to set a location to proceed.",
                type: "error",
                confirmButtonText: "OK",
                closeOnConfirm: true
            });
            return false;
        }
    };

    let initEvents = function() {
        $('#location-update-form').submit(updateLocation);
    };

    initEvents();
})();