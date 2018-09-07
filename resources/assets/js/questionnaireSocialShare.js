(function () {

    let socialShareHandler = function() {
        $("body").on("click", ".social-share-button", function (e) {
            setTimeout(function(){
                $(".share-success").removeClass("hidden");
            }, 5000);
        });
    };

    let init = function () {
        socialShareHandler();
    };

    init();
})();