(function () {
    let addNewTranslationItemInTranslationWrapperList = function (selectedLangVal) {
        $(".translation-wrapper").append("<div class='translation-item hide' data-lang-id='" + selectedLangVal + "'>" +
            "<div class='row'><div class='col-md-6 default'></div><div class='col-md-6 translation'></div></div></div>");
    };

    let addNewLanguageForQuestionnaire = function () {
        let selectedLangVal = $("#language-to-translate").val();
        let selectedLang = $("#language-to-translate").find("option[value='" + selectedLangVal + "']").html();
        $(".languages-wrapper").append("<a href='javascript:void(0)' class='btn btn-block btn-default' " +
            "data-lang-id='" + selectedLangVal + "'>" + selectedLang + "</a>");
        $(".languages-wrapper").closest(".row").removeClass("hide");
        addNewTranslationItemInTranslationWrapperList(selectedLangVal);
        $(this).closest('.modal').modal('hide');
    };

    let initEvents = function () {
        let modal = $("#add-new-lang-modal");
        modal.find('a').on('click', addNewLanguageForQuestionnaire);
    };

    let init = function () {
        initEvents();
    };

    init();
})();