let SurveyEditor = require('surveyjs-editor');

(function () {
    let init = function () {
        SurveyEditor
            .StylesManager
            .applyTheme("darkblue");

        let editorOptions = {
            showJSONEditorTab: false,
            showTestSurveyTab: false,
            showEmbededSurveyTab: false,
        };
        let editor = new SurveyEditor.SurveyEditor("editorElement", editorOptions);
    };

    init();
})();