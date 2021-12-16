import AnalyticsLogger from "../analytics-logger";

(function () {

    let displayTranslation = function () {

        if ($(this).find("option:selected").data("machine-generated") == 1)
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
        let respondQuestionnaire = $("#project-motto").find(".respond-questionnaire");
        if (respondQuestionnaire.first().data("open-on-load") === 1)
            respondQuestionnaire.first().trigger("click");
    };

    let init = function () {
        initEvents();
        openQuestionnaireIfNeeded();
        const projectEl = $("#project");
        if (projectEl.data("name"))
            AnalyticsLogger.logEvent('project_landing_page', 'view_' + projectEl.data("name"), projectEl.data("name"), parseInt(projectEl.data("id")));
    };
    $(document).ready(function () {
        init();
    });
})();
