let Survey = require('survey-jquery');
let ProgressBar = require('progressbar.js');

(function () {
    let survey;

    let displayQuestionnaire = function () {
        let wrapperId = 'questionnaire-display-section';
        let wrapper = $('#' + wrapperId);
        if (wrapper.length > 0) {
            Survey.StylesManager.applyTheme("darkblue");
            Survey.surveyStrings.emptySurvey = "There is not currently an active survey.";
            Survey.surveyStrings.loadingSurvey = "Please wait. The survey is loading…";

            let json = wrapper.data('content');
            /*json.pages.forEach(function(page){
                page.elements.forEach(function(question){
                    if (question.hasOther)
                    {
                        question.otherText={default:"test", bg:"bulgarian other"};
                    }
                });
            });*/

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
                            console.log(response);
                            $(".loader-wrapper").addClass('hidden');
                            let questionnaireResponded = $("#questionnaire-responded");
                            // add badge fetched from response to the appropriate container
                            if (response.status === "__SUCCESS" && response.badgeHTML)
                                questionnaireResponded.find('.badge-container').html(response.badgeHTML);
                            questionnaireResponded.modal({backdrop: 'static'});
                            $("#pyro").addClass("pyro-on");
                        }
                    });
                });
            var converter = new showdown.Converter();
            survey
                .onTextMarkdown
                .add(function (survey, options) {
                    //convert the mardown text to html
                    let str = converter.makeHtml(options.text);
                    //remove root paragraphs <p></p>
                    str = str.substring(3);
                    str = str.substring(0, str.length - 4);
                    //set html
                    options.html = str;
                });
            survey
                .onRendered
                .add(function () {
                    $(".sv_complete_btn").after("<p class='questionnaire-disclaimer'>Your personal information (email address) will never be publicly displayed.</p>");
                    $('.sv_complete_btn').remove();
                });
        }
        displayTranslation.apply($('#questionnaire-lang-selector'));
    };

    let displayTranslation = function () {

        survey.locale = $(this).val();
        survey.render();

       if ($(this).find("option:selected").data("machine-generated")==1)
           $("#machine-translation-indicator").removeClass("hide");
        else
           $("#machine-translation-indicator").addClass("hide");
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
