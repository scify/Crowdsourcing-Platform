let SurveyEditor = require('surveyjs-editor');

(function () {
    let editor;

    let initQuestionnaireEditor = function () {
        // documentation may be found here: https://surveyjs.io/Documentation/Builder
        SurveyEditor.StylesManager.applyTheme("darkblue");
        let editorOptions = {
            generateValidJSON: true,
            showJSONEditorTab: false,
            showTestSurveyTab: false,
            showEmbededSurveyTab: false,
            showPropertyGrid: false,
            toolbarItems: {visible: false},
            showPagesToolbox: false,
            questionTypes: ["text", "checkbox", "radiogroup", "dropdown", "rating", "html", "comment"]
        };
        editor = new SurveyEditor.SurveyEditor("questionnaire-editor", editorOptions);
        let json = $("#questionnaire-editor").data('json');
        if (json !== '')
            editor.text = JSON.stringify(json);
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

    let saveQuestionnaire = function () {
        let self = $(this);
        let title = $('#title').val().trim();
        let description = $('#description').val().trim();
        let goal = $('#goal').val().trim();
        let project = $('#project-id').val();
        let language = $('#language').val();
        let content = editor.text;
        if (title === '')
            swal({
                title: "Oops!",
                text: "The title is required.",
                type: "error",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "OK",
            });
        else {
            $.ajax({
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
            });
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