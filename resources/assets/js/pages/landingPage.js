import AnalyticsLogger from "../analytics-logger";

//TODO: THIS EXISTS ALSO TO COMMON.JS
window.wa = {};
window.wa.enums = {};
window.swal = require('bootstrap-sweetalert');
window.Popper = require('@popperjs/core');
window.route = require('../backend-route');

require('../bootstrap');
import languageBundle from '@kirschbaum-development/laravel-translations-loader!@kirschbaum-development/laravel-translations-loader';
import Vue from 'vue';
import store from '../store/store';
Vue.component('modal', require('../vue-components/common/ModalComponent').default);
Vue.component('store-modal', require('../vue-components/common/StoreModalComponent').default);
Vue.component('questionnaire-display', require('../vue-components/questionnaire/QuestionnaireDisplay').default);

const app = new Vue({
    el: '#app',
    store: store
});
//END OF TODO: THIS EXISTS ALSO TO COMMON.JS
(function () {

    //TODO: THIS EXIST ALSO TO COMMON.JS , SEPERATE TO COMMON FILE
    window.language= languageBundle;
    Number.prototype.round = function (places) {
        return +(Math.round(this + "e+" + places) + "e-" + places);
    };
    window.wa.roundNumber = function (num, places) {
        return +(Math.round(parseFloat(num) + "e+" + places) + "e-" + places);
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let handleLogoutBtnClick = function () {
        $("#log-out").click(function (e) {
            e.preventDefault();
            $("#logout-form").submit();
        });
    }

    //END OF TODO: THIS EXIST ALSO TO COMMON.JS , SEPERATE TO COMMON FILE


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
        if (respondQuestionnaire.first().data("open-on-load") === 1){
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
    };
    $(document).ready(function () {
        init();
    });
})();
