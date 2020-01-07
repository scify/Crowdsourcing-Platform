require('summernote');

(function () {

    let initializeSummernote = function () {
        $('.summernote').summernote({
            tabsize: 2,
            height: 300
        });
    };

    let initializeColorPicker = function () {
        $('#bg_color').colorpicker({
            horizontal: true
        });
    };

    let init = function () {
        initializeSummernote();
        initializeColorPicker();
    };

    init();
})();
