require('datatables.net-bs');
require('datatables.net-buttons');

(function () {
    let updateFieldsInChangeStatusModal = function () {
        let parent = $(this).closest('tr');
        let questionnaireId = parent.data('id');
        let title = parent.data('title');
        let statusId = parent.data('status');
        $("#questionnaire-title").html(title);
        $("#questionnaire-id").val(questionnaireId);
        $("#status-select").val(statusId);
        $("#comments").val("");
    };

    let initEvents = function () {
        let body = $('body');
        body.on('click', '.change-status', updateFieldsInChangeStatusModal);
    };

    let initializeDataTable = function () {
        let table = $("#questionnaires-table");

        table.DataTable({
            destroy: true,
            "paging": true,
            "searching": true,
            "info": false,
            "columns": [
                { "width": "5%" },
                { "width": "25%" },
                { "width": "35%" },
                { "width": "10%" },
                { "width": "20%" }
            ]
        });
    };

    let init = function () {
        initEvents();
        initializeDataTable();
    };

    init();
})();