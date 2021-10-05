const Stepper = require('bs-stepper');

(function () {
    let stepper;

    let initializeSummernote = function () {
        $('.summernote').summernote({
            tabsize: 2,
            height: 300,
            dialogsInBody: true
        });
    };

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

    let initializeStepper = function () {
        const stepperEl = $('#project-form-stepper')[0];
        stepper = new Stepper(stepperEl);
        $("body").on('click', '.stepper-next', function () {
            stepper.next();
        });
        $("body").on('click', '.stepper-previous', function () {
            stepper.previous();
        });

        stepperEl.addEventListener('show.bs-stepper', function (event) {
            $('#form-error-message').addClass('d-none');
            // if on last step, show form submit button
            if (event.detail.indexStep === 4) {
                $('.stepper-next').addClass('d-none');
                $('#submit-form').removeClass('d-none');
            } else {
                $('.stepper-next').removeClass('d-none');
                $('#submit-form').addClass('d-none');
            }
            // if trying to navigate away from first step, perform validation
            if (event.detail.from === 0) {
                let form = $('#project-form')[0];
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    $('#form-error-message').removeClass('d-none');
                    form.classList.add('was-validated');
                }
            }
        })
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
        initializeSummernote();
        initializeImgFileChangePreviewHandlers();
        initializeStepper();
        initializeCommunicationResourcesHandlers();
    };
    $(document).ready(function () {
        init();
    });
})();
