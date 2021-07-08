let Survey = require('survey-jquery');

window.QuestionnaireResponsesController = function(responses) {
    this.responses = responses;
    this.responseModal = $('#questionnaireResponseModal');
};

window.QuestionnaireResponsesController.prototype = function() {

    let initializeDataTable = function (instance) {
        let usersTable = $("#responsesTable");
        usersTable.DataTable({
            "paging": true,
            "searching": true,
            "responsive": true,
            "pageLength": 10,
            /* No ordering applied by DataTables during initialisation */
            "order": [],
            "columns": [
                { "width": "20%" },
                { "width": "20%" },
                { "width": "40%" },
                { "width": "10%" },
                { "width": "10%" },
            ],
            "initComplete": function(settings, json) {}
        });
    };

    let viewResponseHandler = function(instance) {
        $('body').on('click', '.viewResponseBtn', function () {
            let responseId = $(this).data('responseid');
            showResponse(instance, responseId);
        });
    };

    let showResponse = function(instance, responseId) {
        let response = getResponseById(instance.responses, responseId);
        if(response) {
            instance.responseModal.find("#questionnaireResponse").html("");
            instance.responseModal.find("#questionnaireTitle").html(response.title);
            let survey = new Survey.Model(JSON.parse(response.questionnaire_json));
            survey.data = JSON.parse(response.response_json);
            survey.mode = 'display';
            instance.responseModal.find("#questionnaireResponse").Survey({model: survey});
            instance.responseModal.modal();
        }
    };

    let getResponseById = function(responses, responseId) {
        for(let i = 0; i < responses.length; i++) {
            if(responses[i].questionnaire_response_id === responseId)
                return responses[i];
        }
    };

    let init = function() {
        let instance = this;
        $(document).ready(function() {
            initializeDataTable(instance);
            viewResponseHandler(instance);
        });
    };

    return {
        init: init
    };
}();
