require('summernote');

(function () {

    let initializeSummernote = function () {
        $('.summernote').summernote({
            tabsize: 2,
            height: 300
        });
    };


    let init = function () {
        initializeSummernote();
    };

    init();
})();