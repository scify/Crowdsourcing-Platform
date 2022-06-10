import AnalyticsLogger from "../analytics-logger";
import {showToast} from "../common-utils";

(function () {

    let displayTranslation = function () {

        if ($(this).find("option:selected").data("machine-generated") === 1)
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
        if (respondQuestionnaire.first().data("open-on-load") === 1) {
            respondQuestionnaire.first().trigger("click");
        }
    };

    let logToAnalytics = function () {
        const projectEl = $("#project");
        if (projectEl.data("name"))
            AnalyticsLogger.logEvent('project_landing_page', 'view_' + projectEl.data("name"), projectEl.data("name"), parseInt(projectEl.data("id")));
    };

    let showProjectBannerIfEnabled = function () {
        if (viewModel.project.display_landing_page_banner) {
            let bannerTitle = viewModel.project.currentTranslation ? viewModel.project.currentTranslation.banner_title : viewModel.project.default_translation.banner_title;
            let bannerText = viewModel.project.currentTranslation ? viewModel.project.currentTranslation.banner_text : viewModel.project.default_translation.banner_text;
            if (bannerTitle || bannerText)
                showToast(
                    '<div class="project-toast"><h3>' + bannerTitle + '</h3><br><br>' + bannerText + '</div>',
                    '#2e6da4', 'bottom-right', false, null, false);
        }

    };

    let init = function () {
        initEvents();
        openQuestionnaireIfNeeded();
        logToAnalytics();
        showProjectBannerIfEnabled();
    };
    $(document).ready(function () {
        init();
    });
})();
