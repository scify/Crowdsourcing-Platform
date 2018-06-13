import collaborationModalHeader from "./collaborationModalHeader";

(function() {
    let modalHeaderController;

    let displayFilesUploaded = function (mediaContainer, array, title) {
        if (array.length > 0)
            mediaContainer.append(`<div class="media-category-title">${title}:</div>`);
        for (let i = 0; i < array.length; i++) {
            mediaContainer.append(`<div class="media-file"><a href="${array[i]}" target="_blank">${title.slice(0, -1)} #${i + 1}</a></div>`);
        }
    };

    let setViewResponseModalContents = function () {
        let self = $(this);
        let modal = $('#modal-view-response');
        modalHeaderController.initializeCollaborationModalHeader.call(self, modal);
        let responseId = self.data('response-id');
        let mediaContainer = modal.find('.media-container');
        let videos = [];
        let audios = [];
        let images = [];
        $.ajax({
            url: self.data('url'),
            method: 'post',
            data: {'responseId': responseId},
            success: function (response) {
                let text = response.text;
                let media = response.media;
                let noTextMsg = modal.find('.no-text-found');
                let noMediaMsg = modal.find('.no-media-found');
                (text.length !== 0) ? noTextMsg.hide() : noTextMsg.show();
                (media.length !== 0) ? noMediaMsg.hide() : noMediaMsg.show();
                modal.find('.response-body').html(text);
                mediaContainer.html('');
                for (let  i = 0; i < media.length; i++) {
                    let fileUrl = window.location.origin + media[i].file_path;
                    switch (media[i].type_id) {
                        case 1:
                            videos.push(fileUrl);
                            break;
                        case 2:
                            audios.push(fileUrl);
                            break;
                        case 3:
                            images.push(fileUrl);
                    }
                }
                displayFilesUploaded(mediaContainer, videos, 'Videos');
                displayFilesUploaded(mediaContainer, audios, 'Audios');
                displayFilesUploaded(mediaContainer, images, 'Images');
            },
            error: function () {
                $.toast({
                    text: "Could not fetch the data requested",
                    position: "bottom-left",
                    icon: "error",
                    hideAfter: 2000
                });
            }
        });
    };

    let initEvents = function() {
        modalHeaderController = new collaborationModalHeader();
        let $body = $('body');
        $body.on('click', '.view-response', setViewResponseModalContents);
    };

    initEvents();
})();