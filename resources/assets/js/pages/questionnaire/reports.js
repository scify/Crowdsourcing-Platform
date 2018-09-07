require('datatables.net-bs');
require('datatables.net-buttons');
require('datatables.net-buttons/js/dataTables.buttons');
require('datatables.net-buttons/js/buttons.html5');

(function () {

    let searchBtnHandler = function () {
        $("#searchBtn").on("click", function () {
            let criteria = {};
            criteria.projectId = $('select[name=project_id]').val();
            criteria.questionnaireId = $('select[name=questionnaire_id]').val();
            getReportsForCriteria(criteria);
        });
    };

    let triggerSearch = function () {
        $("#searchBtn").trigger( "click" );
    };

    let getReportsForCriteria = function(criteria) {
        $.ajax({
            method: "GET",
            url: $("#searchBtn").data("url"),
            cache: false,
            data: criteria,
            beforeSend: function () {
                $(".loader-container").removeClass('hidden');
                $("#errorMsg").addClass('hidden');
            },
            success: function (response) {
                parseSuccessData(response);
                $(".loader-container").addClass('hidden');
            },
            error: function (xhr, status, errorThrown) {
                $(".loader-container").addClass('hidden');
                $("#errorMsg").removeClass('hidden');
                $("#errorMsg").html(errorThrown);
            }
        });
    };

    let parseSuccessData = function(data) {
        let responseObj = JSON.parse(data);
        //if operation was unsuccessful
        if (responseObj.status === 2) {
            $(".loader").addClass('hidden');
            $("#errorMsg").removeClass('hidden');
            $("#errorMsg").html(responseObj.data);
            $("#results").html("");
        } else {
            $("#results").html("");
            $("#errorMsg").addClass('hidden');
            $(".loader").addClass('hidden');
            $("#results").html(responseObj.data);
            initializeDataTable();
        }
    };

    let initializeDataTable = function () {
        let usersTable = $("#usersTable");
        usersTable.DataTable({
            "paging": true,
            "searching": true,
            "pageLength": 15,
            "dom": 'Bfrtip',
            "buttons": [
                {
                    extend: 'csvHtml5',
                    text: 'Download as CSV'
                }

            ],
            "columns": [
                { "width": "5%" },
                { "width": "10%" },
                { "width": "5%" },
                { "width": "45%" },
                { "width": "5%" },
                { "width": "30%" }
            ],
            "initComplete": function(settings, json) {}
        });

        let answersTable = $("#answersTable");
        answersTable.DataTable({
            "paging": true,
            "searching": true,
            "pageLength": 15,
            "dom": 'Bfrtip',
            "buttons": [
                {
                    extend: 'csvHtml5',
                    text: 'Download as CSV'
                }

            ],
            "columns": [
                { "width": "5%" },
                { "width": "40%" },
                { "width": "5%" },
                { "width": "40%" },
                { "width": "10%" },
            ],
            "initComplete": function(settings, json) {}
        });
    };

    let init = function () {
        searchBtnHandler();
        triggerSearch();
    };

    $(document).ready(function() {
        init();
    });
})();