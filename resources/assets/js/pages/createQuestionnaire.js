let SurveyEditor = require('surveyjs-editor');

(function () {
    let editor;

    let initQuestionnaireEditor = function () {
        // documentation may be found here: https://surveyjs.io/Documentation/Builder
        SurveyEditor.StylesManager.applyTheme("darkblue");
        let editorOptions = {
            generateValidJSON: true,
            showJSONEditorTab: false,
            showTestSurveyTab: true,
            showEmbededSurveyTab: false,
            showPropertyGrid: false,
            toolbarItems: {visible: false},
            showPagesToolbox: false,
            questionTypes: ["text", "checkbox", "radiogroup", "dropdown", "html", "comment"]
        };
        editor = new SurveyEditor.SurveyEditor("questionnaire-editor", editorOptions);
        let json = $("#questionnaire-editor").data('json');
        if (json !== '')
            editor.text = JSON.stringify(json);
        // disable "Fast Entry" for choices
        editor.onSetPropertyEditorOptions.add(function (survey, options) {
            options.editorOptions.showTextView = false;
        });
    };

    let disableNameInputField = function () {
        $('#surveyquestioneditorwindow input').first().attr('disabled', 'disabled');
        $('#surveyquestioneditorwindow .form-group').first().css('display', 'none');
    };

    let disableNameInputForChoices = function () {
        if ($(this).find('span').html().trim() === 'Choices') {
            $('#surveyquestioneditorwindow .svd_items_table tr').each(function () {
                $($(this).find('td').get(1)).find('input').attr('disabled', 'disabled');
            });
        }
    };

    let disableNameInputForNewChoice = function () {
        let header = $(this).closest('.svd-accordion-tab-content').prev();
        disableNameInputForChoices.call(header);
    };

    let initLanguagesSelect2 = function () {
        $('#language').select2();
    };

    let getGuid = function () {
        let S4 = function () {
            return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
        };
        return (S4() + S4() + "-" + S4() + "-4" + S4().substr(0, 3) + "-" + S4() + "-" + S4() + S4() + S4()).toLowerCase();
    };

    let addGuidsToContent = function (content) {
        let json = JSON.parse(content);
        let questions = json.pages[0].elements;
        console.log(json);
        for (let i = 0; i < questions.length; i++) {
            if (!questions[i].guid){
                console.log("adding guid to question");
               // questions[i].guid = getGuid();
            }

            if (questions[i].choices) {
                let answers = json.pages[0].elements[i].choices;
                for (let j = 0; j < answers.length; j++) {
                    if (!answers[j].text) {
                        let originalValue = answers[j];
                        answers[j] = {};
                        answers[j].text = originalValue;
                        answers[j].value = originalValue;
                    }
                    if (!answers[j].guid){
                        console.log("adding guid to answer");
                       // answers[j].guid = getGuid();
                    }

                }
            }
        }
        return JSON.stringify(json);
    };

    let saveQuestionnaire = function () {
        let self = $(this);
        let title = $('#title').val().trim();
        let description = $('#description').val().trim();
        let goal = $('#goal').val().trim();
        let project = $('#project-id').val();
        let language = $('#language').val();
        let content = editor.text;
        content = addGuidsToContent(content);
        if (title === '')
            swal({
                title: "Oops!",
                text: "The title is required.",
                type: "error",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "OK",
            });
        else {
           /* $.ajax({
                method: 'post',
                url: self.data('url'),
                data: {title, description, goal, language, project, content},
                success: function (response) {
                    if (response.status === '__SUCCESS') {
                        swal({
                            title: "Success!",
                            text: "The questionnaire has been successfully stored.",
                            type: "success",
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "OK",
                        }, function () {
                            window.location = response.redirect_url;
                        });
                    } else {
                        swal({
                            title: "Oops!",
                            text: "An error occurred, please try again later.",
                            type: "error",
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "OK",
                        });
                    }
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
            });*/
        }
    };

    let initEvents = function () {
        $("#save").click(saveQuestionnaire);
        let body = $("body");
        body.on('click', '.svda_question_action[title="Edit"]', disableNameInputField);
        body.on('click', '.svd-accordion-tab-header', disableNameInputForChoices);
        body.on('click', 'input[value="Add New"]', disableNameInputForNewChoice);
    };

    let init = function () {
        initLanguagesSelect2();
        initQuestionnaireEditor();
        initEvents();
    };

    init();
})();