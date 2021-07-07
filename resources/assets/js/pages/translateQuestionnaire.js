(function () {
    let translationsData;
    let languagesData;

    let selectLanguage = function (selectedLangVal) {
        let languagesWrapper = $(".languages-wrapper");
        let translationWrapper = $(".translation-wrapper");
        let newlySelectedTab = languagesWrapper.find(".lang-selector[data-lang-id='" + selectedLangVal + "']");
        if (!newlySelectedTab.hasClass("btn-info")) {
            let newlySelectedTranslation = translationWrapper.find(".translation-item[data-lang-id='" + selectedLangVal + "']");
            languagesWrapper.find(".lang-selector").removeClass("btn-info").addClass("btn-default");
            translationWrapper.find(".translation-item").addClass("d-none");
            newlySelectedTab.removeClass("btn-default").addClass("btn-info");
            newlySelectedTranslation.removeClass("d-none");
        }
    };

    let addNewTranslationItemInTranslationWrapperList = function (selectedLangVal, selectedLangCode, isAlreadyTranslated, languageName) {
        let string = "<div class='translation-item d-none' data-lang-id='" + selectedLangVal + "' data-lang-code='" + selectedLangCode + "'>";
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
                    string += "<div class='table-row'><div class='table-cell'><b>" + (i + 1) + ". <span class='to-translate'>" + obj.question + "</span></b></div><div class='table-cell'>" +
                        "<textarea class='form-control' name='question-" + obj.question_id + "' data-name='" + obj.question_name + "'>" +
                        (isAlreadyTranslated && obj.translated_question ? obj.translated_question : obj.question) + "</textarea>" +
                        "<a href='javascript:void(0)' class='refresh-translation-for-string'><i class='fa fa-refresh'></i></a>"+
                        "</div></div>";
                }
                if (obj.answer !== null) {
                    string += "<div class='table-row'><div class='table-cell'><b style='margin-left: 30px; display: block;'><span class='to-translate'>" + obj.answer + "</span></b></div><div class='table-cell'>" +
                        "<textarea class='form-control' name='answer-" + obj.answer_id + "' data-name='" + obj.question_name + "' data-value='" + obj.answer_value + "'>" +
                        (isAlreadyTranslated && obj.translated_answer ? obj.translated_answer : obj.answer) + "</textarea>" +
                        "<a href='javascript:void(0)' class='refresh-translation-for-string'><i class='fa fa-refresh'></i></a>"+
                        "</div></div>";
                }
                if (obj.html !== null) {
                    string += "<div class='table-row'><div class='table-cell'><b>" + (i + 1) + ". <span class='to-translate'>" + obj.html + "</span></b></div><div class='table-cell'>" +
                        "<textarea class='form-control' name='html-" + obj.html_id + "' data-name='" + obj.question_name + "'>" +
                        (isAlreadyTranslated && obj.translated_html ? obj.translated_html : obj.html) + "</textarea>" +
                        "<a href='javascript:void(0)' class='refresh-translation-for-string'><i class='fa fa-refresh'></i></a>"+
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
        let selectedLangCode = $("#language-to-translate").find("option[value='" + selectedLangVal + "']").data('lang-code');
        const questionnaireLanguage = getQuestionnaireLanguageFromLangCode(selectedLangCode);
        let tooltip = "";
        let warning = "";
        let translationMarkBtn = "";

        if(questionnaireLanguage)
            if( questionnaireLanguage.machine_generated_translation) {
                tooltip = 'data-widget="tooltip" title="Translated by Google"';
                warning = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
                translationMarkBtn = '<a class="mark-lang" data-mark-human="1" href="#">Mark as human approved</a>';
            } else {
                translationMarkBtn = '<a class="mark-lang" data-mark-human="0" href="#">Mark as Translated by Google</a>'
            }

        let languageButton = '<div class="btn-group">' +
            '  <button data-lang-id="' + selectedLangVal + '" ' + tooltip + ' type="button" class="btn  btn-block btn-default lang-selector">' +
                warning + ' ' + '<span class="title">' + selectedLang +'</span>' + '</button>' +
            '  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
            '    <span class="caret"></span>' +
            '    <span class="sr-only">Toggle Dropdown</span>' +
            '  </button>' +
            '  <ul class="dropdown-menu lang-data" data-lang-id="' + selectedLangVal + '">' +
            '    <li class="dropdown-item">' + translationMarkBtn + '</li>' +
            '    <li role="separator" class="divider"></li>' +
            '    <li class="dropdown-item"><a class="delete-translation" href="#">Remove Language</a></li>' +
            '  </ul>' +
            '</div>';

        languagesWrapper.append(languageButton);
        languagesWrapper.closest(".row").removeClass("d-none");
        addNewTranslationItemInTranslationWrapperList(selectedLangVal, selectedLangCode, isAlreadyTranslated, languageName);
    };

    let getQuestionnaireLanguageFromLangCode = function (selectedLangCode) {
        for(let i = 0; i <languagesData.length; i++) {
            if(languagesData[i].language.language_code === selectedLangCode)
                return languagesData[i];
        }
    };

    let addNewLanguageForQuestionnaire = function () {
        let languageToTranslateSelect = $("#language-to-translate");
        let selectedLangVal = languageToTranslateSelect.val();
        let isNewLangAdded = false;
        if ($(".lang-selector[data-lang-id='" + selectedLangVal + "']").length === 0) {
            addNewLanguageTabAndWrapper(selectedLangVal);
            isNewLangAdded = true;
        }
        selectLanguage(selectedLangVal);
        if (isNewLangAdded)
            autotranslateData();
        else
            $(this).closest('.modal').modal('hide');
    };

    let changeLanguageViaTabClick = function () {
        selectLanguage($(this).data("lang-id"));
    };

    let autotranslateData = function () {
        let modal = $("#add-new-lang-modal");
        let translationItem = $(".translation-item:visible");
        let languageCodeToTranslateTo = translationItem.data('lang-code');
        let ids = [];
        let texts = [];
        translationItem.find('.table-row').each(function () {
            let cells = $(this).find('.table-cell');
            texts.push($(cells[0]).find('.to-translate').html());
            ids.push($(cells[1]).find('textarea').attr('name'));
        });
        console.log(texts);

        let i, j, tempTexts, tempIds, chunk = 50;

        for (i = 0 , j = texts.length ; i < j ; i += chunk) {
            tempTexts = texts.slice(i,i+chunk);
            tempIds = ids.slice(i,i+chunk);
            setTimeout(translateTextsInChunks,i*60000, modal, translationItem, languageCodeToTranslateTo, tempIds, tempTexts);
        }
    };

    let translateTextsInChunks = function(modal, translationItem, languageCodeToTranslateTo, ids, texts) {
        console.log('texts to translate now', texts);
        $.ajax({
            method: 'post',
            url: $(".translation-wrapper").data("url"),
            data: {languageCodeToTranslateTo, ids, texts},
            beforeSend: function () {
                modal.modal('show');
                modal.addClass("loading");
            },
            success: function (response) {
                for (let i = 0; i < ids.length; i++) {
                    let key = ids[i];
                    translationItem.find("textarea[name='" + key + "']").text(response.translations[key].text);
                }
            },
            error: function () {
                swal({
                    title: "Oops!",
                    text: "An error occurred, translations could not be autogenerated.",
                    type: "error",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "OK",
                });
            },
            complete: function () {
                modal.removeClass("loading");
                modal.modal('hide');
            }
        });
    };

    let saveTranslations = function () {
        let self = $(this);
        if (self.hasClass("busy"))
            return;

        let translations = {};
        $(".translation-item").each(function () {
            let langId = $(this).data("lang-id");
            let translationTexts = [];
            $(this).find("textarea").each(function () {
                let nameFromTextArea = $(this).attr("name").split("-");
                let type = nameFromTextArea[0];
                let id = nameFromTextArea[1];
                let value = $(this).data("value");
                let translation = $(this).val();
                let name = $(this).data("name");
                translationTexts.push({id, type, value, name, translation});
            });
            translations[langId] = {translations: translationTexts};
        });
        $.ajax({
            method: 'post',
            url: self.data('url'),
            data: {translations: JSON.stringify(translations)},
            beforeSend:function(){
                self.addClass("busy");
            },
            complete:function(){
                self.removeClass("busy");
            },
            success: function (response) {
                showSuccessAlert("The translations have been successfully stored.", function () {
                    window.location = response.redirect_url;
                });
            },
            error: function () {
                showErrorAlert();
            }
        });
    };

    let markLanguageAs = function() {
        let self = $(this);
        if (self.hasClass("busy"))
            return;
        const parent = $(this).parents(".lang-data");
        const outerParent = $(this).parents(".languages-wrapper");

        const markAsHuman = parseInt($(this).data("mark-human"));
        const langId = parent.data("lang-id");
        const questionnaireId = outerParent.data("questionnaire-id");

        const data = {mark_human: markAsHuman, lang_id: langId, questionnaire_id: questionnaireId};
        const url = outerParent.data("mark-translation-url");
        $.ajax({
            method: 'post',
            url: url,
            data: data,
            beforeSend:function(){
                self.addClass("busy");
            },
            complete:function(){
                self.removeClass("busy");
            },
            success: function (responseStr) {
                let response = JSON.parse(responseStr);
                if(response.status === 1) {
                    showSuccessAlert("The translation has been successfully updated.", function () {
                        window.location.reload();
                    });
                } else {
                    showErrorAlert();
                }
            },
            error: function (error) {
                showErrorAlert();
            }
        });
    };

    let deleteTranslationHandler = function() {
        let self = $(this);
        swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this translation.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function(){
                deleteTranslation(self);
            });
    };

    let deleteTranslation = function(element) {
        if (element.hasClass("busy"))
            return;
        const parent = element.parents(".lang-data");
        const outerParent = element.parents(".languages-wrapper");
        const langId = parent.data("lang-id");
        const questionnaireId = outerParent.data("questionnaire-id");
        const data = {lang_id: langId, questionnaire_id: questionnaireId};
        const url = outerParent.data("delete-translation-url");

        $.ajax({
            method: 'post',
            url: url,
            data: data,
            beforeSend:function(){
                element.addClass("busy");
            },
            complete:function(){
                element.removeClass("busy");
            },
            success: function (responseStr) {
                let response = JSON.parse(responseStr);
                if(response.status === 1) {
                    showSuccessAlert("The translation has been successfully deleted.", function () {
                        window.location.reload();
                    });
                } else {
                    showErrorAlert();
                }
            },
            error: function (error) {
                showErrorAlert();
            }
        });
    };

    let showSuccessAlert = function(title, _callback) {
        swal({
            title: "Success!",
            text: title,
            type: "success",
            confirmButtonClass: "btn-success",
            confirmButtonText: "OK",
        }, function () {
            _callback();
        });
    };

    let showErrorAlert = function(title) {
        swal({
            title: "Oops!",
            text: title ? title : "An error occurred, please try again later.",
            type: "error",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "OK",
        });
    };

    let readDOMData = function () {
        const element = $(".translation-wrapper");
        translationsData = element.data("translations");
        languagesData = element.data("languages");
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
    let refreshTranslationForSingleString= function(){

        var button = $(this);
        if (button.hasClass("busy"))
            return; //cancel

        var textArea = button.prev();
        var textToTranslate = button.parent().prev().text();
        var language = button.parents(".translation-item").data("lang-code");

        $.ajax({
            method: 'post',
            url:"/automatic-translation-single-string",
            data:"languageCodeToTranslateTo="+language+"&text="+textToTranslate ,
            beforeSend:function(){
                button.addClass("busy");
            },
            complete: function(){
                button.removeClass("busy");
            },
            success: function (response) {
                if (response.length>0)
                    textArea.text(response[0].text);

                else
                    swal({
                        title: "Could not fetch translation",
                        type: "info",
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK",
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


    }
    let initEvents = function () {
        let body = $("body");
        body.on("click", ".lang-selector", changeLanguageViaTabClick);
        body.on("click", ".save-translations", saveTranslations);
        body.on("click", ".refresh-translation-for-string",refreshTranslationForSingleString);
        body.on("click", ".mark-lang", markLanguageAs);
        body.on("click", ".delete-translation", deleteTranslationHandler);
        let modal = $("#add-new-lang-modal");
        modal.find('a').on('click', addNewLanguageForQuestionnaire);
    };

    let init = function () {
        initEvents();
        readDOMData();
        fillTranslationsTableFromData();
    };

    init();
})();
