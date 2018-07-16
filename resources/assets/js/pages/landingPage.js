let Survey = require('survey-jquery');

(function () {
    let displayQuestionnaire = function () {
        let wrapperId = 'questionnaire-display-section';
        let wrapper = $('#' + wrapperId);
        if (wrapper.length > 0) {
            let json = wrapper.data('content');
            Survey.StylesManager.applyTheme("darkblue");
            Survey.surveyStrings.emptySurvey = "There is not currently an active survey.";
            Survey.surveyStrings.loadingSurvey = "Please wait. The survey is loading…";
            let survey = new Survey.Survey(JSON.stringify(json), wrapperId);
            survey
                .onComplete
                .add(function (result) {
                    let button = $('#respond-questionnaire-btn');
                    let response = JSON.stringify(result.data);
                    let questionnaire_id = button.data('questionnaire-id');
                    let url = button.data('url');
                    $.ajax({
                        method: 'post',
                        data: {questionnaire_id, response},
                        url: url,
                        beforeSend: function () {

                        },
                        success: function (response) {

                        },
                        error: function () {

                        }
                    });
                });
        }
    };

    let init = function () {
        displayQuestionnaire();
    };

    init();
})();