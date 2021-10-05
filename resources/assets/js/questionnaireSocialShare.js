import AnalyticsLogger from "./analytics-logger";

(function () {

    let socialShareHandler = function () {
        $("body").on("click", ".social-share-button", function (e) {
            setTimeout(function () {
                $(".share-success").removeClass("hidden");
            }, 5000);
            const project = $(this).data("project");
            const questionnaire = $(this).data("questionnaire");
            const questionnaireId = $(this).data("questionnaireid");
            const medium = $(this).data("medium");
            const url = $(this).attr("href");
            AnalyticsLogger.logEvent('questionnaire_share_' + questionnaire, 'share', JSON.stringify({
                'questionnaire': questionnaire,
                'project': project,
                'medium': medium,
                'url': url
            }), questionnaireId);
        });
    };

    let init = function () {
        socialShareHandler();
    };

    init();
})();
