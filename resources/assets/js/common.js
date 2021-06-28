window.wa = {};
window.wa.enums = {};
window.swal = require('bootstrap-sweetalert');

require('icheck');

//if jquery ui is loaded make sure it doesnt conflict with bootstrap button
//$.widget.bridge('uibutton', $.ui.button);

//load dependencies for template
window.Popper = require('popper.js').default;
window.route = require('./backend-route');

require('./bootstrap');
require('fastclick');
require('admin-lte'); // 'admin-lte/dist/js/app.min.js'
require('select2');
require('bootstrap-tagsinput');
require('bootstrap-colorpicker');
require('bs4-summernote');
require('clipboard')
require('jquery-toast-plugin');

require('datatables.net');
require('datatables.net-bs4');
require('datatables.net-buttons');
require('datatables.net-buttons-bs4');

require( 'datatables.net-buttons/js/buttons.colVis.js' )();
require( 'datatables.net-buttons/js/buttons.html5.js' )();
require( 'datatables.net-buttons/js/buttons.flash.js' )();
require( 'datatables.net-buttons/js/buttons.print.js' )();
require('datatables.net-responsive');
require('datatables.net-responsive-bs4');
require('datatables.net-select');
require('datatables.net-select-bs4');

import Vue from 'vue';
import store from './store/store';

Vue.component('modal', require('./vue-components/common/ModalComponent').default);
Vue.component('questionnaire-create-edit', require('./vue-components/questionnaire/QuestionnaireCreateEdit').default);
Vue.component('questionnaire-display', require('./vue-components/questionnaire/QuestionnaireDisplay').default);

const app = new Vue({
    el: '#app',
    store: store
});

(function () {

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
        $('.color-picker').each(function (i, obj) {
            $(obj).colorpicker({
                horizontal: true
            });

            $(obj).on('colorpickerCreate', function (event) {
                $(obj).find('.input-group-addon').css('background-color', event.color.toString());
            });

            $(obj).on('colorpickerChange', function (event) {
                $(obj).find('.input-group-addon').css('background-color', event.color.toString());
            });
        });

    };

    let handleLogoutBtnClick = function () {
        $("#log-out").click(function (e) {
            e.preventDefault();
            $("#logout-form").submit();
        });
    }

    $(function () {
        $(document).ready(function () {
            initializeIcheck();
            closeDismissableAlerts();
            initializeSelect2Inputs();
            initializeColorPicker();
            handleLogoutBtnClick();
        });
    });
})();

