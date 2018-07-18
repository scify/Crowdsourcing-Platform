(function () {
    let translationsData;

    let selectLanguage = function (selectedLangVal) {
        let languagesWrapper = $(".languages-wrapper");
        let translationWrapper = $(".translation-wrapper");
        let newlySelectedTab = languagesWrapper.find(".lang-selector[data-lang-id='" + selectedLangVal + "']");
        if (!newlySelectedTab.hasClass("btn-info")) {
            let newlySelectedTranslation = translationWrapper.find(".translation-item[data-lang-id='" + selectedLangVal + "']");
            languagesWrapper.find(".lang-selector").removeClass("btn-info").addClass("btn-default");
            translationWrapper.find(".translation-item").addClass("hide");
            newlySelectedTab.removeClass("btn-default").addClass("btn-info");
            newlySelectedTranslation.removeClass("hide");
        }
    };

    let addNewTranslationItemInTranslationWrapperList = function (selectedLangVal) {
        let string = "<div class='translation-item hide' data-lang-id='" + selectedLangVal + "'>";
        let properties = [];
        for (let prop in translationsData[""]) {
            if (translationsData[""].hasOwnProperty(prop))
                properties.push(prop);
        }
        for (let i = 0; i < properties.length; i++) {
            for (let j = 0; j < translationsData[""][properties[i]].length; j++) {
                let obj = translationsData[""][properties[i]][j];
                if (j === 0 && obj.html === null) {
                    string += "<div class='table-row'><div class='table-cell'><b>" + (i + 1) + ". " + obj.question + "</b></div><div class='table-cell'>" +
                        "<textarea class='form-control' name='question-" + obj.question_id + "'>" + obj.question + "</textarea>" +
                        "</div></div>";
                }
                if (obj.answer !== null) {
                    string += "<div class='table-row'><div class='table-cell'><b style='margin-left: 30px; display: block;'>" + obj.answer + "</b></div><div class='table-cell'>" +
                        "<textarea class='form-control' name='answer-" + obj.answer_id + "'>" + obj.answer + "</textarea>" +
                        "</div></div>";
                }
                if (obj.html !== null) {
                    string += "<div class='table-row'><div class='table-cell'><b>" + (i + 1) + ". " + obj.html + "</b></div><div class='table-cell'>" +
                        "<textarea class='form-control' name='html-" + obj.html_id + "'>" + obj.html + "</textarea>" +
                        "</div></div>";
                }
            }
        }
        string += "</div>";
        $(".translation-wrapper").append(string);
    };

    let addNewLanguageForQuestionnaire = function () {
        let languageToTranslateSelect = $("#language-to-translate");
        let languagesWrapper = $(".languages-wrapper");
        let selectedLangVal = languageToTranslateSelect.val();
        if ($(".lang-selector[data-lang-id='" + selectedLangVal + "']").length === 0) {
            let selectedLang = languageToTranslateSelect.find("option[value='" + selectedLangVal + "']").html();
            languagesWrapper.append("<a href='javascript:void(0)' class='btn btn-block btn-default lang-selector' " +
                "data-lang-id='" + selectedLangVal + "'>" + selectedLang + "</a>");
            languagesWrapper.closest(".row").removeClass("hide");
            addNewTranslationItemInTranslationWrapperList(selectedLangVal);
        }
        selectLanguage(selectedLangVal);
        $(this).closest('.modal').modal('hide');
    };

    let changeLanguageViaTabClick = function () {
        selectLanguage($(this).data("lang-id"));
    };

    let readTranslationData = function () {
        translationsData = $(".translation-wrapper").data("translations");
    };

    let saveTranslations = function () {
        let self = $(this);
        let translations = {};
        $(".translation-item").each(function () {
            let langId = $(this).data("lang-id");
            let translationTexts = [];
            $(this).find("textarea").each(function () {
                let nameFromTextArea = $(this).attr("name").split("-");
                let type = nameFromTextArea[0];
                let id = nameFromTextArea[1];
                let value = $(this).val();
                translationTexts.push({id, type, value});
            });
            translations[langId] = {translations: translationTexts};
        });
        $.ajax({
            method: 'post',
            url: self.data('url'),
            data: {translations: translations},
            success: function (response) {
                swal({
                    title: "Success!",
                    text: "The translations have been successfully stored.",
                    type: "success",
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "OK",
                }, function () {
                    window.location = response.redirect_url;
                });
            },
            error: function () {
                swal({
                    title: "Oops!",
                    text: "An error occurred, please try again later.",
                    type: "error",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "OK",
                });
            }
        });
    };

    let initEvents = function () {
        let body = $("body");
        body.on("click", ".lang-selector", changeLanguageViaTabClick);
        body.on("click", ".save-translations", saveTranslations);
        let modal = $("#add-new-lang-modal");
        modal.find('a').on('click', addNewLanguageForQuestionnaire);
    };

    let init = function () {
        initEvents();
        readTranslationData();
    };

    init();
})();