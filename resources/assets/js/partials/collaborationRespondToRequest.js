import Dropzone from "dropzone";
import collaborationModalHeader from "./collaborationModalHeader";

Dropzone.autoDiscover = false;

(function () {
    let modalHeaderController;
    let lastResponse = '';
    let initDropZoneFields = function () {
        $(".dropzone-media").each(function () {
            const element = $(this);
            const hiddenInput = $('.dz-hidden');
            const dropzoneOptions = {
                url: element.data("url"),
                paramName: "media",
                uploadMultiple: true,
                acceptedFiles: "image/*,audio/*,video/*",
                dictDefaultMessage: "Click to upload files",
                headers: {
                    'X-CSRF-TOKEN': $('[name="_token"]').val()
                },
                sending: function (file, xhr, formData) {
                    $.toast({
                        text: "The file is being uploaded",
                        position: "bottom-left",
                        icon: "info",
                        hideAfter: false
                    });
                },
                success: function (file, response) {
                    $.toast().reset('all');
                    $.toast({
                        text: "Media Uploaded!",
                        position: "bottom-left",
                        icon: "success",
                        hideAfter: 2000
                    });
                    let responsePath = response.path;
                    if (lastResponse !== responsePath) {
                        lastResponse = responsePath;
                        let oldValue = hiddenInput.val();
                        hiddenInput.val((oldValue !== "" ? oldValue + "," : "") + responsePath);
                    }
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
            new Dropzone($(this)[0], dropzoneOptions);
        });
    };

    let resetDropzone = function () {
        $(".dropzone-media").each(function () {
            this.dropzone.removeAllFiles();
        });
    };

    let setRespondToRequestModalContents = function () {
        let self = $(this);
        let modal = $('#modal-display-task');
        modalHeaderController.initializeCollaborationModalHeader.call(self, modal);
        let responseId = self.data('response-id');
        let statusName = self.data('status-name');
        resetDropzone();
        modal.find('.dz-hidden').val('');
        modal.find('[name="response_id"]').val(responseId);
        modal.find('[name="response_text"]').val('');
        if (statusName === "Completed")
            modal.find('[type="submit"]').attr('disabled', 'disabled');
        else
            modal.find('[type="submit"]').removeAttr('disabled');
    };

    let initEvents = function () {
        modalHeaderController = new collaborationModalHeader();
        let $body = $('body');
        $body.on('click', '.display-task', setRespondToRequestModalContents);
        initDropZoneFields();
    };

    initEvents();
})();