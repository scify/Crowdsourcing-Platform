import Clipboard from "clipboard/dist/clipboard";
import toast from 'jquery-toast-plugin';

(function () {

    let init = function () {
        changeQuestionnaireStatusBtnHandler();
        initClipboardElements();
        initializeDataTable();

    };

    let changeQuestionnaireStatusBtnHandler = function () {
        $('body').on('click', '.change-status', updateFieldsInChangeStatusModal);
    };

    let updateFieldsInChangeStatusModal = function () {
        const parent = $(this).closest('tr');
        const questionnaireId = parent.data('id');
        const title = parent.data('title');
        const statusId = parent.data('status');
        $("#questionnaire-title").html(title);
        $("#questionnaire-id").val(questionnaireId);
        $("#status-select").val(statusId);
        $("#comments").val("");
    };

    let initClipboardElements = function () {
        const clipboard = new Clipboard(".copy-clipboard");
        ;

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

    let showToast = function (text, bgColor) {
        $.toast({
            text: text,
            showHideTransition: 'slide',  // It can be plain, fade or slide
            bgColor: bgColor,              // Background color for toast
            textColor: '#eee',            // text color
            allowToastClose: true,       // Show the close button or not
            hideAfter: 3000,              // `false` to make it sticky or time in miliseconds to hide after
            stack: 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
            textAlign: 'left',            // Alignment of text i.e. left, right, center
            position: 'top-right'       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
        })
    }

    let initializeDataTable = function () {
        let table = $("#questionnaires-table");

        table.DataTable({
            destroy: true,
            "paging": true,
            "responsive": true,
            "searching": true,
            "columns": [
                {"width": "5%"},
                {"width": "30%"},
                {"width": "10%"},
                {"width": "10%"},
                {"width": "20%"},
                {"width": "10%"},
                {"width": "5%"},
                {"width": "10%"},
            ]
        });
    };

    init();
})();
