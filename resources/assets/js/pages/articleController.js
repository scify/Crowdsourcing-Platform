import Dropzone from 'dropzone';
import googleSearchHelper from '../controls/googleSearchHelper';

Dropzone.autoDiscover = false;
(function () {

    let googleMapsSearchHelper = null;

    let initDropZoneFields = function () {
        $(".dropzone-img").each(function () {
            const element = $(this);
            const hiddenInput = element.find('.dz-hidden');
            const imagePreview = element.next(".imagePreview");
            const removeImgBtn = element.closest(".imgUploadContainer").find(".removeImgBtn");
            const transcriptOptions = {
                url: element.data("url"),
                paramName: "imageFile", // The name that will be used to transfer the file
                uploadMultiple: false,
                acceptedFiles: "image/*",
                dictDefaultMessage: "Click to upload the file",
                headers: {
                    'X-CSRF-TOKEN': $('[name="_token"]').val()
                },
                sending: function (file, xhr, formData) {
                    $.toast({
                        text: "The image file is being uploaded",
                        position: "bottom-left",
                        icon: "info",
                        hideAfter: false
                    });
                },
                success: function (file, response) {
                    $.toast().reset('all');
                    $.toast({
                        text: "Image Uploaded!",
                        position: "bottom-left",
                        icon: "success",
                        hideAfter: 2000
                    });
                    const uploadedImgPath = window.location.origin + "/storage/" + response.path;
                    hiddenInput.val("/storage/" + response.path);
                    element.addClass("hidden");
                    showImageField(imagePreview, uploadedImgPath, removeImgBtn);
                },
                error: function (error, errorResponse) {
                    $.toast().reset('all');
                    $.toast({
                        text: errorResponse.message,
                        position: "bottom-left",
                        icon: "error",
                        hideAfter: 2000
                    });
                }
            };
            new Dropzone($(this)[0], transcriptOptions);
        });
    };

    let showImageField = function (imageDiv, path, removeImgBtn) {
        imageDiv.removeClass("hidden");
        removeImgBtn.removeClass("hidden");
        imageDiv.attr('src', path);
    };

    let removeUploadedImageBtnHandler = function () {
        $(".removeImgBtn").on("click", function () {
            const dropZoneDiv = $(this).closest(".imgUploadContainer").find(".dropzone-img");
            const imagePreview = $(this).closest(".imgUploadContainer").find(".imagePreview");
            const hiddenInput = $(this).closest(".imgUploadContainer").find('.dz-hidden');
            dropZoneDiv.removeClass("hidden");
            $(this).addClass("hidden");
            imagePreview.addClass("hidden");
            hiddenInput.val("");
        });
    };

    let initSelectInputs = function () {
        $('.select2').select2();
        $('.select2AllowDynamicCreation').select2({
            tags: true
        });
    };

    let fetchSelectedCMSIds = function () {
        let selectedCMSIds = [];
        $(this).parent().find('.cms-block.selected').each(function () {
            selectedCMSIds.push($(this).data('cms-id'));
        });
        return selectedCMSIds;
    };

    let initPublishToCMSBtnHandler = function () {
        $(".publish-to-cms").on("click", function () {
            let self = $(this);
            let cmsIds = fetchSelectedCMSIds.call(self);
            console.error(cmsIds.length);
            if (cmsIds.length === 0) {
                swal({
                    title: "Error!",
                    text: "You need to have selected at least one CMS to publish to.",
                    type: "error",
                    showCancelButton: true,
                    confirmButtonText: "OK",
                    closeOnConfirm: true,
                });
            } else {
                swal({
                        title: "Are you sure?",
                        text: "Make sure that you have saved all your changes to the article and that it is finalized. Do you wish to publish your article to the selected CMS?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "Publish",
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true
                    },
                    function () {
                        let articleId = self.data("article-id");
                        let publishUrl = self.data("publish-url");
                        $.ajax({
                            type: "POST",
                            url: publishUrl,
                            data: {articleId: articleId, cmsIds: cmsIds},
                            success: function (response) {
                                self.siblings('.all-cms').html(response.cmsListPartial);
                                swal("Published!", "The article has been successfully published.", "success");
                            },
                            error: function () {
                                swal("Oops!", "An error occurred.", "error");
                            }
                        });
                    });
            }
        });
    };

    let initUnpublishFromStoreBtnHandler = function () {
        $('.unpublish-from-store').on('click', function () {
            let self = $(this);
            swal({
                    title: "Are you sure?",
                    text: "Do you wish to unpublish your article from the online store? No more publishers could buy it and it will not be displayed in the store.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Unpublish",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },
                function () {
                    let storeInfoId = self.data("store-info-id");
                    let unpublishUrl = self.data("unpublish-url");
                    $.ajax({
                        type: "POST",
                        url: unpublishUrl,
                        data: {storeInfoId},
                        success: function (response) {
                            self.closest('.box-body').html(response);
                            swal("Unpublished!", "The article has been successfully unpublished.", "success");
                        },
                        error: function () {
                            swal("Oops!", "An error occurred.", "error");
                        }
                    });
                });
        });
    };

    //called by google maps script at create-edit.blade.php
    // <script src="https://maps.googleapis.com/maps/api/js? .. &callback=googleMapInitiated
    window.googleMapInitiated = function () {
        //currently not used. When the modal is opened we initiate the map. We assume that the relevant script is already loaded.
        //the problem with this method is that it is defined inside webpack and somethimes the
        // script  <script src="https://maps.googleapis.com/maps/api/js? .. &callback=googleMapInitiated loads faster than
        // articleController.js thus window.googleMapInitiated is not found.

    };

    let displayAvailableCollaborators = function (response) {
        $("#collaborators").find(".count").text(response.length);

        $("#collaborators-list").html("");

        const $userTemplate = '<li><label><input type="checkbox" checked name="collaborator_ids[]" value="{userId}"/>' +
            '{userName} <small>({userLocation})</small> </label></li>';

        let $html = [];
        let userLocation = '';
        $.each(response, function (index, user) {
            userLocation = user.distanceInMeters ? parseInt(user.distanceInMeters) + " meters away -" + user.location_name : user.location_name;
            $html.push($userTemplate
                .replace("{userId}", user.id)
                .replace("{userName}", user.name + " " + user.surname)
                .replace("{userLocation}", userLocation));
        });
        $("#collaborators-list").html($html.join(""));
    };
    let whenModalOpensRetrieveAllCollaborators = function () {
        $('#modal-invite-collaborators').on('show.bs.modal', function (e) {
            $(this).parent().find('#map').appendTo('#map-container').css('position', 'relative').css('top', '0').css('right', '0');
            // clear previous search
            $(this).find("#pac-input").val('');
            findUsersByLocation()
        })
    };
    let findUsersByLocation = function (event, place) {

        $('#modal-invite-collaborators').addClass("loading");

        if (googleMapsSearchHelper == null) {
            googleMapsSearchHelper = new googleSearchHelper('map', false);
            googleMapsSearchHelper.init();
        }

        let dataToPost = null;
        $("#collaborators").find(".location-info").html("");
        if (place && place.geometry) {
            $("#collaborators").find(".location-info").html(" (near " + place.formatted_address + ")");
            //$("#collaborators").find(".location-info").html();
            dataToPost = place && place.geometry ? "lat=" + place.geometry.location.lat() + "&long=" + place.geometry.location.lng() : "";
        }
        return $.ajax({
            type: "POST",
            url: "/collaborations/filter-users",
            data: dataToPost,
            success: function (userLocations) {
                googleMapsSearchHelper.displayMarkersOnMap(userLocations);
                displayAvailableCollaborators(userLocations);
            },
            error: function () {
                swal("Oops!", "An error occurred.", "error");
            },
            complete: function () {
                $('#modal-invite-collaborators').removeClass("loading");
            }
        });
    };

    let initCollaborationInvites = function () {
        whenModalOpensRetrieveAllCollaborators();
        $("#map").on("places-changed", findUsersByLocation)
    };

    let initPreservingMapFromHidingWhenModalHides = function () {
        $('#modal-invite-collaborators').on('hide.bs.modal', function (e) {
            $(this).find('#map').appendTo($(this).parent()).css('position', 'absolute').css('top', '-50000px').css('right', '-50000px');
        });
    };

    let removeMapSearchEnterButtonPressSubmitEventToModalForm = function () {
        $('#pac-input').keydown(function (e) {
            if (e.keyCode === 13)
                return false;
        });
    };

    $(function () {
        initDropZoneFields();
        removeUploadedImageBtnHandler();
        initSelectInputs();
        initPublishToCMSBtnHandler();
        initUnpublishFromStoreBtnHandler();
        initCollaborationInvites();
        initPreservingMapFromHidingWhenModalHides();
        removeMapSearchEnterButtonPressSubmitEventToModalForm();
    });
})();