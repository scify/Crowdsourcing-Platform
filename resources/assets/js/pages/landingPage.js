let Survey = require('survey-jquery');
let ProgressBar = require('progressbar.js');

(function () {
    let survey;

    let displayQuestionnaire = function () {
        let wrapperId = 'questionnaire-display-section';
        let wrapper = $('#' + wrapperId);
        if (wrapper.length > 0) {
            let json = wrapper.data('content');
            Survey.StylesManager.applyTheme("darkblue");
            Survey.surveyStrings.emptySurvey = "There is not currently an active survey.";
            Survey.surveyStrings.loadingSurvey = "Please wait. The survey is loading…";
            survey = new Survey.Survey(JSON.stringify(json), wrapperId);
            survey
                .onComplete
                .add(function (result) {
                    $(".loader-wrapper").removeClass('hidden');
                    $("#questionnaire-modal").modal('hide');
                    let button = $('.respond-questionnaire').first();
                    let response = JSON.stringify(result.data);
                    let questionnaire_id = button.data('questionnaire-id');
                    let url = button.data('url');
                    $.ajax({
                        method: 'post',
                        data: {questionnaire_id, response},
                        url: url,
                        success: function (response) {
                            $(".loader-wrapper").addClass('hidden');
                            let questionnaireResponded = $("#questionnaire-responded");
                            // add badge fetched from response to the appropriate container
                            if (response.badge)
                                questionnaireResponded.find('.badge-container').html(response.badge);
                            questionnaireResponded.modal({backdrop: 'static'});
                        }
                    });
                });
        }
        displayTranslation.apply($('#questionnaire-lang-selector'));
    };

    let displayTranslation = function () {
        survey.locale = $(this).val();
        survey.render();
    };

    let refreshPageToTheQuestionnaireSection = function () {
        let split = window.location.toString().split("#");
        window.location = split[0] + "#questionnaire";
        window.location.reload();
    };

    let initEvents = function () {
        $('#questionnaire-lang-selector').on('change', displayTranslation);
        $('#questionnaire-responded').find('.refresh-page').on('click', refreshPageToTheQuestionnaireSection);
    };

    let openQuestionnaireIfNeeded = function () {
        let respondQuestionnaire = $(".respond-questionnaire");
        if (respondQuestionnaire.first().data("open-on-load") === 1)
            respondQuestionnaire.first().trigger("click");

    };

    let init = function () {
        displayQuestionnaire();
        initEvents();
        openQuestionnaireIfNeeded();
    };

    init();
})();