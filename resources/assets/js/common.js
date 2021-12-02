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

require('jquery-toast-plugin');

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
import languageBundle from '@kirschbaum-development/laravel-translations-loader!@kirschbaum-development/laravel-translations-loader';
import Clipboard from "clipboard/dist/clipboard";

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

const app = new Vue({
    el: '#app',
    store: store
});

(function () {

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

    let listenToReadMoreClicks = function() {
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

    $(function () {
        $(document).ready(function () {
            initializeIcheck();
            closeDismissableAlerts();
            initializeSelect2Inputs();
            initializeColorPicker();
            handleLogoutBtnClick();
            initClipboardElements();
            listenToReadMoreClicks();
        });
    });
})();

export function arrayMove(arr, fromIndex, toIndex) {
    const element = arr[fromIndex];
    arr.splice(fromIndex, 1);
    arr.splice(toIndex, 0, element);
}

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

export function showToast(text, bgColor, position = 'top-right') {
    $.toast({
        text: text,
        showHideTransition: 'slide',  // It can be plain, fade or slide
        bgColor: bgColor,              // Background color for toast
        textColor: '#eee',            // text color
        allowToastClose: true,       // Show the close button or not
        hideAfter: 4000,              // `false` to make it sticky or time in miliseconds to hide after
        stack: 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
        textAlign: 'left',            // Alignment of text i.e. left, right, center
        position: position      // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
    })
}

export function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

export function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
