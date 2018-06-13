(function() {
    var reselectAccountType = function() {
        $(".login-box-msg").show();
        $(".reselect-account-type").hide();
        $(".account-type-btn").slideToggle("slow");
        $(".form-wrapper").slideUp("slow");
    };

    var displayFormForAccountType = function() {
        $(".login-box-msg").hide();
        $(".reselect-account-type").css("display", "block");
        $(".account-type-btn").slideToggle("slow");
        $($(this).data("target")).slideToggle("slow");
    };

    var displayFormContainingErrors = function() {
        var role = $(".role-after-validation-fail").data("role");
        if (role === "journalist" || role === "publisher") {
            $(".login-box-msg").hide();
            $(".reselect-account-type").css("display", "block");
            $(".account-type-btn").hide();
            $("." + role + "-form-wrapper").show();
        }
    };

    var initEvents = function() {
        var $body = $("body");
        $body.on("click", ".account-type-btn", displayFormForAccountType);
        $body.on("click", ".reselect-account-type", reselectAccountType);
    };

    initEvents();
    displayFormContainingErrors();
})();