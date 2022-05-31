import languageBundle from '@kirschbaum-development/laravel-translations-loader!@kirschbaum-development/laravel-translations-loader';

window.wa = {};
window.wa.enums = {};
window.swal = import('bootstrap-sweetalert');

import '@popperjs/core';
import route from './backend-route';

window.route = route;

import './bootstrap';

import Vue from 'vue';
import store from './store/store';

Vue.component('modal', require('./vue-components/common/ModalComponent').default);
Vue.component('store-modal', require('./vue-components/common/StoreModalComponent').default);
Vue.component('questionnaire-create-edit', require('./vue-components/questionnaire/QuestionnaireCreateEdit').default);
Vue.component('questionnaire-languages', require('./vue-components/questionnaire/QuestionnaireLanguages').default);
Vue.component('questionnaire-display', require('./vue-components/questionnaire/QuestionnaireDisplay').default);
Vue.component('questionnaire-statistics', require('./vue-components/questionnaire/QuestionnaireStatistics').default);
Vue.component('crowd-sourcing-project-colors', require('./vue-components/crowd-sourcing-project/CrowdSourcingProjectColors').default);
Vue.component('translations-manager', require('./vue-components/common/TranslationsManager').default);

new Vue({
    el: '#app',
    store: store
});

(function () {

    window.language = languageBundle;
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

})();