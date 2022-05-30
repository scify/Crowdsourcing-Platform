window.wa = {};
window.wa.enums = {};
window.swal = require('bootstrap-sweetalert');

require('icheck');

//if jquery ui is loaded make sure it doesnt conflict with bootstrap button
//$.widget.bridge('uibutton', $.ui.button);

//load dependencies for template
window.Popper = require('@popperjs/core');
window.route = require('./backend-route');

require('./bootstrap');
require('fastclick');
require('admin-lte'); // 'admin-lte/dist/js/app.min.js'
require('select2');
require('bootstrap-tagsinput');
require('bootstrap-colorpicker');


import 'summernote/dist/summernote-bs4';

require('jquery-slimscroll');
require('survey-creator');


require('datatables.net');
require('datatables.net-bs4');
require('datatables.net-buttons');
require('datatables.net-buttons-bs4');

require('datatables.net-buttons/js/buttons.colVis.js')();
require('datatables.net-buttons/js/buttons.html5.js')();
require('datatables.net-buttons/js/buttons.flash.js')();
require('datatables.net-buttons/js/buttons.print.js')();
require('datatables.net-responsive');
require('datatables.net-responsive-bs4');
require('datatables.net-select');
require('datatables.net-select-bs4');
import languageBundle
    from '@kirschbaum-development/laravel-translations-loader!@kirschbaum-development/laravel-translations-loader';
import Clipboard from "clipboard/dist/clipboard";

import Vue from 'vue';
import store from './store/store';
import {showToast} from "./common-utils";


Vue.component('modal', require('./vue-components/common/ModalComponent').default);
Vue.component('store-modal', require('./vue-components/common/StoreModalComponent').default);
Vue.component('questionnaire-create-edit', require('./vue-components/questionnaire/QuestionnaireCreateEdit').default);
Vue.component('questionnaire-languages', require('./vue-components/questionnaire/QuestionnaireLanguages').default);
Vue.component('questionnaire-display', require('./vue-components/questionnaire/QuestionnaireDisplay').default);
Vue.component('questionnaire-statistics', require('./vue-components/questionnaire/QuestionnaireStatistics').default);
Vue.component('crowd-sourcing-project-colors', require('./vue-components/crowd-sourcing-project/CrowdSourcingProjectColors').default);
Vue.component('translations-manager', require('./vue-components/common/TranslationsManager').default);

const app = new Vue({
    el: '#app',
    store: store
});

(function () {

    let initializeIcheck = function () {
        $('.icheck-input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    };


    let closeDismissableAlerts = function () {
        setTimeout(function () {
            /*Close any flash message after some time*/
            $(".alert-dismissable").fadeTo(4000, 500).slideUp(500, function () {
                $(".alert-dismissable").alert('close');
            });
        }, 3000);
    };

    let initializeSelect2Inputs = function () {
        $('.select2-tags').each(function (i, obj) {
            $(obj).select2({
                tags: true
            });
        });

        $('.select2').each(function (i, obj) {
            $(obj).select2();
        });
    };

    let initializeColorPicker = function () {
        $('.color-picker').each(function (i, el) {
            initSingleColorPicker(el);
        });
    };


    let handleLogoutBtnClick = function () {
        $("#log-out").click(function (e) {
            e.preventDefault();
            $("#logout-form").submit();
        });
    }

    let initClipboardElements = function () {
        const clipboard = new Clipboard(".copy-clipboard");

        clipboard.on('success', function (e) {
            showToast('Copied to clipboard!', '#28a745');
            e.clearSelection();
        });

        clipboard.on('error', function (e) {
            console.error(e);
            showToast('Error while copying to clipboard: ' + e.toString(), '#dc3545');
            e.clearSelection();
        });
    }

    let listenToReadMoreClicks = function () {
        const body = $('body');
        body.on('click', '.read-more', function (e) {
            $(this).siblings(".more-text").after('<a href="javascript:void(0);" class="read-less">Read less</a>');
            $(this).siblings(".more-text").removeClass('hidden');
            $(this).remove();
        });
        body.on('click', '.read-less', function (e) {
            $(this).siblings(".more-text").before('<a href="javascript:void(0);" class="read-more">Read more...</a>');
            $(this).siblings(".more-text").addClass('hidden');
            $(this).remove();
        });
    }

    let initializeTooltips = function () {
        $('[data-toggle="tooltip"]').tooltip();
    }
    $(function () {
        $(document).ready(function () {
            initializeIcheck();
            closeDismissableAlerts();
            initializeSelect2Inputs();
            initializeColorPicker();
            handleLogoutBtnClick();
            initClipboardElements();
            listenToReadMoreClicks();
            initializeTooltips();
        });
    });
})();


export function initSingleColorPicker(el) {
    $(el).colorpicker({
        horizontal: true
    });

    $(el).on('colorpickerCreate', function (event) {
        $(el).find('.input-group-addon').css('background-color', event.color.toString());
    });

    $(el).on('colorpickerChange', function (event) {
        $(el).find('.input-group-addon').css('background-color', event.color.toString());
    });
}

export function isObject(obj) {
    return obj != null && obj.constructor.name === "Object"
}

