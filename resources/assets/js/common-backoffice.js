import 'icheck';

import './bootstrap';
import 'fastclick';
import 'admin-lte'; // 'admin-lte/dist/js/app.min.js'
import 'select2';
import 'bootstrap-tagsinput';
import 'bootstrap-colorpicker';


import 'summernote/dist/summernote-bs4';

import 'jquery-slimscroll';
import 'survey-creator';


import 'datatables.net';
import 'datatables.net-bs4';
import 'datatables.net-buttons';
import 'datatables.net-buttons-bs4';

import * as colVis from 'datatables.net-buttons/js/buttons.colVis.js';
import * as html5Buttons from 'datatables.net-buttons/js/buttons.html5.js';
import * as flashButtons from 'datatables.net-buttons/js/buttons.flash.js';
import * as printButtons from 'datatables.net-buttons/js/buttons.print.js';
import 'datatables.net-responsive';
import 'datatables.net-responsive-bs4';
import 'datatables.net-select';
import 'datatables.net-select-bs4';
import Clipboard from "clipboard/dist/clipboard";

import {showToast} from "./common-utils";

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
            colVis();
            html5Buttons();
            flashButtons();
            printButtons();
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

