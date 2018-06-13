(function () {
    let clickCMSBlock = function () {
        let self = $(this);
        if (!self.hasClass("sent")) {
            if (self.hasClass("selected"))
                $(this).removeClass("selected");
            else
                $(this).addClass("selected");
        }
    };

    let initEvents = function () {
        $("body").on("click", ".cms-block", clickCMSBlock);
    };

    initEvents();
})();