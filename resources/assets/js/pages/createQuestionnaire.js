let SurveyEditor = require('surveyjs-editor');

(function () {
    let editor;

    let initQuestionnaireEditor = function () {
        SurveyEditor.StylesManager.applyTheme("darkblue");
        let editorOptions = {
            generateValidJSON: true,
            showJSONEditorTab: false,
            showTestSurveyTab: false,
            showEmbededSurveyTab: false,
            showPropertyGrid: false,
            toolbarItems: {visible: false}
        };
        editor = new SurveyEditor.SurveyEditor("questionnaire-editor", editorOptions);
    };

    let initLanguagesSelect2 = function () {
        $('#language').select2();
    };

    let saveQuestionnaire = function () {
        let self = $(this);
        let title = $('#title').val().trim();
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
                data: {title, language, project, content},
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
    };

    let init = function () {
        initLanguagesSelect2();
        initQuestionnaireEditor();
        initEvents();
    };

    init();
})();