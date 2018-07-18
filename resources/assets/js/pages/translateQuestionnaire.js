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

    let addNewTranslationItemInTranslationWrapperList = function (selectedLangVal, isAlreadyTranslated, languageName) {
        let string = "<div class='translation-item hide' data-lang-id='" + selectedLangVal + "'>";
        let languageKey;
        if (isAlreadyTranslated && languageName)
            languageKey = languageName;
        else
            languageKey = Object.keys(translationsData)[0];
        let properties = Object.keys(translationsData[languageKey]);
        for (let i = 0; i < properties.length; i++) {
            for (let j = 0; j < translationsData[languageKey][properties[i]].length; j++) {
                let obj = translationsData[languageKey][properties[i]][j];
                if (j === 0 && obj.html === null) {
                    string += "<div class='table-row'><div class='table-cell'><b>" + (i + 1) + ". " + obj.question + "</b></div><div class='table-cell'>" +
                        "<textarea class='form-control' name='question-" + obj.question_id + "'>" +
                        (isAlreadyTranslated ? obj.translated_question : obj.question) + "</textarea>" +
                        "</div></div>";
                }
                if (obj.answer !== null) {
                    string += "<div class='table-row'><div class='table-cell'><b style='margin-left: 30px; display: block;'>" + obj.answer + "</b></div><div class='table-cell'>" +
                        "<textarea class='form-control' name='answer-" + obj.answer_id + "'>" +
                        (isAlreadyTranslated ? obj.translated_answer : obj.answer) + "</textarea>" +
                        "</div></div>";
                }
                if (obj.html !== null) {
                    string += "<div class='table-row'><div class='table-cell'><b>" + (i + 1) + ". " + obj.html + "</b></div><div class='table-cell'>" +
                        "<textarea class='form-control' name='html-" + obj.html_id + "'>" +
                        (isAlreadyTranslated ? obj.translated_html : obj.html) + "</textarea>" +
                        "</div></div>";
                }
            }
        }
        string += "</div>";
        $(".translation-wrapper").append(string);
    };

    let addNewLanguageTabAndWrapper = function (selectedLangVal, isAlreadyTranslated, languageName) {
        let languagesWrapper = $(".languages-wrapper");
        let selectedLang = $("#language-to-translate").find("option[value='" + selectedLangVal + "']").html();
        languagesWrapper.append("<a href='javascript:void(0)' class='btn btn-block btn-default lang-selector' " +
            "data-lang-id='" + selectedLangVal + "'>" + selectedLang + "</a>");
        languagesWrapper.closest(".row").removeClass("hide");
        addNewTranslationItemInTranslationWrapperList(selectedLangVal, isAlreadyTranslated, languageName);
    };

    let addNewLanguageForQuestionnaire = function () {
        let languageToTranslateSelect = $("#language-to-translate");
        let selectedLangVal = languageToTranslateSelect.val();
        if ($(".lang-selector[data-lang-id='" + selectedLangVal + "']").length === 0) {
            addNewLanguageTabAndWrapper(selectedLangVal);
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

    let fillTranslationsTableFromData = function () {
        let languages = [];
        for (let prop in translationsData) {
            if (translationsData.hasOwnProperty(prop) && prop !== "")
                languages.push(prop);
        }
        for (let i = 0; i < languages.length; i++) {
            let selectedLangVal = translationsData[languages[i]][Object.keys(translationsData[languages[i]])[0]][0].language_id;
            addNewLanguageTabAndWrapper(selectedLangVal, true, languages[i]);
            if (i === 0)
                selectLanguage(selectedLangVal);
        }
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
        fillTranslationsTableFromData();
    };

    init();
})();