import AnalyticsLogger from "../analytics-logger";
import {showToast} from "../common-utils";

(function () {

    let handleLogoutBtnClick = function () {
        $("#log-out").click(function (e) {
            e.preventDefault();
            $("#logout-form").submit();
        });
    }


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

    let init = function () {
        initEvents();
        openQuestionnaireIfNeeded();
        const projectEl = $("#project");
        if (projectEl.data("name"))
            AnalyticsLogger.logEvent('project_landing_page', 'view_' + projectEl.data("name"), projectEl.data("name"), parseInt(projectEl.data("id")));

        handleLogoutBtnClick();
        showToast(
            '<div class="project-toast"><h3>DATA PRIVACY</h3><br><br>The personal data collected as part of this survey will be used for the sole ' +
            'purpose of the crowdsourcing exercise, which is part of the Horizon2020-funded PopAi project.<br><br>' +
            'Your data will not be used for any other purposes.<br>Please note that we are only collecting personal data that ' +
            'is strictly necessary.<br><br>Data collected as part of our crowdsourcing platform will be destroyed as soon as they are ' +
            'no longer needed for the purposes of this project.<br>At any time you can exercise all the rights provided by the ' +
            'General Data Protection Regulation, including the right to withdraw your consent and the right to request the erasure of ' +
            'your personal data before the end of the project.<br><br>To do so, please email claire.damilano@ecas.org.</div>'
            , '#2e6da4', 'bottom-right', false, null, false)
    };
    $(document).ready(function () {
        init();
        console.log(viewModel);
    });
})();
