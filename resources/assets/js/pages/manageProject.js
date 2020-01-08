require('summernote');

(function () {

    let initializeSummernote = function () {
        $('.summernote').summernote({
            tabsize: 2,
            height: 300
        });
    };

    let initializeColorPicker = function () {
        $('.color-picker').each(function(i, obj) {
            $(obj).colorpicker({
                horizontal: true
            });
        });

    };

    let initializeImgFileChangePreviewHandlers = function () {
        $('.image-input').each(function(i, obj) {
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

    let init = function () {
        initializeSummernote();
        initializeColorPicker();
        initializeImgFileChangePreviewHandlers();
    };

    init();
})();
