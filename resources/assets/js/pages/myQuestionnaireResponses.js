let Survey = require('survey-jquery');

(function () {
    let survey;
    let initializeDataTable = function () {
        let usersTable = $("#responsesTable");
        if (usersTable.length)
            usersTable.DataTable({
                "paging": true,
                "searching": true,
                "responsive": true,
                "pageLength": 10,
                /* No ordering applied by DataTables during initialisation */
                "order": [],
                "columns": [
                    {"width": "20%"},
                    {"width": "20%"},
                    {"width": "40%"},
                    {"width": "10%"},
                    {"width": "10%"},
                ],
                "initComplete": function (settings, json) {
                }
            });
    };

    let viewResponseHandler = function (instance) {
        $('body').on('click', '.viewResponseBtn', function () {
            let responseId = $(this).data('responseid');
            showResponse(responseId);
        });
    };

    let showResponse = function (responseId) {
        let response = getResponseById(responseId);
        const responseModal = $("#questionnaireResponseModal");
        if (response) {
            responseModal.find("#questionnaireResponse").html("");
            responseModal.find("#questionnaireTitle").html(response.title);
            survey.setJsonObject(JSON.parse(response.questionnaire_json));
            survey.data = JSON.parse(response.response_json);
            survey.mode = 'display';
            survey.render("questionnaireResponse")
            survey.locale= response.language_code
            responseModal.modal();
        }
    };

    let getResponseById = function (responseId) {
        for (let i = 0; i < responses.length; i++)
            if (responses[i].questionnaire_response_id === responseId)
                return responses[i];
    };

    let init = function () {
        Survey.StylesManager.applyTheme("modern");
        survey = new Survey.Model();
        $(document).ready(function () {
            initializeDataTable();
            viewResponseHandler();
        });
    };

    $(document).ready(function () {
        init();
    });
})();
