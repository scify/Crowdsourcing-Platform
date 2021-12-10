import CodeMirror from 'codemirror/lib/codemirror';

import 'codemirror/mode/xml/xml';

(function () {

    let initializeSummernote = function () {
        window.setTimeout(function () {
            $('.summernote').summernote({
                height: 150,   //set editable area's height
                codemirror: { // codemirror options
                    CodeMirrorConstructor: CodeMirror,
                    theme: 'monokai'
                }
            });
            initializeCommunicationResourcesHandlers();
        }, 2000);

    };

    let initializeSubmitFormListener = function () {
        $("#project-form").one("submit", function (event) {
            event.preventDefault();
            fixAllSummerNoteCodes();
            $(this).submit();
        });
    }

    let fixAllSummerNoteCodes = function () {
        $('.summernote').each((index, element) => {
            updateSummerNoteCodeContent($(element));
        });
    }

    let updateSummerNoteCodeContent = function (el) {
        el.val(el.summernote('code'));
    }

    let initializeImgFileChangePreviewHandlers = function () {
        $('.image-input').each(function (i, obj) {
            $(obj).change(function () {
                const event = this;
                if (event.files && event.files[0]) {
                    const parent = $(obj).closest('.image-input-container');
                    let imgPreview = parent.find('.selected-image-preview');
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imgPreview.attr('src', e.target.result);
                    };
                    reader.readAsDataURL(event.files[0]);
                }
            });
        });
    };


    let initializeCommunicationResourcesHandlers = function () {
        initializeSummernoteAndUpdateElementOnKeyup($('#questionnaire_response_email_intro_text'), $('#intro_text'));
        initializeSummernoteAndUpdateElementOnKeyup($('#questionnaire_response_email_outro_text'), $('#outro_text'));
    };

    let initializeSummernoteAndUpdateElementOnKeyup = function (summernoteEl, targetEl) {
        summernoteEl.summernote({
            height: 150,
            callbacks: {
                onChange: function (contents) {
                    setTimeout(function () {
                        targetEl.html(contents);
                    }, 50);
                }
            }
        });
    };

    let init = function () {

        initializeSubmitFormListener();
        initializeImgFileChangePreviewHandlers();
        initializeSummernote();

    };
    $(document).ready(function () {
        init();
    });
})();
