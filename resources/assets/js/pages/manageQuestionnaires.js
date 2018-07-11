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

    let init = function () {
        initEvents();
    };

    init();
})();